<?php

namespace EcommerceBundle\DataFixtures\ORM;

use EcommerceBundle\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MediaData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('http://i2.cdscdn.com/pdt2/8/1/7/1/700x700/mp01531817/rw/pantalon-chino-homme-beige.jpg');
        $media1->setAlt('chino homme');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setPath('https://i.pinimg.com/736x/c2/0a/78/c20a78220f84db06c48f693f47792129.jpg');
        $media2->setAlt('chino femme');
        $manager->persist($media2);

        $media3 = new Media();
        $media3->setPath('https://media.3suisses.fr/arcadia/visuels/23/2300/264182300-mz_prd_3s.jpg');
        $media3->setAlt('chino enfant');
        $manager->persist($media3);

        $media4 = new Media();
        $media4->setPath('https://i2.cdscdn.com/pdt2/6/4/8/1/700x700/mp02883648/rw/chemise-a-carreaux-homme-mode-chemise-homme-sli.jpg');
        $media4->setAlt('chemise homme');
        $manager->persist($media4);

        $media5 = new Media();
        $media5->setPath('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjIlpmRIcVRaiyVGNVHyBHwmXwZclu3425RM3zFz_AXtEbIl59');
        $media5->setAlt('chemise femme');
        $manager->persist($media5);

        $media6 = new Media();
        $media6->setPath('https://cdn.terredemarins.fr/media/CK303101-chemise-enfant-gar%C3%A7on-denim-a.jpg');
        $media6->setAlt('chemise enfant');
        $manager->persist($media6);

        $manager->flush();

        $this->addReference('media1', $media1);
        $this->addReference('media2', $media2);
        $this->addReference('media3', $media3);
        $this->addReference('media4', $media4);
        $this->addReference('media5', $media5);
        $this->addReference('media6', $media6);
    }
}