<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fiche;
use AppBundle\Service\ReportService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FactuController extends Controller
{
    //********************************   outils FACTURATION   **********************************//

    /**
     * @Route("/factu/validerFactu/{id}", name="validerFacturation")
     * @Method({"GET", "POST"})
     */
    public function validerFacturation(Fiche $id)
    {
        $this->denyAccessUnlessGranted('ROLE_FACTU', null, 'Page interdite hors facturation');
        $em = $this->getDoctrine()->getManager();
        $ficheAvalider = $em->getRepository('AppBundle:Fiche')->find($id);
        $ficheAvalider->setStatut("OK facturation");
        $em->persist($ficheAvalider);
        $em->flush();

        return $this->redirectToRoute('listeFiches');
    }

	/**
	 * @Route("/factu/report", name="avaliderfactu")
	 * @Method({"GET", "POST"})
	 */
	public function report(ReportService $report_service)
	{
		$em = $this->getDoctrine()->getManager();// création de l'entity manager qui servira à appeler le dépot de données "fiches"
		$fichesrepo = $em->getRepository(Fiche::class);

		$tableauresultats = $report_service->report($fichesrepo);

		return $this->render('admin/report.html.twig', $tableauresultats);
	}






}