<?php

declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Pallet;
use App\Entity\Warehouse;
use App\Infrastructure\Workflow\WorkflowNameMatcher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @method Warehouse getReference($referenceName)
 */
class PalletFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $warehouse1 = $this->getReference('warehouseMSK');
        $pallet1 = $this->getPallet($warehouse1);
        $pallet2 = $this->getPallet($warehouse1);

        $warehouse3 = $this->getReference('warehouseSHA');
        $pallet3 = $this->getPallet($warehouse3);

        $warehouse4 = $this->getReference('warehouseVRZ');
        $pallet4 = $this->getPallet($warehouse4);

        $manager->persist($pallet1);
        $manager->persist($pallet2);
        $manager->persist($pallet3);
        $manager->persist($pallet4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            WarehouseFixture::class
        ];
    }

    private function getPallet(Warehouse $warehouse): Pallet
    {
        $pallet = new Pallet();
        $pallet
            ->setCurrentPlace('import')
            ->setWarehouse($warehouse)
            ->setWorkflowType(WorkflowNameMatcher::PALLET_WORKFLOW_TYPE_REGULAR)
        ;

        return $pallet;
    }


}