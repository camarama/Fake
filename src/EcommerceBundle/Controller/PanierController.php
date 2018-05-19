<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Adresses;
use EcommerceBundle\Entity\Commandes;
use EcommerceBundle\Entity\Produits;
use EcommerceBundle\Form\AdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class PanierController extends Controller
{
    /**
     * @Route("/panier")
     */
    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $session->set('panier', array());

       $panier = $session->get('panier');

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(Produits::class)->findArray(array_keys($panier));

        return $this->render('EcommerceBundle:Default:panier/panier.html.twig', array(
                                                                                      'produits' => $produits,
                                                                                      'panier' => $session->get('panier')));
    }

    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('EcommerceBundle:Default:panier/module/modulePanier.html.twig', array(
                                                                                        'articles' => $articles,));
    }

    /**
     * @Route("/ajouter{id}")
     */
    public function ajoutAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
                $session->set('panier', array());
                    $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
        } else{
            if ($request->query->get('qte')!= null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        $session->getFlashbag()->add('success', 'Article ajouter avec succès');

        return $this->redirect($this->generateUrl('ecommerce_panier_panier'));
    }

    /**
     * @Route("/supprimer{id}")
     */
    public function supprimerAction($id, Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $session->getFlashBag()->add('danger', 'Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('ecommerce_panier_panier'));
    }

    /**
     * @Route("/livraison/adresse/suppression/{id}")
     */
    public function AdresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $adresse = $em->getRepository(Adresses::class)->find($id);

        if ($this->container->get('security.token_storage')
                ->getToken()->getUser() != $adresse->getUtilisateur() || !$adresse)

            return $this->redirect($this->generateUrl('ecommerce_panier_livraison'));

        $em->remove($adresse);
        $em->flush();

        return $this->redirect($this->generateUrl('ecommerce_panier_livraison'));
    }

    /**
     * @Route("/livraison")
     */
    public function livraisonAction(Request $request)
    {
        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
        $adresse = new Adresses();
        $form = $this->createForm(AdressesType::class, $adresse);

            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $adresse->setUtilisateur($utilisateur);
                $em->persist($adresse);
                $em->flush();

                return $this->redirect($this->generateUrl('ecommerce_panier_livraison'));
            }

       return $this->render('EcommerceBundle:Default:panier/livraison.html.twig', array('utilisateur' => $utilisateur,
                                                                                        'form' => $form->createView()));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse', array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->request->get('facturation') != null)
        {
            $adresse['livraison'] = $request->request->get('livraison');
            $adresse['facturation'] = $request->request->get('facturation');
        }else{
            return $this->redirect($this->generateUrl('ecommerce_panier_validation'));
        }

        $session->set('adresse', $adresse);

        return $this->redirect($this->generateUrl('ecommerce_panier_validation'));
    }

    /**
     * @Route("/validation")
     */
    public function validationAction(Request $request)
    {
        $session = $request->getSession();
        if($request->isMethod('POST'))
        {
            $this->setLivraisonOnSession($request);
        }

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('EcommerceBundle:Commandes:prepareCommande');
        $commande = $em->getRepository(Commandes::class)->find($prepareCommande->getContent());

        return $this->render('EcommerceBundle:Default:panier/validation.html.twig', array('commande' => $commande));
    }
}
