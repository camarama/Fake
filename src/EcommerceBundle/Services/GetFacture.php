<?php
namespace EcommerceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class GetFacture
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function facture($facture)
    {
        $html = $this->container->get('templating')->render('UtilisateursBundle:Default:facturePDF.html.twig', array('facture' => $facture));

        $html2pdf = new \HTML2PDF();
        $html2pdf->pdf->SetAuthor('Fakè Design');
        $html2pdf->pdf->SetTitle('Facture '.$facture->getReference());
        $html2pdf->pdf->SetSubject('Facture FakèDesign');
        $html2pdf->pdf->SetKeywords('facture,FakèDesign');
        $html2pdf->pdf->SetDisplayMode('default');
        $html2pdf->writeHTML($html);

        return $html2pdf;
    }
}