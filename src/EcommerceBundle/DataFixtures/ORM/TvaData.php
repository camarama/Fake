<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Tva;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TvaData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tva1 = new Tva();
        $tva1->setNom('TVA 1.75%');
        $tva1->setMultiplicate('0.982');
        $tva1->setValeur('1.75');
        $manager->persist($tva1);

        $tva2 = new Tva();
        $tva2->setNom('TVA 20%');
        $tva2->setMultiplicate('0.833');
        $tva2->setValeur('20');
        $manager->persist($tva2);

        $manager->flush();

        $this->addReference('tva1', $tva1);
        $this->addReference('tva2', $tva2);
    }
}