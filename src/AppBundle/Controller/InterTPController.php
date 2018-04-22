<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InterTP;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("tp")
 */
class InterTPController extends Controller
{
    /**
     * Lists all interTP entities.
     * @Route("/listeTP", name="listeTP") //liste les tp non liés à une fiche : décision de ne pas rendre possible cette fonctionnalité
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $interTPs = $em->getRepository('AppBundle:InterTP')->findAll();

        return $this->render('tpsav/listeTP.html.twig', array(
            'interTPs' => $interTPs,
        ));
    }

    /**
     * @Route("/creation/{fiche}", name="ajoutTPsav")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $fiche
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function ajoutTPafiche(Request $request, $fiche)
    {
        $interTP = new Intertp();
        $interTP->setOperateurtp($this->getUser()->getUsername());
	    $em = $this->getDoctrine()->getManager();

        $lafiche = $em->getRepository('AppBundle:Fiche')->find($fiche);

        $lestp = $lafiche->getInterTP();

        $form = $this->createForm('AppBundle\Form\InterTPType', $interTP)
            ->add('operateurtp', TextType::class, array(
                'label' => false,
                'disabled' => true));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($interTP);
            $em->flush();
            $lafiche->addInterTP($interTP);
            $em->persist($lafiche);
            $em->flush();
            return $this->redirectToRoute('voirFiche', array('id' => $lafiche->getId()));
        }

        return $this->render('tpsav/detail_tp.html.twig', array(
            'fiche' => $lafiche,
            'interTP' => $interTP,
            'interold' => $lestp,
            'form' => $form->createView(),
        ));
    }

}
