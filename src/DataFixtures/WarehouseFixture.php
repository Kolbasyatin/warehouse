<?php

declare(strict_types=1);


namespace App\DataFixtures;


use App\Entity\Warehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WarehouseFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $warehouse1 = new Warehouse();
        $warehouse1->setId('msk')->setName('Московский');

        $warehouse2 = new Warehouse();
        $warehouse2->setId('sha')->setName('Шарапово');


        $warehouse3 = new Warehouse();
        $warehouse3->setId('vrz')->setName('Воронеж');

        $manager->persist($warehouse1);
        $manager->persist($warehouse2);
        $manager->persist($warehouse3);

        $manager->flush();

        $this->setReference('warehouseMSK', $warehouse1);
        $this->setReference('warehouseSHA', $warehouse2);
        $this->setReference('warehouseVRZ', $warehouse3);
    }
}