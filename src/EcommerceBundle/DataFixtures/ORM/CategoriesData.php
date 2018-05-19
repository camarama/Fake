<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorie1 = new Categories();
        $categorie1->setNom('Hommes');
        $categorie1->setImage($this->getReference('media1'));
        $manager->persist($categorie1);

        $categorie2 = new Categories();
        $categorie2->setNom('Femmes');
        $categorie2->setImage($this->getReference('media2'));
        $manager->persist($categorie2);

        $categorie3 = new Categories();
        $categorie3->setNom('Enfants');
        $categorie3->setImage($this->getReference('media3'));
        $manager->persist($categorie3);

        $manager->flush();

        $this->addReference('categorie1', $categorie1);
        $this->addReference('categorie2', $categorie2);
        $this->addReference('categorie3', $categorie3);
    }

    public function getDependencies()
    {
        return array(
                    MediaData::class,
        );
    }
}