<?php

namespace PagesBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PagesController extends Controller
{
    /**
     * @Route("/page/{id}")
     */
    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesBundle:Pages')->find($id);

        if(!$page) throw $this->createNotFoundException('Cette page n\'existe pas');

        return $this->render('PagesBundle:Default:pages/page.html.twig' , array('page' => $page));
    }

    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('PagesBundle:Default:pages/modules/menu.html.twig', array('pages' => $pages));
    }
}
