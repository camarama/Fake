<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Adresses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdressesData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adresse1 = new Adresses();
        $adresse1->setUtilisateur($this->getReference('utilisateur1'));
        $adresse1->setNom('Sambou');
        $adresse1->setPrenom('rama');
        $adresse1->setNumeroRue('56');
        $adresse1->setAdresse('rue paul doumer');
        $adresse1->setCp('59120');
        $adresse1->setVille('loos');
        $adresse1->setComplement('appartement 2');
        $adresse1->setTelephone('0627589614');
        $adresse1->setPays('France');
        $manager->persist($adresse1);

        $adresse2 = new Adresses();
        $adresse2->setUtilisateur($this->getReference('utilisateur3'));
        $adresse2->setNom('Diaby');
        $adresse2->setPrenom('salif');
        $adresse2->setNumeroRue('15');
        $adresse2->setAdresse('rue anatole france');
        $adresse2->setCp('48562');
        $adresse2->setVille('bruxelles');
        $adresse2->setComplement('appartement 5');
        $adresse2->setTelephone('0687965412');
        $adresse2->setPays('Belgique');
        $manager->persist($adresse2);

        $adresse3 = new Adresses();
        $adresse3->setUtilisateur($this->getReference('utilisateur5'));
        $adresse3->setNom('Diakite');
        $adresse3->setPrenom('Ramatoulaye');
        $adresse3->setNumeroRue('35');
        $adresse3->setAdresse('de schutse');
        $adresse3->setCp('3354 xp');
        $adresse3->setVille('hendrik-ido-ambacht');
        $adresse3->setComplement('');
        $adresse3->setTelephone('0752896325');
        $adresse3->setPays('Pays-Bas');
        $manager->persist($adresse3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
                    UtilisateurData::class,
        );
    }
}