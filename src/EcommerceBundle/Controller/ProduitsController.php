<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Categories;
use EcommerceBundle\Entity\Produits;
use EcommerceBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ProduitsController extends Controller
{
    /**
     * @Route("/categorie/{categorie}")
     */
    public function categorieAction($categorie, Session $session, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if ($categorie != null)
            $findProduits = $em->getRepository(Produits::class)->byCategorie($categorie);
        else
            $findProduits = $em->getRepository(Produits::class)->findBy(array('disponible' => 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        $produits  = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page', 1),3);

        $categorie = $em->getRepository(Categories::class)->find($categorie);
        if (!$categorie) throw $this->createNotFoundException('La page que vous recherchez n\'existe pas');

        return $this->render('EcommerceBundle:Default:produits/produits.html.twig', array(
                                                                                'produits' => $produits,
                                                                                'panier' => $panier));
    }

    /**
     * @Route("/")
     */
    public function indexAction(Session $session, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $findProduits = $em->getRepository(Produits::class)->findBy(array('disponible' => 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        $produits  = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page', 1),3);

        return $this->render('EcommerceBundle:Default:produits/produits.html.twig', array(
                                                                                'produits' => $produits,
                                                                                'panier' => $panier));
    }

    public function menuAction(Request $request, Session $session)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('EcommerceBundle:Default:produits/module/moduleProduit.html.twig', array(
                                                                                                    'articles' => $articles));
    }

    /**
     * @Route("/produit/{id}")
     */
    public function produitDetailAction($id, Request $request, Session $session)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produits::class)->find($id);

        if (!$produit) throw $this->createNotFoundException('Le produit que vous recherchez n\'existe pas');

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        return $this->render('EcommerceBundle:Default:produits/produitDetail.html.twig', array(
                                                                                        'produit' => $produit,
                                                                                        'panier' => $panier));
    }

    /**
     * @Route("/produits/liste")
     */
    public function listeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $findProduits = $em->getRepository(Produits::class)->findAll();

        $produits  = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page', 1),3);

        return $this->render('EcommerceBundle:Default:produits/liste.html.twig', array(
                                                                                 'produits' => $produits));
    }

    /**
     * @Route("/produits/troisgrille")
     */
    public function troisGrilleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $findProduits = $em->getRepository(Produits::class)->findAll();

        $produits  = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page', 1),3);

        return $this->render('EcommerceBundle:Default:produits/trois_grille.html.twig', array(
            'produits' => $produits));
    }

    public function rechercheAction()
    {

        $form = $this->createForm(RechercheType::class);

        return $this->render('EcommerceBundle:Default:recherche/modules/recherche.html.twig', array(
                                                                                            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/recherche")
     */
    public function rechercheTraitementAction(Request $request)
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository(Produits::class)->Recherche($form['recherche']->getData());
        } else {

                throw $this->createNotFoundException('La page que vous recherchez n\'existe pas');
        }

            return $this->render('EcommerceBundle:Default:produits/produits.html.twig', array('produits' => $produits));
    }
}
