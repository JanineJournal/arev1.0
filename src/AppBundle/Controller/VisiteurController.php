<?php

namespace AppBundle\Controller;

use AnalyticsBundle\Entity\ClientAx;
use AnalyticsBundle\Entity\SvcCallTable;
use AppBundle\Entity\Fiche;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisiteurController extends Controller
{
	/**
	 * POUR SE CONNECTER (CAR ON NE PEUT UTILISER L APPLI SI PAS CONNECTE COMME USER, RACCO OU ADMIN ou alors s'enregistrer
	 * @Route("/", name="accueil")
	 */
	public function indexAction()
	{
		return $this->render('visiteur/index.html.twig');
	}

	/**
	 * RETOURNE LA PAGE DE L ESPACE PERSONNEL
	 * @Route("/user/who-is-user", name="user_question")
	 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
	 */
	public function determineUser()
	{
		$fichesencours = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Fiche')->myfindmesfiches($this->getUser()->getUsername());
		return $this->render('visiteur/user.html.twig', array('fichesencours'=> $fichesencours));
	}

	/**
     * AFFICHAGE DES FICHES EN TABLEAu
     * @Route("/user/listeFiches", name="listeFiches")
     * @Method({"GET"})
     */
    public function listeFiches()
    {
        $em = $this->getDoctrine()->getManager();
        $fiches = $em->getRepository('AppBundle:Fiche')->findAll();
        $combien = count($fiches);

        return $this->render('fiche/liste.html.twig', array(
            'fiches' => $fiches,
            'combien' => $combien,
        ));
    }

    /**
     * AFFICHAGE d'UNE FICHE PRECISEE DANS URL PAR SON ID UNIQUE
     * @Route("/user/fiche/{id}", name="voirFiche")
     * @Method({"GET"})
     */
    public function voirFiche(Fiche $fiche)
    {
        $em = $this->getDoctrine()->getManager();
        $fiche = $em->getRepository('AppBundle:Fiche')->find($fiche);

        $lestp = $fiche->getInterTP();
        $habilites = $fiche->getHabilite();
        $mesZones = $fiche->getSecteur();

        if ($fiche->getSite() != null) {
            $codesite = $fiche->getSite()->getCodeSite();
            $salesid = $fiche->getNumCommande();

            $em2 = $this->getDoctrine()->getManager('analytics');
            $cdes = $em2->getRepository(SvcCallTable::class)->myfindLignesCde($codesite, $salesid);
        }
        else $cdes[] = array("name" =>"nc", "qtyordered" =>"nc", "itemid" =>"nc", "spllocation" =>"nc");

        return $this->render('fiche/detail.html.twig', array(
            'fiche' => $fiche,
            'cdes' => $cdes,
            'interTP'=> $lestp,
            'habilites' => $habilites,
            'secteurs' => $mesZones,
        ));
    }

    /**
     * page de recherche des fiches ayant code racco commun
     * @param Request $request
     * @Route("/user/afficherDossierRacco", name="afficherDossierRacco")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function afficherDossier(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('num', NumberType::class, array('label' => false,
                'required' => false))
            ->add('Chercher', SubmitType::class, array(
                'attr' => array('class' => 'btn'), 'label' => 'OK'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $codeRacco = $form["num"]->getData();

           $fichescherchees = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Fiche')->findBy(array('coderacco' => $codeRacco), array('date' => 'desc'), null, 0);

            if (!$fichescherchees) {
                //si code racco non connu //On enregistre l'objet $fiche dans la base de données avec un statut 'en cours'
                $this->addFlash('message', 'Aucune fiche');
                $this->redirectToRoute('afficherDossierRacco');

            } else {
                // retour à notre page avec affichage de la liste des fiches/tp trouvées avec le même code racco
                return $this->render('visiteur/dossier.html.twig', array(
                    'coderacco' => $codeRacco,
                    'fichescherchees' => $fichescherchees));
            }
        }
        return $this->render('visiteur/dossier.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @Route("/user/afficherDossierClient", name="afficherDossierClient")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function afficherDossierClient(Request $request) {

	    $form = $this->createFormBuilder()
	                 ->add( 'num', NumberType::class, array(
		                 'label'    => false,
		                 'required' => false
	                 ) )
	                 ->add( 'Chercher', SubmitType::class, array(
		                 'attr'  => array( 'class' => 'btn' ),
		                 'label' => 'OK'
	                 ) )
	                 ->getForm();

	    $form->handleRequest( $request );
	    if ($form->isSubmitted() && $form->isValid() ) {
		    $codeclient = $form["num"]->getData();

		    $em1 = $this->getDoctrine()->getManager( 'analytics' );
		    $em2 = $this->getDoctrine()->getManager( 'default' );

		    $leclient = $em1->getRepository( ClientAx::class )->findBy( array( 'invoiceaccount' => $codeclient ) );
		    //attention plusieurs clients peuvent avoir le même code, tri avec dataareaid nécessaire?
		    //s'attendre à recevoir choix liste
		    $nbpotentiels = count( $leclient );

		    if ( ! $nbpotentiels ) {
			    $this->addFlash( 'message', 'Aucun client trouvé' );
			    $this->redirectToRoute( 'afficherDossierClient' );
		    }
		    elseif ( $nbpotentiels == 1 ) {
			    $fichescherchees = $em2->getRepository( 'AppBundle:Fiche' )->myfindByClient( $codeclient );
			    if ( ! $fichescherchees ) {
				    $this->addFlash( 'message', 'Aucun fiche pour ce client dans notre base.' );
				    $this->redirectToRoute( 'afficherDossierClient' );
			    } else {
				    return $this->render( 'visiteur/dossierClient.html.twig', array(
					    'codeclient'      => $codeclient,
					    'fichescherchees' => $fichescherchees
				    ) );
			    }}
		    elseif ( $nbpotentiels > 1 ) {
			    $form = $this->createFormBuilder()
			                 ->add( "clientax", EntityType::class, array(
				                 'class'       => 'AnalyticsBundle:ClientAx',
				                 'choices'     => $leclient,
				                 'placeholder' => '' . $nbpotentiels . ' clients trouvés, Choisir : ',
				                 'label'       => false
			                 ) )
			                 ->add( 'ok', SubmitType::class, array(
				                 'attr'  => array( 'class' => 'btn text-center' ),
				                 'label' => 'ok'
			                 ) )
			                 ->getForm();
			    $form->handleRequest( $request );
			    if ( $form->isSubmitted() && $form->isValid() ) {
				    $clientchoisi = $form->get( 'clientax' )->getData();
				    $codeduclient = $clientchoisi->getInvoiceaccount(); //a vérifier si entité ou tab, ou autre

				    $fichescherchees = $em2->getRepository( 'AppBundle:Fiche' )->myfindByClient( $codeduclient );
				    if ( ! $fichescherchees ) {
					    $this->addFlash( 'message', 'Aucun fiche pour ce client dans notre base.' );
					    $this->redirectToRoute( 'afficherDossierClient' );
				    } else {
					    return $this->render( 'visiteur/dossierClient.html.twig', array(
						    'codeclient'      => $codeclient,
						    'fichescherchees' => $fichescherchees
					    ) );
				    }
			    }
			    return $this->render( 'visiteur/clients.html.twig', array(
				    'clients' => $leclient,
				    'form'    => $form->createView()
			    ) );
		    }
	    }
	    return $this->render( 'visiteur/dossierClient.html.twig', array(
		    'form' => $form->createView()
	    ) );
    }
}
