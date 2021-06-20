<?php

declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Package;
use App\Entity\Warehouse;
use App\Infrastructure\Workflow\WorkflowNameMatcher;
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
        ##RegularWF
        $warehouse1 = $this->getReference('warehouseMSK');

        for ($i = 0; $i <= 5; $i++) {
            $package = $this->createPackage('RP'.str_pad((string)$i, 2, '0', STR_PAD_LEFT), $warehouse1);
            $manager->persist($package);
        }

        for ($i = 6; $i <= 10; $i++) {
            $package = $this->createPackage('RP'.str_pad((string)$i, 2, '0', STR_PAD_LEFT), $warehouse1);
            $package->setWorkflowType(WorkflowNameMatcher::PACKAGE_WORKFLOW_TYPE_DELAY);
            $manager->persist($package);
        }


        $package1 = $this->createPackage('RP11', $warehouse1);
        $package2 = $this->createPackage('RP12', $warehouse1);
        $package2->setWorkflowType(WorkflowNameMatcher::PACKAGE_WORKFLOW_TYPE_DELAY);

        $warehouse3 = $this->getReference('warehouseSHA');
        $package3 = $this->createPackage('RP13', $warehouse3);

        $warehouse4 = $this->getReference('warehouseVRZ');
        $package4 = $this->createPackage('RP14', $warehouse4);

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

    private function createPackage(string $fid, Warehouse $warehouse): Package
    {
        $package = new Package();
        $package
            ->setFid($fid)
            ->setWarehouse($warehouse)
            ->setCurrentPlace('import')
            ->setWorkflowType(WorkflowNameMatcher::WORKFLOW_NAME_PACKAGE_REGULAR)
        ;

        return $package;
    }


}