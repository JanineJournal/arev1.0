<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fiche;
use AppBundle\Entity\InfosPeriph;
use AppBundle\Entity\Peripherique;
use AppBundle\Entity\Radio;
use AppBundle\Entity\Secteur;
use DOMDocument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class EntreeSortieController extends Controller
{
/////////////////////////************************     INI  INTEGRATION        *********************************************//////////

    /**
     * Verification de l'existence du fichier .ini
     * @param Fiche $fiche
     * @return string
     */
    private function trouverIni( $fiche )
    {
        $lafiche = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Fiche')
            ->find($fiche);

        $radio = new Radio();
        $fiche->setRadio($radio);

        $x = "";
        while (false ==
            file_exists('/wamp64/www/vera/web/ini/' . $x . $lafiche->getCoderacco() . '.ini')) {     //   ICI PROBLEME QUAND EDITER........
            $x = substr($x, 0, 0) . '0' . substr($x, 0, 1);
            //var_dump('/wamp64/www/raccoctobre/web/ini/'.$x.$lafiche->getCodeRacco().'.ini');
        }
        var_dump('/wamp64/www/vera/web/ini/' . $x . $lafiche->getCoderacco() . '.ini');
        return '/wamp64/www/vera/web/ini/' . $x . $lafiche->getCoderacco() . '.ini';
    }

    /**
     * @Route("/racco/afficherINI/{id}", name="afficherINI")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Fiche $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public
    function afficherINI(Fiche $id)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository(Fiche::class)->find($id);

/// je cherche le fichier INI si je ne le connais pas déjà
        if ($fiche->getProgrammation() == '') {
            $cheminINI = $this->trouverIni($fiche);
            $fiche->setProgrammation($cheminINI);
        }

//initialisation du tableau à parcourir correspondant au INI
        $tableauINI = array();

// file — Lit le fichier et renvoie le résultat dans un tableau
        $inifile = file($fiche->getProgrammation());
// Parcours du fichier ini, ligne par ligne, pour affichage
        foreach ($inifile as $ligne) {
            $tabligne = explode("=", $ligne, 2); //explode(separator,string,limit)
            if (isset($tabligne[1])) {
                $tableauINI[$tabligne[0] . ''] = $tabligne[1] . '';
            }
        }
        $compteur = sizeof($tableauINI);   // var_dump($tableauINI);

        if ($compteur > 0) {      //traitement INI = fonction ci-dessous pour vider les secteurs et périph et réédités après envoi Centrale
            $this->traitementINI($fiche, $tableauINI);
        }

        return $this->render('/fiche/tableauINI.html.twig', array(
            'lignes' => $tableauINI,
            'compteur' => $compteur,
            'fiche' => $id,
        ));
    }

    public function traitementINI(Fiche $fiche, array $tableauINI)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository(Fiche::class)->find($fiche);

        //Remettre à zéro les ZONES liées à l'ini pour retrouver suite à un nouveau 6X9
        $zonesIni = $fiche->getSecteur();
        foreach ($zonesIni as $secteur) {
            $fiche->removeSecteur($secteur);
        }

        $periphINI = $em->getRepository(Peripherique::class)
            ->findBy(array('additionnel' => false, 'idFiche' => $fiche->getId()));
        foreach ($periphINI as $peri) {
            $em->remove($peri);
            $em->flush();
        }

        //mon premier n° de peripherique ; s'incrémentera dans boucle de recherche et création des périphériques
        $p = 1;

        //nombre d'erreurs
        $x = 0;

        //nous allons encapsuler les fonctions dans des conditions d'erreur. Le nombre d'erreurs (x) doit rester égal à zéro pour que tout se
        //soit bien passé. Dans le cas contraire, une notice apparaitra.
        /*
        if ($combienZ == 0) {
            $x++;
            $this->addFlash(
                'notice',
                'SECTEUR OU ZONE');
        };
        if ($x > 0) {
            $this->addFlash(
                'notice',
                'Erreur(s) lors de l'appel au fichier INI : ');
            return $this->redirectToRoute('editerFiche', array('id' => $fiche->getId()));
        }
*/

        //tableau de deux colonnes affichant les données de l'INI .
        // Il a nécessairement au moins une ligne si je suis dans cette fonction
        foreach ($tableauINI as $cle => $valeur) {
            for ($k = 1; $k < 5; $k++) {
                if (strcmp($cle, 'ZoneName_'.$k) == 0) {
                    //    var_dump('$zone'.$k);
                    $varZone = new Secteur();
                    $varZone->setNom($valeur);
                    $varZone->setNumero($k);
                    $fiche->addSecteur($varZone);
                    $em->persist($fiche);
                    $em->flush();
                }
            }
            // Affichage var_dump($cle); var_dump($valeur);
            if (strcmp($cle, 'Version') == 0) {
                $fiche->setVersion($valeur);
            } elseif (strcmp($cle, 'SerialNumber') == 0) {
                $fiche->setNumserieCentrale($valeur);
            } elseif (strcmp($cle, 'DomainNameFrontelPO2') == 0) {
                $fiche->setTsvsecours($valeur);
            } elseif (strcmp($cle, 'DomainNameFrontelPO1') == 0) {
                $fiche->setCentretsv($valeur);
            } elseif (strcmp($cle, 'AccessPointNumber') == 0) {
                $fiche->getRadio()->setOperateurSim($valeur);
            } elseif (strcmp($cle, 'ModeSP1') == 0) {
                $optionspartielleparzone = preg_replace('/\s+/', "", $valeur);   // string de 4 caractères = zones (A = armé, D = désarmé, E = extérieur, P = périmétrique)
                //var_dump($optionspartielleparzone);
                $secteurs = $em->getRepository('AppBundle:Secteur')->findByFiche($fiche);
                foreach ($secteurs as $unsecteur) {
                    switch ($unsecteur->getNumero()) {
                        case 1:
                            $unsecteur->setSp1(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 2:
                            $unsecteur->setSp1(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 3:
                            $unsecteur->setSp1(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 4:
                            $unsecteur->setSp1(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                    }
                }
            } elseif (strcmp($cle, 'ModeSP2') == 0) {   // c'est ok car cette ligne vient après la décla des zones dans le INI
                $optionspartielleparzone = preg_replace('/\s+/', "", $valeur);   // string de 4 caractères = zones (A = armé, D = désarmé, E = extérieur, P = périmétrique)
                // var_dump($optionspartielleparzone);
                $secteurs = $em->getRepository('AppBundle:Secteur')->findByFiche($fiche);
                foreach ($secteurs as $unsecteur) {
                    switch ($unsecteur->getNumero()) {
                        case 1:
                            $unsecteur->setSp2(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 2:
                            $unsecteur->setSp2(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 3:
                            $unsecteur->setSp2(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                        case 4:
                            $unsecteur->setSp2(substr($optionspartielleparzone, $unsecteur->getNumero() - 1, 1));
                            break;
                    }
                }
            } elseif (strcmp($cle, 'dev_SN_' . $p) == 0) {
                if (substr_count($valeur, '00000000') < 1) {   // si 8 zéros se suivent dans la colonne suivante alors j'entre pas dans la condition
                    $this->creationperipheriqueINI($fiche, $p, $valeur);
                    $p++;
                }
            }
        }

// Correspondance entre le périphérique et une zone : 3e caractère du num "DEVICE_num" si ne contient pas de virgule,
        //POUR le code transmis
        // je dois lire si loc = clavier et aussi zone tempo = clavier

// Penser aux codes transmis par la centrale vers m1

        $this->traitementINI2($fiche, $tableauINI); // appel aux autres fonctions pour remplir les attributs des periph créés
        $this->localisationPeriph($fiche, $tableauINI);
        $this->refPeriph($fiche, $tableauINI);
        $this->fintraitement($fiche, $tableauINI);

        if ($x > 0) {
            $this->addFlash(
                'notice',
                'Erreur(s) lors de l\'appel au fichier INI : ');
            return $this->redirectToRoute('nouvelleFiche', array('id' => $fiche->getId()));
        }
        $em->persist($fiche);
        $em->flush();
    }

    public function creationperipheriqueINI($fiche, $p, $valeur)
    {
        $em = $this->getDoctrine()->getManager();
        $ficheF = $em->getRepository(Fiche::class)->find($fiche);

        $varPeriph = new Peripherique();
        $varPeriph->setNumIni($p);
        $varPeriph->setNumserie(preg_replace('/\s+/', "", $valeur));
        $varPeriph->setAdditionnel(false);
        $varPeriph->setIdFiche($ficheF->getId());
        $em->getRepository('AppBundle:Peripherique');
        $em->persist($varPeriph);
        $em->flush();
        //    var_dump($varPeriph->getId());
    }

    public function traitementINI2(Fiche $id, array $tableauINI)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository(Fiche::class)->find($id);

        $init = 0;

        foreach ($tableauINI as $cle => $valeur) {
            if (strcmp($cle, 'Zone_'.$init) == 0) {
                $periphbdd = $em->getRepository(Peripherique::class)
                    ->findBy(array('numIni' => $init, 'additionnel' => false, 'idFiche' => $fiche->getId()));
                if (isset($periphbdd)) {
                    foreach ($periphbdd as $perip) {
                        $numZone = (int)$valeur + 1; //casté et + 1 pour avoir la valeur de la zone dans laquelle est le periph
                        $secteur = $em->getRepository(Secteur::class)
                            ->getZonebyficheandNum($numZone, $fiche->getId());
                        $secteur->addPeripherique($perip);
                        $em->persist($secteur);
                    }
                    $init++;
                }
            }
        }
    }

    public function localisationPeriph(Fiche $id, array $tableauINI)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository(Fiche::class)->find($id);
        $init = 0;

        foreach ($tableauINI as $cle => $valeur) {
            if (strcmp($cle, 'DeviceName_' . $init) == 0) {
                $periphbdd = $em->getRepository(Peripherique::class)
                    ->findBy(array('numIni' => $init, 'additionnel' => false, 'idFiche' => $fiche->getId()));

                if (isset($periphbdd)) {
                    foreach ($periphbdd as $perip) {
                        $localisation = $valeur;
                        $perip->setLocalisation($localisation);
                        $em->persist($perip);
                    }
                    $init++;
                }
            }
        }
    }

    public function refPeriph(Fiche $id, array $tableauINI)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository(Fiche::class)->find($id);
        $init = 0;

        foreach ($tableauINI as $cle => $valeur) {

            if (strcmp($cle, 'Device_' . $init) == 0) {
                $periphbdd = $em->getRepository(Peripherique::class)
                    ->findBy(array('numIni' => $init, 'additionnel' => false, 'idFiche' => $fiche->getId()));

                if (isset($periphbdd)) {
                    foreach ($periphbdd as $perip) {
                        if (strpos($perip->getLocalisation(), 'CLAVIER') !== false) {
                            $perip->setCodeTransmis('Aucun');
                            $perip->getSecteur()->setTempo(true);
                        }
// ici je connais le clavier et peux donc lui associer la zone temporisée et ses attributs ; je peux aussi mettre son code transmis à null ou zéro
                        $numserie = (substr($valeur, -4, 2) . substr($valeur, -6, 2)); //doubleduo

                        //dans l'autre champ du periph
                        $ns = $perip->getNumSerie();

                        $premiercar = substr($ns, 0, 1); //langue
                        $troisetquatre = substr($ns, 2, 2); //options

                        $correspInfosPeriph = $em->getRepository(InfosPeriph::class)
                            ->findOneBy(array('langue' => $premiercar, 'numSerie' => $numserie, 'options' => $troisetquatre));
                        //var_dump( $correspInfosPeriph->getId());

                        $perip->setNom($correspInfosPeriph->getPrefixe() . '  ' . $perip->getLocalisation());
                        $perip->setType('' . $correspInfosPeriph->getLibelle() . ' - ' . $correspInfosPeriph->getRefElixir());

                        $ref = $valeur;
                        $perip->setReference($ref);
                        $em->persist($perip);
                    }
                    $init++;
                }
            }
        }
    }

    private function fintraitement(Fiche $fiche, array $tableauINI)
    {
        $em = $this->getDoctrine()->getManager();
        $secteurspourtempo = $em->getRepository(Secteur::class)->findByFiche($fiche);
        foreach ($secteurspourtempo as $tempo) {
            if ($tempo->getTempo() == true) {
                $thezonetempo = $em->getRepository(Secteur::class)->find($tempo->getId());

                foreach ($tableauINI as $cle => $valeur) {
                    if (strcmp($cle, 'TimerPreArmement') == 0) {
                        $thezonetempo->setSortie($valeur);
                    } elseif (strcmp($cle, 'TimerPreAlerte') == 0) {
                        $thezonetempo->setEntree($valeur);
                    }
                }
            }
        }
    }

///******    CREATION DU XML DE SORTIE     *****////


//Un noeud XML est toujours créé avec la méthode createElement().
// Ensuite, on ajoute le noeud à son noeud parent avec la méthode appendChild().
// Ces deux méthodes appartiennent à la classe de DOMDocument.

    /**
     * Exporter XML
     *
     * @Route("/racco/exportXML/{id}", name="genererXML")
     */
    public function exporterXML(Fiche $id)
    {
        $date = new \DateTime();
        $date = $date->format('d-m-Y');

        $em = $this->getDoctrine()
            ->getManager();

        $ficheexportee = $em->getRepository('AppBundle:Fiche')->find($id);

        $coderacco = $ficheexportee->getCoderacco();

        $xml_doc = new DOMDocument('1.0', 'ISO-8859-1');
        $xml_doc->formatOutput = true;
        $xml_doc->appendChild($site_node = $xml_doc->createElement('SITE'));

// La variable $site_node identifie le noeud "SITE"
// Cela va nous permettre d'y ajouter les noeuds "donnees generales" etc

        $site_node->appendChild($donnees_node = $xml_doc->createElement('DONNEES_GENERALES'));

        $donnees_node->appendChild($xml_doc->createElement('Code_Racco', $coderacco));
        //var_dump($ficheexportee->getLocalisationCentrale());

	    $site = $ficheexportee->getSite();

        $donnees_node->appendChild($xml_doc->createElement('Nom_client', $site->getNomsite()));
        // $donnees_node->appendChild($xml_doc->createElement('Prénom_client', $ficheexportee->getSite()->getNomsite()));
         $donnees_node->appendChild($xml_doc->createElement('Prénom_client', ''));
        $donnees_node->appendChild($xml_doc->createElement('Adresse1', $ficheexportee->getSite()->getAdresseSite01()));
        //$donnees_node->appendChild($xml_doc->createElement('Adresse2', $ficheexportee->getSite()->getAdresseSite02()));
        $donnees_node->appendChild($xml_doc->createElement('Adresse2', ''));
        $donnees_node->appendChild($xml_doc->createElement('CP', $ficheexportee->getSite()->getCodePostalSite()));
        $donnees_node->appendChild($xml_doc->createElement('Ville', $ficheexportee->getSite()->getVilleSite()));
        $donnees_node->appendChild($xml_doc->createElement('Téléphone', $ficheexportee->getSite()->getNumtel1()));
        $donnees_node->appendChild($xml_doc->createElement('Commentaires_Adresse', ''));
        $donnees_node->appendChild($xml_doc->createElement('Code_client', $ficheexportee->getSite()->getCodeSite()));
        $donnees_node->appendChild($xml_doc->createElement('Commande', $ficheexportee->getNumCommande()));
        $donnees_node->appendChild($xml_doc->createElement('Date', $ficheexportee->getDate()->format('d/m/Y')));
        $donnees_node->appendChild($xml_doc->createElement('Technicien', $ficheexportee->getTechnicien()));
        $donnees_node->appendChild($xml_doc->createElement('MDP', $ficheexportee->getMdpclient()));
        $donnees_node->appendChild($xml_doc->createElement('Saisi_par', $ficheexportee->getOperateurtp()));
        $donnees_node->appendChild($xml_doc->createElement('Type_client', $ficheexportee->getSite()->getClient()->getType()));

        $site_node->appendChild($emplacements_node = $xml_doc->createElement('EMPLACEMENTS'));

        $emplacements_node->appendChild($xml_doc->createElement('Emplacement_Ctrle', $ficheexportee->getLocalisationCentrale()));
        $radio = $ficheexportee->getRadio();
        $emplacements_node->appendChild($xml_doc->createElement('Emplacement_Disj', $radio->getEmplacementdisj()));
        $emplacements_node->appendChild($xml_doc->createElement('Emplacement_Clav', $radio->getEmplacementClavier()));
        $emplacements_node->appendChild($xml_doc->createElement('Emplacement_HP', $radio->getEmplacementHP()));

        $site_node->appendChild($habilites_node = $xml_doc->createElement('HABILITES'));

        $habilites = $em->getRepository('AppBundle:Habilite')->findBy(array("fiche" => $id));

        $pn = 1;
        foreach ($habilites as $h) {
            $habilites_node->appendChild($hab = $xml_doc->createElement('Habilité' . ($pn), ''));
                $hab->appendChild($xml_doc->createElement('Civilité', $h->getCivilite()));
                $hab->appendChild($xml_doc->createElement('Nom', $h->getNomhabili()));
                $hab->appendChild($xml_doc->createElement('Prénom', $h->getPrenomhabili()));
                $hab->appendChild($xml_doc->createElement('Mdp', $h->getMdphabili()));
                $hab->appendChild($xml_doc->createElement('Tel_Port', $h->getNumtel2()));
                $hab->appendChild($xml_doc->createElement('Tel_Pro', $h->getNumtel3()));
                // getNum4 ne part pas?
                $hab->appendChild($xml_doc->createElement('Tel_Dom', $h->getNumtel()));
                $hab->appendChild($xml_doc->createElement('Type', $h->getTypehabili()));
            $pn++;
        };

        for ($i = $pn; $i < 8; $i++) {
            $habilites_node->appendChild($hab = $xml_doc->createElement('Habilité' . ($i), ''));
                $hab->appendChild($xml_doc->createElement('Civilité', ''));
                $hab->appendChild($xml_doc->createElement('Nom', ''));
                $hab->appendChild($xml_doc->createElement('Prénom', ''));
                $hab->appendChild($xml_doc->createElement('Mdp', ''));
                $hab->appendChild($xml_doc->createElement('Tel_Port', ''));
                $hab->appendChild($xml_doc->createElement('Tel_Pro', ''));
                $hab->appendChild($xml_doc->createElement('Tel_Dom', ''));
                $hab->appendChild($xml_doc->createElement('Type', ''));
        }

        // var_dump($habilites_node);

        $site_node->appendChild($infoRSI = $xml_doc->createElement('INFO_RSI'));

        $infoRSI->appendChild($xml_doc->createElement('No_série_centrale', $ficheexportee->getNumserieCentrale()));
        $infoRSI->appendChild($xml_doc->createElement('Trans_TSV', $ficheexportee->getCentretsv()));
        $infoRSI->appendChild($xml_doc->createElement('Trans_secours', $ficheexportee->getTsvsecours()));
        $infoRSI->appendChild($xml_doc->createElement('Trans_TP', 'www.ctcamgprstp.dnsalias.net'));
        $infoRSI->appendChild($xml_doc->createElement('Trans_User', ''));
        $infoRSI->appendChild($xml_doc->createElement('Trans_Password', ''));
        $infoRSI->appendChild($xml_doc->createElement('APN', $radio->getOperateurSim()));
        $infoRSI->appendChild($xml_doc->createElement('Type_Centrale', $ficheexportee->getTypeCentrale()));

        $infoRSI->appendChild($users = $xml_doc->createElement('Utilisateurs', ''));





/*
        $users->appendChild($user1 = $xml_doc->createElement('Utilisateur1', ''));
        $user1->appendChild($xml_doc->createElement('Type', 'Code'));
        $user1->appendChild($xml_doc->createElement('Code', '7285'));
        $user1->appendChild($xml_doc->createElement('Nom', '72F'));

        $users->appendChild($user2 = $xml_doc->createElement('Utilisateur2', ''));
        $user2->appendChild($xml_doc->createElement('Type', 'Badge'));
        $user2->appendChild($xml_doc->createElement('Code', '1C77E7C50000'));
        $user2->appendChild($xml_doc->createElement('Nom', 'N:1'));
        $users->appendChild($user3 = $xml_doc->createElement('Utilisateur3', ''));
        $user3->appendChild($xml_doc->createElement('Type', 'Badge'));
        $user3->appendChild($xml_doc->createElement('Code', '0BF8D4D40000'));
        $user3->appendChild($xml_doc->createElement('Nom', 'N:2'));
        $users->appendChild($user4 = $xml_doc->createElement('Utilisateur4', ''));
        $user4->appendChild($xml_doc->createElement('Type', 'Badge'));
        $user4->appendChild($xml_doc->createElement('Code', 'A53C12970000'));
        $user4->appendChild($xml_doc->createElement('Nom', 'N:3'));
        $users->appendChild($user5 = $xml_doc->createElement('Utilisateur5', ''));
        $user5->appendChild($xml_doc->createElement('Type', 'Badge'));
        $user5->appendChild($xml_doc->createElement('Code', '1C77CB150000'));
        $user5->appendChild($xml_doc->createElement('Nom', 'N:4'));
        $users->appendChild($user6 = $xml_doc->createElement('Utilisateur6', ''));
        $user6->appendChild($xml_doc->createElement('Type', 'Code'));
        $user6->appendChild($xml_doc->createElement('Code', '1308'));
        $user6->appendChild($xml_doc->createElement('Nom', 'GENERAL'));
        $users->appendChild($user7 = $xml_doc->createElement('Utilisateur7', ''));
        $user7->appendChild($xml_doc->createElement('Type', 'Code'));
        $user7->appendChild($xml_doc->createElement('Code', '0903'));
        $user7->appendChild($xml_doc->createElement('Nom', 'RESERVE'));
        $users->appendChild($user8 = $xml_doc->createElement('Utilisateur8', ''));
        $user8->appendChild($xml_doc->createElement('Type', 'Code'));
        $user8->appendChild($xml_doc->createElement('Code', '2222'));
        $user8->appendChild($xml_doc->createElement('Nom', 'SMS'));
*/


        $infoRSI->appendChild($xml_doc->createElement('SIM_Op', '-1')); //VERIFIER !!!!!
        $infoRSI->appendChild($xml_doc->createElement('SIM_Tél', $radio->getNumTelsim()));
        $infoRSI->appendChild($xml_doc->createElement('SIM_Serial', $radio->getNumSeriesim()));

        $zones = $em->getRepository('AppBundle:Secteur')->findBy(array("fiche" => $id));

        $z=1;
        foreach ($zones as $unezone) {
            $infoRSI->appendChild($xml_doc->createElement('Zone_'.$z.'_Nom', $unezone->getNom().''));
            $z++;
        };

        /*  $infoRSI->appendChild($xml_doc->createElement('Zone_1_Nom', 'ENT-SEJOUR'));
        $infoRSI->appendChild($xml_doc->createElement('Zone_2_Nom', 'COULOIR'));
        $infoRSI->appendChild($xml_doc->createElement('Zone_3_Nom', 'CELLIER'));
        $infoRSI->appendChild($xml_doc->createElement('Zone_4_Nom', 'ZONE  4'));
    */
        $y=1;
        foreach ($zones as $unezone) {
            if ($unezone->getTempo() == '1'){
                $infoRSI->appendChild($xml_doc->createElement('Zone'.$y.'_Tempo', 'True'));
                $tempoIn = $unezone->getEntree();
                $tempoOut = $unezone->getSortie();
            }
            else {
                $infoRSI->appendChild($xml_doc->createElement('Zone'.$y.'_Tempo', 'False'));
            }
            $y++;
        };

        $x=1;
        foreach ($zones as $unezone) {
            if ($unezone->getSp1() == 'A'){
                $infoRSI->appendChild($xml_doc->createElement('Zone'.$x.'_SP1', 'True'));
            }
            else {
                $infoRSI->appendChild($xml_doc->createElement('Zone'.$x.'_SP1', 'False'));
            }
            $x++;
        };

        $infoRSI->appendChild($xml_doc->createElement('Tempo_Entrée', (int)$tempoIn));
        $infoRSI->appendChild($xml_doc->createElement('Tempo_Sortie', (int)$tempoOut));

       // $ficheexportee->getPeripherique();

        $infoRSI->appendChild($peripheriq = $xml_doc->createElement('Périphériques', ''));


// A VERIFIER !!

	    $peripheriquesdelafiche = $em->getRepository('AppBundle:Peripherique')->findByIdFiche($id);

	    $site_node->appendChild($habilites_node = $xml_doc->createElement('HABILITES'));

	    $per = 1;
	    foreach ($peripheriquesdelafiche as $p) {
		    $peripheriq->appendChild($peri = $xml_doc->createElement('Périphérique'.($per), ''));
		    $peri->appendChild($xml_doc->createElement('Description', $p->getQCH()));
		    $peri->appendChild($xml_doc->createElement('ELIXIR', $p->getQCH()));
		    $peri->appendChild($xml_doc->createElement('Type',$p->getQCH()));
		    $peri->appendChild($xml_doc->createElement('Code', $p->getQCH()));
		    $peri->appendChild($xml_doc->createElement('Zone', $p->getQCH()));
		    $peri->appendChild($xml_doc->createElement('Tempo', $p->getQCH()));
		    // getNum4 ne part pas?
		    $pn++;
	    };

	    //a effacer si ma boucle est OK
        $peripheriq->appendChild($peri1 = $xml_doc->createElement('Périphérique1', ''));
        $peri1->appendChild($xml_doc->createElement('Description', 'CLAVIER 1'));
        $peri1->appendChild($xml_doc->createElement('ELIXIR', 'CO0354'));
        $peri1->appendChild($xml_doc->createElement('Type', 'XMB 210'));
        $peri1->appendChild($xml_doc->createElement('Code', ''));
        $peri1->appendChild($xml_doc->createElement('Zone', '1'));
        $peri1->appendChild($xml_doc->createElement('Tempo', 'X'));
        $peripheriq->appendChild($peri2 = $xml_doc->createElement('Périphérique2', ''));
        $peri2->appendChild($xml_doc->createElement('Description', 'CAMERA ENT-SEJOUR'));
        $peri2->appendChild($xml_doc->createElement('ELIXIR', 'DE0971'));
        $peri2->appendChild($xml_doc->createElement('Type', 'ISMV 200'));
        $peri2->appendChild($xml_doc->createElement('Code', '30'));
        $peri2->appendChild($xml_doc->createElement('Zone', '1'));
        $peri2->appendChild($xml_doc->createElement('Tempo', 'X'));
        $peripheriq->appendChild($peri3 = $xml_doc->createElement('Périphérique3', ''));
        $peri3->appendChild($xml_doc->createElement('Description', 'CAMERA COULOIR'));
        $peri3->appendChild($xml_doc->createElement('ELIXIR', 'DE0971'));
        $peri3->appendChild($xml_doc->createElement('Type', 'ISMV 200'));
        $peri3->appendChild($xml_doc->createElement('Code', '31'));
        $peri3->appendChild($xml_doc->createElement('Zone', '2'));
        $peri3->appendChild($xml_doc->createElement('Tempo', ''));
        $peripheriq->appendChild($peri4 = $xml_doc->createElement('Périphérique4', ''));
        $peri4->appendChild($xml_doc->createElement('Description', 'OUV COP CELLIER'));
        $peri4->appendChild($xml_doc->createElement('ELIXIR', 'CO0354'));
        $peri4->appendChild($xml_doc->createElement('Type', 'XMB 210'));
        $peri4->appendChild($xml_doc->createElement('Code', '32'));
        $peri4->appendChild($xml_doc->createElement('Zone', '3'));
        $peri4->appendChild($xml_doc->createElement('Tempo', ''));
        $peripheriq->appendChild($peri5 = $xml_doc->createElement('Périphérique5', ''));
        $peri5->appendChild($xml_doc->createElement('Description', 'SITP ESCAL.ETG'));
        $peri5->appendChild($xml_doc->createElement('ELIXIR', 'DI5110'));
        $peri5->appendChild($xml_doc->createElement('Type', 'SEV 200'));
        $peri5->appendChild($xml_doc->createElement('Code', ''));
        $peri5->appendChild($xml_doc->createElement('Zone', '1'));
        $peri5->appendChild($xml_doc->createElement('Tempo', 'X4'));
        $peripheriq->appendChild($peri6 = $xml_doc->createElement('Périphérique6', ''));
        $peri6->appendChild($xml_doc->createElement('Description', 'TELECOMMANDE 1'));
        $peri6->appendChild($xml_doc->createElement('ELIXIR', 'CO0834'));
        $peri6->appendChild($xml_doc->createElement('Type', 'KF240'));
        $peri6->appendChild($xml_doc->createElement('Code', ''));
        $peri6->appendChild($xml_doc->createElement('Zone', '1'));
        $peri6->appendChild($xml_doc->createElement('Tempo', 'X'));
        $peripheriq->appendChild($peri7 = $xml_doc->createElement('Périphérique7', ''));
        $peri7->appendChild($xml_doc->createElement('Description', 'TELECOMMANDE 2'));
        $peri7->appendChild($xml_doc->createElement('ELIXIR', 'CO0834'));
        $peri7->appendChild($xml_doc->createElement('Type', 'KF240'));
        $peri7->appendChild($xml_doc->createElement('Code', ''));
        $peri7->appendChild($xml_doc->createElement('Zone', '1'));
        $peri7->appendChild($xml_doc->createElement('Tempo', 'X'));
        $peripheriq->appendChild($peri8 = $xml_doc->createElement('Périphérique8', ''));
        $peri8->appendChild($xml_doc->createElement('Description', ''));
        $peri8->appendChild($xml_doc->createElement('ELIXIR', ''));
        $peri8->appendChild($xml_doc->createElement('Type', ''));
        $peri8->appendChild($xml_doc->createElement('Code', ''));
        $peri8->appendChild($xml_doc->createElement('Zone', ''));
        $peri8->appendChild($xml_doc->createElement('Tempo', ''));

//(PENSER AUX PERIPHERIQUES DE 9 A 25)

		    for ($i = $per; $i < 26; $i++) {
			    $peripheriq->appendChild($peri = $xml_doc->createElement('Périphérique'.($i), ''));
			    $peri->appendChild($xml_doc->createElement('Description', ''));
			    $peri->appendChild($xml_doc->createElement('ELIXIR', ''));
			    $peri->appendChild($xml_doc->createElement('Type', ''));
			    $peri->appendChild($xml_doc->createElement('Code', ''));
			    $peri->appendChild($xml_doc->createElement('Zone', ''));
			    $peri->appendChild($xml_doc->createElement('Tempo', ''));
		    }


        $xml_string = $xml_doc->saveXML();

       // $xml_doc->save('XML/' . $date.'_'.$coderacco . '.xml');

        return $this->render('exportxml.html.twig', array('xml' => $xml_string));


    }
}