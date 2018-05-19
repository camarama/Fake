<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Adresses;
use EcommerceBundle\Entity\Commandes;
use EcommerceBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommandesController extends Controller
{
    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $random = random_bytes(20);
        $session = $request->getSession();
        $panier = $session->get('panier');
        $adresse = $session->get('adresse');
        $commande = array();
        $totalHT = 0;
        $totalTVA = 0;

        $facturation = $em->getRepository(Adresses::class)->find($adresse['facturation']);
        $livraison = $em->getRepository(Adresses::class)->find($adresse['livraison']);
        $produits = $em->getRepository(Produits::class)->findArray(array_keys($session->get('panier')));

        foreach ($produits as $produit)
        {
            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()]) / $produit->getTva()->getMultiplicate();
            $totalHT += $prixHT;

            if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
                $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
            else
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);

            $totalTVA += round($prixTTC - $prixHT, 2);

            $commande['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
                                                            'quantite' => $panier[$produit->getId()],
                                                            'prixHT' => round($produit->getPrix(), 2),
                                                            'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(), 2)
                );
        }
            $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
                                           'nom' =>$livraison->getNom(),
                                           'numeroRue' =>$livraison->getNumeroRue(),
                                           'adresse' =>$livraison->getAdresse(),
                                           'complement' =>$livraison->getComplement(),
                                           'cp' =>$livraison->getCp(),
                                           'ville' =>$livraison->getVille(),
                                           'pays' =>$livraison->getPays(),
                );

            $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
                'nom' =>$facturation->getNom(),
                'numeroRue' =>$facturation->getNumeroRue(),
                'adresse' =>$facturation->getAdresse(),
                'complement' =>$facturation->getComplement(),
                'cp' =>$facturation->getCp(),
                'ville' =>$facturation->getVille(),
                'pays' =>$facturation->getPays(),
            );

            $commande['prixHT'] = round($totalHT, 2);
            $commande['prixTTC'] = round($totalHT + $totalTVA, 2);
            $commande['token'] = bin2hex($random);

            return $commande;
    }

    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if(!$session->has('commande'))
        {
            $commande = new Commandes();
        } else{
            $commande = $em->getRepository(Commandes::class)->find($session->get('commande'));
        }

        $commande->setUtilisateur($this->getUser());
        $commande->setDate(new \DateTime());
        $commande->setCommande($this->facture($request));
        $commande->setReference(0);
        $commande->setValider(0);

        if(!$session->has('commande'))
        {
            $em->persist($commande);
            $session->set('commande', $commande);
        }

        $em->flush();

        return new Response($commande->getId());
    }

    /**
     * @Route("api/banque/{id}")
     */
    public function validationCommandeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commandes::class)->find($id);

        if (!$commande || $commande->getValider() == 1)
        {
            throw $this->createNotFoundException('la commande n\'existe pas');
        }

        $commande->setValider(1);
        $commande->setReference($this->get('ajoutReference')->reference()); // Service

        $em->flush();

        $session = $request->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');

        //envoi email de validation de la commande
        $message = \Swift_Message::newInstance()
                    ->setSubject('Validation de votre commande')
                    ->setFrom(array('mamedcra@gmail.com' => "FakeDesign"))
                    ->setTo($commande->getUtilisateur()->getEmailCanonical())
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setBody($this->renderView('EcommerceBundle:Default:SwiftMessage/envoi_message.html.twig', array('utilisateur'=>$commande->getUtilisateur())));
        $this->get('mailer')->send($message);

        $session->getFlashBag()->add('success', 'Votre commande est validée avec succès');
        return $this->redirect($this->generateUrl('utilisateurs_utilisateur_facture'));
    }
}
