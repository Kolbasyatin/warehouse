<?php

declare(strict_types=1);


namespace App\Tests\Integration\Workflow;


use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

/**
 * Во избежании случайных изменений имён workflow в описании меняем их тут.
 */
class WorkflowsNamingTest extends KernelTestCase
{
    private const WORKFLOW_NAMES = [
        PlaceableInterface::DELAY_PACKAGE_WORKFLOW_NAME,
        PlaceableInterface::REGULAR_PACKAGE_WORKFLOW_NAME
    ];

    public function testWorkflows()
    {
        static::bootKernel();
        $workflowRegistry = static::getContainer()->get(Registry::class);

        $refRegistry = new \ReflectionClass(Registry::class);
        $property = $refRegistry->getProperty('workflows');
        $property->setAccessible(true);

        $rawWorkflows = $property->getValue($workflowRegistry);

        $actualWorkflowNames = [];
        /** @var  $workflow Workflow */
        foreach ($rawWorkflows as [$workflow, $strategy]) {
            $actualWorkflowNames[] = $workflow->getName();
        }

        self::assertEqualsCanonicalizing(static::WORKFLOW_NAMES, $actualWorkflowNames);
    }
}