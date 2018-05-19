<?php

namespace UtilisateursBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use UtilisateursBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Utilisateur controller.
 *
 * @Route("admin/utilisateurs")
 */
class AdminUtilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     * @Route("/", name="admin_utilisateurs_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('UtilisateursBundle:Utilisateur')->findAll();

        return $this->render('UtilisateursBundle:Administration:adminUsers/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Route("/{id}/adresse", name="admin_utilisateurs_show")
     * @Method("GET")
     */
    public function adresseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('UtilisateursBundle:Utilisateur')->find($id);

            return $this->render('UtilisateursBundle:Administration:adminUsers/show.html.twig', array(
            'utilisateur' => $utilisateur));
    }

    /**
     * @Route("/{id}/facture", name="admin_utilisateur_facture")
     */
    public function factureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('UtilisateursBundle:Utilisateur')->find($id);

        return $this->render('UtilisateursBundle:Administration:adminUsers/facture.html.twig', array(
            'utilisateur' => $utilisateur));
    }
}
