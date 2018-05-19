<?php

namespace EcommerceBundle\DataFixtures\ORM;

use UtilisateursBundle\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UtilisateurData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new Utilisateur();
        $utilisateur1->setUsername('rama');
        $utilisateur1->setEmail('rama@rama.fr');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur1, 'rama');
        $utilisateur1->setPassword($password);
        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setUsername('benjamin');
        $utilisateur2->setEmail('benjamin@benjamin.fr');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur2, 'benjamin');
        $utilisateur2->setPassword($password);
        $manager->persist($utilisateur2);

        $utilisateur3 = new Utilisateur();
        $utilisateur3->setUsername('parte');
        $utilisateur3->setEmail('parte@parte.fr');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur3, 'parte');
        $utilisateur3->setPassword($password);
        $manager->persist($utilisateur3);

        $utilisateur4 = new Utilisateur();
        $utilisateur4->setUsername('coura');
        $utilisateur4->setEmail('coura@coura.fr');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur4, 'coura');
        $utilisateur4->setPassword($password);
        $manager->persist($utilisateur4);

        $utilisateur5 = new Utilisateur();
        $utilisateur5->setUsername('maman');
        $utilisateur5->setEmail('maman@maman.fr');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur5, 'maman');
        $utilisateur5->setPassword($password);
        $manager->persist($utilisateur5);

        $manager->flush();

        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);
        $this->addReference('utilisateur3', $utilisateur3);
        $this->addReference('utilisateur4', $utilisateur4);
        $this->addReference('utilisateur5', $utilisateur5);

    }
}