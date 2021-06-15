<?php

declare(strict_types=1);


namespace App\Tests\Integration\Validator;


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
        $package = $this->packageRepository->findOneBy([]);

        $constraints = $this->validator->validate($package);

        self::assertCount(0, $constraints);
    }

    public function testFailValidate()
    {
        $package = $this->packageRepository->findOneBy([]);

        $constraints = $this->validator->validate($package);

        self::assertGreaterThan(0, $constraints);
    }
}