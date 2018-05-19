<?php

namespace UtilisateursBundle\Controller;

use EcommerceBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilisateurController  extends Controller
{
    /**
     * @Route("/facture/utilisateur")
     */
    public function factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository(Commandes::class)->byFacture($this->getUser());

        return $this->render('UtilisateursBundle:Default:facture.html.twig', array('factures' =>$factures));
    }

    /**
     * @Route("facture/utilisateur/pdf/{id}")
     */
    public function facturePDFAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository(Commandes::class)->findOneBy(array('utilisateur' => $this->getUser(),
                                                                         'valider' => 1,
                                                                         'id' => $id));

        $session = $request->getSession();

        if (!$facture)
        {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('utilisateurs_utilisateur_facture'));
        }

        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
        
        $this->container->get('setNewFacture')->facture($facture);
    }
}
