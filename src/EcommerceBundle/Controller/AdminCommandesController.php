<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Commande controller.
 *
 * @Route("admin/commandes")
 */
class AdminCommandesController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @Route("/", name="admin_commandes_index")
     * @Method("GET")
     */
    public function commandeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('EcommerceBundle:Commandes')->findAll();

        return $this->render('EcommerceBundle:Administration:adminCommandes/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     * @Route("/showAdminFacture/{id}", name="admin_commandes_show")
     * @Method("GET")
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository(Commandes::class)->find($id);

        $session = $request->getSession();

        if (!$facture)
        {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('admin_commandes_show'));
        }

        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }
}
