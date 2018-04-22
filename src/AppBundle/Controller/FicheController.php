<?php

namespace AppBundle\Controller;

use AnalyticsBundle\Entity\ClientAx;
use AnalyticsBundle\Entity\DirpartyTable;
use AnalyticsBundle\Entity\SvcCallTable;
use AppBundle\Entity\Site;
use AppBundle\Form\PeripheriqueType;
use AppBundle\Repository\ParametreRepository;
use AppBundle\Service\BlankFiche;
use AppBundle\Service\CusttableService;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Client;
use AppBundle\Entity\Comptevideo;
use AppBundle\Entity\Fiche;
use AppBundle\Entity\Peripherique;
use AppBundle\Entity\Secteur;
use AppBundle\Form\AppsmartphoneType;
use AppBundle\Form\FicheType;
use AppBundle\Form\FilaireType;
use AppBundle\Form\HabiliteType;
use AppBundle\Form\RadioType;
use AppBundle\Form\SiteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class FicheController extends Controller
{
	/**
	 * @Route("/racco/choix", name="choix")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function choix(Request $request)
    {
	    $form = $this->createFormBuilder()
	                 ->add("coderacco", NumberType::class)
	                 ->add('OK', SubmitType::class, array(
		                 'attr' => array('class' => 'btn text-center'), 'label' => 'ok'))
	                 ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $coder = $form->getData()["coderacco"];          //code récupéré dans le form

	        $fichescherchees = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Fiche')->findBy(array('coderacco' => $coder), array('date' => 'desc'), null, 0);

            return $this->render('fiche/creer.html.twig', array(
                'form' => $form->createView(),
                'coderacco' => $coder,
                'choix' => "ok",
                'fichescherchees' => $fichescherchees));
        }

        return $this->render('fiche/creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * CHOIX DU CLIENT QUAND CREA NOUVELLE FICHE AVEC CODE RACCO
     *
     * @Route("/racco/rechercheclient/{code}", name="rechclientAX")
     * @param $code
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rechercheclient(Request $request, $code, CusttableService $custtable_service, BlankFiche $blank_fiche)
    {
	    $coderaccowithpipes = $custtable_service->formaterpipes($code);

        $em1 = $this->getDoctrine()->getManager('analytics');
        $sites = $em1->getRepository(ClientAx::class)->myfindSite($coderaccowithpipes);
        $number = count($sites);
	    $em2 = $this->getDoctrine()->getManager('default');
	    $operateurTP = $this->getUser()->getUsername();

        if ($number > 1) {
            $form = $this->createFormBuilder()
                ->add("clientax", EntityType::class, array(
                    'class' => 'AnalyticsBundle:ClientAx',
                    'choices' => $sites,
                    'placeholder' => '' . $number . ' sites trouvés, Choisir : ',
                    'label' => false))
                ->add('ok', SubmitType::class, array(
                    'attr' => array('class' => 'btn text-center'), 'label' => 'ok'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
	            $fichevierge = $blank_fiche->nouvelleFiche($code);
	            $fichevierge->setOperateurTP($operateurTP);

	            $em2->persist($fichevierge);
	            $em2->flush();

                $siteoriginel = $form->get('clientax')->getData();
                $invoiceAccountSite = $siteoriginel->getInvoiceaccount();
                $clientdusite = $em1->getRepository(ClientAx::class)->myfindClient($invoiceAccountSite);

	            $tabFicheClientSite = $custtable_service->completerclient( $fichevierge, $siteoriginel, $clientdusite);
	            foreach ($tabFicheClientSite as $entite) {
		            $em2->persist( $entite );
		            $em2->flush();
	            }
                return $this->redirectToRoute('nouvelleFiche', array('id' => $fichevierge->getId()));
            }
            return $this->render( 'visiteur/clients.html.twig', array(
                'clients' => $sites,
                'form' => $form->createView()));

        } elseif ($number == 1) {
	        $siteoriginel = (object) $sites[0];
            $invoiceAccountSite = $siteoriginel->getInvoiceaccount();
            $clientdusite = $em1->getRepository(ClientAx::class)->myfindClient($invoiceAccountSite);

		        $fichevierge = $blank_fiche->nouvelleFiche($code);
		        $fichevierge->setOperateurTP($operateurTP);

		        $em2->persist($fichevierge);
		        $em2->flush();

		        $tabFicheClientSite = $custtable_service->completerclient( $fichevierge, $siteoriginel, $clientdusite);
		        foreach ($tabFicheClientSite as $entite) {
			        $em2->persist( $entite );
			        $em2->flush();
		        }
            return $this->redirectToRoute('nouvelleFiche', array('id' => $fichevierge->getId()));

        } else {//number=0
            $this->addFlash(
                'notice',
                'ATTENTION : AUCUN SITE DANS LA BASE AX.');
            return $this->redirectToRoute('nouvelleFiche', array('code' => $code));
        }
        // elseif (submitted mais pas de client connu : form sans client)
    }

    /**
     * @Route("/racco/actualiserFiche/{id}", name="actualiserClientSite")
     * @param Fiche $id
     * @return RedirectResponse
     */
    public function actualiserClientSite(Fiche $id, CusttableService $custtable_service)
    {
        $em2 = $this->getDoctrine()->getManager('default');
        $mafiche = $em2->getRepository(Fiche::class)->find($id->getId());

	    $site = $mafiche->getSite();
        if ($site) {
            $sitedelafiche = $em2->getRepository(Site::class)->find($site->getId());
            $codesite = $sitedelafiche->getCodeSite();
            $client = $sitedelafiche->getClient();

            if ($client) {
                $clientdelafiche = $em2->getRepository(Client::class)->find($client->getId());
                $codeclient = $clientdelafiche->getCodeClient();

                $em1 = $this->getDoctrine()->getManager('analytics');
                $nouveausite = $em1->getRepository(ClientAx::class)->myfindSitebyCodeAN($codesite);

                $nouveauclient = $em1->getRepository(ClientAx::class)->myfindClient($codeclient);

                $tabfiche = $custtable_service->completerclient( $mafiche, $nouveausite, $nouveauclient);
	            foreach ($tabfiche as $entite) {
		            $em2->persist( $entite );
		            $em2->flush();
	            }
            }
        }
        return $this->redirectToRoute('nouvelleFiche', array('id' => $mafiche->getId()));
    }

    /**
     * FORMULAIRE POUR CREATION DE LA FICHE AVEC CODE RACCO
     *
     * @Route("/racco/nouvelleFiche/{code}", name="nouvelleFiche")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET", "POST"})
     * @internal param Request $request
     */
    public function initialisationFiche($code, BlankFiche $blank_fiche, $request )
    {
        $fiche = $blank_fiche->nouvelleFiche($code);

	    $operateurTP = $this->getUser()->getUsername();
	    $fiche->setOperateurTP($operateurTP);

        $em = $this->getDoctrine()->getManager('default');
        $em->persist($fiche);
        $em->flush();

      //  $em2 = $this->getDoctrine()->getManager('analytics');
      //  $listetech = $em2->getRepository(DirpartyTable::class)->myfindAllTech();
      //  foreach ($listetech as $tech) {
      //      $listedestechniciens[] = $tech['name'];
      //  }

        $site = $fiche->getSite();
        if ($site != null) {
            $codesite = $site->getCodeSite();
            if ($codesite != null) {
	            $tableaucommande = $blank_fiche->bondecommande($codesite, $em); //2);
            }
        }
        else $listecdes[]= 'aucun';

        $appsmartphone = $fiche->getAppsmartphone();
        $tps = $fiche->getInterTP();

        $site = $fiche->getSite();
        $radio = $fiche->getRadio();
        $filaire = $fiche->getFilaire();

        $cheminINI = $fiche->getProgrammation();

        $nouveauPeriph = new Peripherique();

        $editForm = $this->createForm(FicheType::class, $fiche)
            ->add('intervention', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Intervention')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('centretsv', EntityType::class, array(
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Centre TSV')
                        ->orderBy('tc.id');
                },
                'required' => false
            ))
            ->add('tsvsecours', EntityType::class, array(
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Centre TSV')
                        ->orderBy('tc.id');
                },
                'required' => false
            ))
            ->add('technicien', ChoiceType::class, array('label' => "Technicien",
                'choices' => ['ATTENTION', 'DECOMMENTER'],
                'choice_label' => function ($listetech) {
                    return ucwords($listetech);
                },
                'required' => false
            ))
            ->add('numCommande', ChoiceType::class, array('label' => "N° Commande",
                'choices' => $tableaucommande,
                'choice_label' => function ($cdes) {
                    return ucwords($cdes);
                },
                'required' => false,
                'placeholder' => false
            ))
            ->add('programmation', TextType::class, array('label' => "Chemin INI",
                'data' => ($cheminINI),
                'required' => false))
            ->add('radio', RadioType::class, array(
                'data' => $radio,
            ))
            ->add('filaire', FilaireType::class, array(
                'data' => $filaire,
            ))
            ->add('site', SiteType::class, array(
                'data' => $site,
                'label' => false
            ))
            ->add('habilite', CollectionType::class, array(
                'entry_type' => HabiliteType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ))
            ->add('typeCentrale', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Type Centrale')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('referencecentrale', EntityType::class, array('placeholder' => false,
                'label' => 'Réf Centrale',
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Réf. de Centrale')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('version', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Version')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('firmware', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Firmware')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('prom', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Prom')
                        ->orderBy('tc.id');
                },
                'required' => false))
            ->add('masque', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('tc')
                        ->where('tc.categorie = :int')
                        ->setParameter('int', 'Masque')
                        ->orderBy('tc.id');
                },
                'required' => false));

        $periphForm = $this->createForm(PeripheriqueType::class, $nouveauPeriph)
            ->add('additionnel', HiddenType::class, array(
                'data' => true, ))
            ->add('secteur', EntityType::class, array(
                'class' => Secteur::class,
                'choices' => $fiche->getSecteur(),
                'choice_label' => 'nom'));

	    if ($request->isMethod('POST')) {
            $editForm->submit($request->request->get($editForm->getName()));
            $periphForm->submit($request->request->get($periphForm->getName()));
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $doctrine = $this->getDoctrine();
            $em = $doctrine->getManager();
            if (!is_null($periphForm->getData()->getNom())) {
                $em->persist($nouveauPeriph);
            }
            $em->persist($fiche);
            $em->flush();

	        return $this->redirectToRoute('nouvelleFiche', array( 'id' => $fiche->getId(),
            ));
        }

        return $this->render('/fiche/modifier.html.twig', array(
            'form' => $editForm->createView(),
            'periphForm' => $periphForm->createView(),
            'fiche' => $fiche,
            'fichierINI' => $cheminINI,
            'site' => $site,
            'radio' => $radio,
            'filaire' => $filaire,
            'appsmartphone' => $appsmartphone,
            'tps' => $tps,
            /** La page s'affiche UNE PREMIERE FOIS */
        ));
    }

    /**
     * Enregistrement des comptes video pour l'appli smartphone
     * @Route("/racco/ajoutcomptevideo/{id}", name="ajoutvideo")
     * @param Fiche $id
     * @param $identifiant
     * @param $localisation
     * @param $codecompte
     * @param $emailCompteVideo
     * @param $questioncomptevideo
     * @param $reponsecomptevideo
     */
    public
    function ajoutCompteVideo(Fiche $id, $identifiant, $localisation, $codecompte, $emailCompteVideo, $questioncomptevideo, $reponsecomptevideo)
    {
        $em = $this->getDoctrine()->getManager();

        $lafiche = $em->getRepository('AppBundle:Fiche')
            ->find($id);

        $this->identifiant = $identifiant;
        $this->localisation = $localisation;
        $this->codecompte = $codecompte;
        $this->emailCompteVideo = $emailCompteVideo;
        $this->questioncomptevideo = $questioncomptevideo;
        $this->reponsecomptevideo = $reponsecomptevideo;

        $comptevideo = new Comptevideo();

	    $app = $lafiche->getAppsmartphone();
        $app->addComptevideo($comptevideo);
        $em->persist($comptevideo);
        $em->flush();
    }

    /***************************    PERIPHERIQUE  */////

    /**
     *
     * @Route("/racco/modifPeriph/{id}/{peripherique}", name="modifPeriph")
     * @param Request $request
     * @param Fiche $id
     * @param Peripherique $peripherique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifPeriph(Request $request, Fiche $id, Peripherique $peripherique)
    {
        $em = $this->getDoctrine()->getManager();

        $monPeriph = $em->getRepository('AppBundle:Peripherique')->find($peripherique);
        $mafiche = $em->getRepository('AppBundle:Fiche')->find($id);

        $form = $this->createForm(PeripheriqueType::class, $monPeriph);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($peripherique);
            $em->flush();

            return $this->redirectToRoute('nouvelleFiche', array('id' => $mafiche->getId(),
            ));
        }

        return $this->render('/periph/modifier.html.twig', array(
            'form' => $form->createView(),
            'periph' => $monPeriph,
            'fiche' => $mafiche,
        ));
    }

    /**
     * Deletes a PERIPHERIQUE .
     * @Route("racco/suppPeriph/{id}/{peripherique}", name="supprimerPeripherique")
     * @param Fiche $id
     * @param Peripherique $peripherique
     * @return RedirectResponse
     */
    public function deleteAction(Fiche $id, Peripherique $peripherique)
    {
        $em = $this->getDoctrine()->getManager();

        $monPeriph = $em->getRepository('AppBundle:Peripherique')->find($peripherique);
        $mafiche = $em->getRepository('AppBundle:Fiche')->find($id);

        $em->remove($monPeriph);
        $em->flush();

        return $this->redirectToRoute('nouvelleFiche', array('id' => $mafiche->getId(),
        ));
    }

    ////////////////////////////***********************************   CLONE DE LA FICHE CHOISIE   ***************************/

    /**
     * @param Fiche $id
     * @return object
     */
    public
    function Duplicata(Fiche $id)
    {
        //  $em2 = $this->getDoctrine()->getManager('analytics');
        $em1 = $this->getDoctrine()->getManager('default');

        $ficheacloner = $em1->getRepository(Fiche::class)->find($id);

        $ficheclonee = clone $ficheacloner;

        $radioacloner = $ficheacloner->getRadio(); //ICI LES ONE TO ONE CAR DUPLIQUER ID IMPOSSIBLE
        $filaireacloner = $ficheacloner->getFilaire();

        if ($radioacloner) {
            $nouvelleRadio = clone $radioacloner;
            $ficheclonee->setRadio($nouvelleRadio);
            $em1->persist($nouvelleRadio);
        }

        if ($filaireacloner) {
            $newFilaire = clone $filaireacloner;
            $ficheclonee->setFilaire($newFilaire);
            $em1->persist($newFilaire);
        }

        $operateurTP = $this->getUser()->getUsername();
        $ficheclonee->setOperateurTP($operateurTP);
        $ficheclonee->setDate(new Datetime());
        $ficheclonee->setStatut('en cours');

        $em1->persist($ficheclonee);
        $em1->flush();
        return $ficheclonee;
    }

    /**
     * cette fonction récupère les données de l'entité fiche cible et toutes ses entités jointes par l'id de la fiche
     * elle copie les données dans une nouvelle fiche, et nouvelles entités jointes (autres id)
     * @Route("/racco/dupliquerFiche/{id}", name="dupliquerFiche")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Fiche $id
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public
    function cloneFiche(Request $request, Fiche $id)
    {
        $em1 = $this->getDoctrine()->getManager('default');
        $ficheacloner = $em1->getRepository(Fiche::class)->find($id);

        $duplicata = $this->Duplicata($ficheacloner);

        $appsmartphone = $ficheacloner->getAppsmartphone();
        if ($appsmartphone) {
            $nouvelleAppsmartphone = clone $appsmartphone;
            $duplicata->setAppsmartphone($nouvelleAppsmartphone);
            $mescomptesVideo = $appsmartphone->getCompteVideo();
            $em1->persist($nouvelleAppsmartphone);
            $em1->flush();

            foreach ($mescomptesVideo as $compte) {
                $nouveauCV = clone $compte;
                $nouveauCV->setAppsmartphone($nouvelleAppsmartphone);
                $em1->persist($nouveauCV);
                $em1->flush();
            }
        }

        $habilites = $ficheacloner->getHabilite();
        $mesSecteurs = $ficheacloner->getSecteur();

        $em1->persist($duplicata);
        $em1->flush();

        foreach ($habilites as $habilite) {
            $newHabilite = clone $habilite;
            $newHabilite->setFiche($duplicata);
            $em1->persist($newHabilite);
        }
        $em1->flush();

        if ($mesSecteurs) {
            foreach ($mesSecteurs as $secteur) {
                $nouveausecteur = clone $secteur;
                $duplicata->addSecteur($nouveausecteur);
                $em1->persist($nouveausecteur);
                $em1->flush();

                $peripheriquesacloner = $secteur->getPeripherique();

                if ($peripheriquesacloner) {
                    foreach ($peripheriquesacloner as $peripherique) {
                        $nouveauperipherique = clone $peripherique;
                        $nouveausecteur->addPeripherique($nouveauperipherique);
                    }
                }
            }
            $em1->flush();
        }
        return $this->redirectToRoute('nouvelleFiche', array('id' => $duplicata->getId()));
    }

    /**
     * Validation d'une fiche raccordement i.e. fin saisie de la fiche
     * @Route("/racco/validerFiche/{id}", name="validerFiche")
     * @Method({"GET", "POST"})
     * @param Fiche $id
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public
    function validerTechniquementFiche(Fiche $id)
    {
	    $em = $this->getDoctrine()->getManager();

	    $ficheVerifiee = $em->getRepository(Fiche::class)->find($id);

        $x = 0;
        $combienH = count($ficheVerifiee->getHabilite());
        $combienZ = count($ficheVerifiee->getSecteur());

        if (!$ficheVerifiee->getSite() || (strlen($ficheVerifiee->getSite()->getNomSite()) < 3)) {
            $x++;
            $this->addFlash(
                'notice',
                'INFOS SITE MANQUANTES');
        }
        if (strlen($ficheVerifiee->getTechnicien()) < 3) {
            $x++;
            $this->addFlash(
                'notice',
                'TECHNICIEN');
        }
        if ($combienH == 0) {
            $x++;
            $this->addFlash(
                'notice',
                'HABILITE');
        }
        if ($combienZ == 0) {
            $x++;
            $this->addFlash(
                'notice',
                'SECTEUR OU ZONE');
        };
        if ($x > 0) {
            $this->addFlash(
                'notice',
                'Cette fiche est incomplète, veuillez vérifier la saisie pour la validation. Merci.');
            return $this->redirectToRoute('nouvelleFiche', array('id' => $ficheVerifiee->getId()));
        }

        $ficheVerifiee->setStatut('terminé');

        $em->persist($id);
        $em->flush();

        return $this->redirectToRoute('voirFiche', array('id' => $ficheVerifiee->getId()
        ));
    }
}
