<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Commandes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CommandesData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $commande1 = new Commandes();
        $commande1->setUtilisateur($this->getReference('utilisateur5'));
        $commande1->setValider('1');
        $commande1->setDate(new \DateTime());
        $commande1->setReference('1');
        $commande1->setProduits(array(
                                        '0' => array('26' => '20'),
                                        '1' => array('29' => '1'),
                                        '2' => array('30' => '5'),
                                        '3' => array('25' => '3'),
                                        '4' => array('28' => '11'),
        ));
        $manager->persist($commande1);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
                    UtilisateurData::class,
        );
    }
}