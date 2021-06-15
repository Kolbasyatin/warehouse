<?php

declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Package;
use App\Entity\Warehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @method Warehouse getReference($referenceName)
 */
class PackageFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $warehouse1 = $this->getReference('warehouseMSK');
        $package1 = $this->getPackage('RP01', $warehouse1);

        $warehouse2 = $this->getReference('warehouseMSK');
        $package2 = $this->getPackage('RP02', $warehouse1);

        $warehouse3 = $this->getReference('warehouseSHA');
        $package3 = $this->getPackage('RP03', $warehouse3);

        $warehouse4 = $this->getReference('warehouseVRZ');
        $package4 = $this->getPackage('RP04', $warehouse4);

        $manager->persist($package1);
        $manager->persist($package2);
        $manager->persist($package3);
        $manager->persist($package4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            WarehouseFixture::class
        ];
    }

    private function getPackage(string $fid, Warehouse $warehouse): Package
    {
        $package = new Package();
        $package
            ->setFid($fid)
            ->setWarehouse($warehouse)
            ->setCurrentPlace('import')
            ->setWorkflowType(Package::WORKFLOW_TYPE_REGULAR)
        ;

        return $package;
    }


}