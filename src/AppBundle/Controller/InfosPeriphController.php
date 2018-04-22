<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InfosPeriph;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("infosperiph")
 */
class InfosPeriphController extends Controller
{
    /**
     * Creates a new infosPeriph entity.
     * @Route("/new", name="infosperiph_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $infosPeriph = new Infosperiph();
        $form = $this->createForm('AppBundle\Form\InfosPeriphType', $infosPeriph);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($infosPeriph);
            $em->flush();

            return $this->redirectToRoute('infosperiph_show', array('id' => $infosPeriph->getId()));
        }
        return $this->render('infosperiph/new.html.twig', array(
            'infosPeriph' => $infosPeriph,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a infosPeriph entity.
     * @Route("/{id}", name="infosperiph_show")
     * @Method("GET")
     */
    public function showAction(InfosPeriph $infosPeriph)
    {
        $deleteForm = $this->createDeleteForm($infosPeriph);
        return $this->render('infosperiph/show.html.twig', array(
            'infosPeriph' => $infosPeriph,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing infosPeriph entity.
     *
     * @Route("/{id}/edit", name="infosperiph_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InfosPeriph $infosPeriph)
    {
        $deleteForm = $this->createDeleteForm($infosPeriph);
        $editForm = $this->createForm('AppBundle\Form\InfosPeriphType', $infosPeriph);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('infosperiph_edit', array('id' => $infosPeriph->getId()));
        }

        return $this->render('infosperiph/edit.html.twig', array(
            'infosPeriph' => $infosPeriph,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a infosPeriph entity.
     * @Route("/{id}", name="infosperiph_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InfosPeriph $infosPeriph)
    {
        $form = $this->createDeleteForm($infosPeriph);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($infosPeriph);
            $em->flush();
        }

        return $this->redirectToRoute('infosperiph_index');
    }

    /**
     * Creates a form to delete a infosPeriph entity.
     * @param InfosPeriph $infosPeriph The infosPeriph entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InfosPeriph $infosPeriph)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('infosperiph_delete', array('id' => $infosPeriph->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
