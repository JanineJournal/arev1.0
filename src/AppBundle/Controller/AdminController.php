<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fiche;
use AppBundle\Entity\User;
use AppBundle\Service\ReportService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
	/***************************       SUPER_ADMIN      **************************************/

	/**
     * @Route("/adminapp", name="superadmin")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function superAdmin(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

            return $this->render( 'admin/superAdmin.html.twig', array(
                'users' => $users
            ));
    }

    /***************************       ADMIN      **************************************/

    /**
     * appel de la vue Twig de l'espace administrateur d'où il sera possible de consulter tous les périphériques, toutes les fiches
     * raccordement, etc.
     * @Route("/admin", name="admin")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     *
     */
    public function adminPageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $limit = 8;
        $parametre = $em->getRepository('AppBundle:Parametre')->findAll();

        $peripheriques = $em->getRepository('AppBundle:Peripherique')->findBy(array(), array('id' => 'DESC'), $limit, null);
        $fiches = $em->getRepository('AppBundle:Fiche')->findBy(array(), array('id' => 'DESC'), $limit, null);
        $users = $em->getRepository('AppBundle:User')->findBy(array(), array('id' => 'DESC'), $limit, null);
        $periphNvx = $em->getRepository('AppBundle:InfosPeriph')->findAll();

        return $this->render('admin/admin.html.twig', array(
            'peripheriques' => $peripheriques,
            'fiches' => $fiches,
            'infosPeriphs'=> $periphNvx,
            'parametre'=> $parametre,
            'users' => $users,
            'limit' => $limit,
        ));
    }

    /**
     * @Route("/admin/report", name="report")
     * @Method({"GET", "POST"})
     */
    public function report(ReportService $report_service)
    {
        $em = $this->getDoctrine()->getManager();// création de l'entity manager qui servira à appeler le dépot de données "fiches"
        $fichesrepo = $em->getRepository(Fiche::class);

	    $tableauresultats = $report_service->report($fichesrepo);

        return $this->render('admin/report.html.twig', $tableauresultats);
    }

    /********************************                  CLIENTS                *******************************/
    /**********************************************************************************************************/

    /**
     * Affichage des Clients dans tableau triable
     * @Route("/admin/listeClients", name="listeClients")
     * @Method({"GET", "POST"})
     */
    public
    function listeClients()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('AppBundle:Client')->findAll();

        return $this->render('admin/client_index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /************************************************************* ROLES DES USERS ***********************/

    /**
     * Affichage des Utilisateurs et leur rôle en liste
     * @Route("/admin/listeUtilisateurs", name="listeUtilisateurs")
     * @Method({"GET", "POST"})
     */
    public function listeUtilisateurs()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/users.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user_id" : "id"}})
     * @Route("/admin/{user_id}/RoleRacco", name="RoleRacco")
     * @Method({"GET", "POST"})
     */
    public function ajouterRoleRacco(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Page interdite hors administrateur(s)');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($user);

        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_RACCO');
        $userManager->updateUser($user);

        $demandeur = $this->getUser();
        if ($demandeur->hasRole('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('superadmin');
        }
        return $this->redirectToRoute('listeUtilisateurs');
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user_id" : "id"}})
     * @Route("/admin/{user_id}/RoleFactu", name="RoleFactu")
     * @Method({"GET", "POST"})
     */
    public function ajouterRoleFactu(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Page interdite hors administrateur(s)');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($user);

        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_FACTU');
        $userManager->updateUser($user);

        return $this->redirectToRoute('superadmin');
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user_id" : "id"}})
     * @Route("/admin/{user_id}/retraitRoleRacco", name="retraitRoleRacco")
     * @Method({"GET", "POST"})
     */
    public function retraitRoleRacco(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Page interdite hors administrateur(s)');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($user);

        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_RACCO');
        $userManager->updateUser($user);

        $demandeur = $this->getUser();
        if ($demandeur->hasRole('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('superadmin');
        }
        return $this->redirectToRoute('listeUtilisateurs');
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user_id" : "id"}})
     * @Route("/admin/{user_id}/retraitRoleFactu", name="retraitRoleFactu")
     * @Method({"GET", "POST"})
     */
    public function retraitRoleFactu(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Page interdite hors administrateur(s)');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($user);

        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_FACTU');
        $userManager->updateUser($user);

        $demandeur = $this->getUser();
        if ($demandeur->hasRole('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('superadmin');
        }
        return $this->redirectToRoute('listeUtilisateurs');
    }

}