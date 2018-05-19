<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProduitsData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produits();
        $produit1->setNom('Chino Homme');
        $produit1->setDescription('Le chino ou slack est un pantalon en serge de coton, à l\'origine de couleur claire. C\'est initialement un vêtement militaire.');
        $produit1->setImage($this->getReference('media1'));
        $produit1->setCategorie($this->getReference('categorie1'));
        $produit1->setDisponible('1');
        $produit1->setPrix('89.99');
        $produit1->setTva($this->getReference('tva1'));
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setNom('Chino femme');
        $produit2->setDescription('Le chino aurait été créé en Inde au milieu du XIXe siècle à destination des troupes coloniales britanniques.');
        $produit2->setImage($this->getReference('media2'));
        $produit2->setCategorie($this->getReference('categorie2'));
        $produit2->setDisponible('1');
        $produit2->setPrix('58.95');
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);

        $produit3 = new Produits();
        $produit3->setNom('Chino enfant');
        $produit3->setDescription('Selon certaines sources1, le terme « chino » proviendrait du nom donné aux pantalons acquis sur place par les soldats américains stationnés aux Philippines');
        $produit3->setImage($this->getReference('media3'));
        $produit3->setCategorie($this->getReference('categorie3'));
        $produit3->setDisponible('1');
        $produit3->setPrix('18.69');
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);

        $produit4 = new Produits();
        $produit4->setNom('Chemise Homme');
        $produit4->setDescription('Une chemise est un vêtement qui couvre le buste et les bras');
        $produit4->setImage($this->getReference('media4'));
        $produit4->setCategorie($this->getReference('categorie1'));
        $produit4->setDisponible('1');
        $produit4->setPrix('49.99');
        $produit4->setTva($this->getReference('tva2'));
        $manager->persist($produit4);

        $produit2 = new Produits();
        $produit2->setNom('Chemise femme');
        $produit2->setDescription('Il en existe également une version féminine, que l\'on appelle chemisier.');
        $produit2->setImage($this->getReference('media5'));
        $produit2->setCategorie($this->getReference('categorie2'));
        $produit2->setDisponible('1');
        $produit2->setPrix('24.49');
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);

        $produit3 = new Produits();
        $produit3->setNom('chemise enfant');
        $produit3->setDescription('Quand les manches sont courtes, elle se désigne par le terme chemisette.');
        $produit3->setImage($this->getReference('media6'));
        $produit3->setCategorie($this->getReference('categorie3'));
        $produit3->setDisponible('1');
        $produit3->setPrix('9.78');
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
                    MediaData::class,
                    CategoriesData::class,
                    TvaData::class,
        );
    }
}