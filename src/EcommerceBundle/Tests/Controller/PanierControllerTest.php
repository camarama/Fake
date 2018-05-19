<?php

namespace EcommerceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanierControllerTest extends WebTestCase
{
    public function testPanier()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/panier');
    }

}
