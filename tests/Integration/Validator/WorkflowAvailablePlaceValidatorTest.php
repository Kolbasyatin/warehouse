<?php

declare(strict_types=1);


namespace App\Tests\Integration\Validator;


use App\Entity\Package;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WorkflowAvailablePlaceValidatorTest extends KernelTestCase
{

    private $validator;

    /** @var PackageRepository */
    private $packageRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
        $this->packageRepository = $container->get(PackageRepository::class);
    }


    public function testSuccessValidate(): void
    {
        $packages = $this->packageRepository->findAll();
        [$package1, $package2] = $packages;
        $package2->setWorkflowType(Package::PACKAGE_WORKFLOW_TYPE_DELAY)->setCurrentPlace('storing');


        $constraints1 = $this->validator->validate($package1);
        $constraints2 = $this->validator->validate($package2);

        self::assertSame(0, $constraints1->count());
        self::assertSame(0, $constraints2->count());
    }

    public function testFailValidate(): void
    {
        $packages = $this->packageRepository->findAll();
        [$package1, $package2] = $packages;
        $package1->setCurrentPlace('storing');
        $package2->setWorkflowType(Package::PACKAGE_WORKFLOW_TYPE_DELAY)->setCurrentPlace('delay');

        $constraints1 = $this->validator->validate($package1);
        $constraints2 = $this->validator->validate($package2);

        self::assertGreaterThan(0, $constraints1->count());
        self::assertGreaterThan(0, $constraints2->count());
    }
}