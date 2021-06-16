<?php

declare(strict_types=1);


namespace App\Tests\Integration\Workflow;


use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

/**
 * Тест количества и названия workflow от случайных изменений/удалений/добавлений
 */
class WorkflowsNamingTest extends KernelTestCase
{
    private const WORKFLOW_NAMES = [
        PlaceableInterface::DELAY_PACKAGE_WORKFLOW_NAME,
        PlaceableInterface::REGULAR_PACKAGE_WORKFLOW_NAME
    ];

    public function testWorkflowNaming()
    {
        static::bootKernel();
        $workflowRegistry = static::getContainer()->get(Registry::class);
        $workflows = $this->getWorkflows($workflowRegistry);
        $workflowNames = [];
        foreach ($workflows as [$workflow, $strategy]) {
            $workflowNames[] = $workflow->getName();
        }

        self::assertEqualsCanonicalizing(
            static::WORKFLOW_NAMES,
            $workflowNames,
            'Количество или имена WF не соответствуют ожидаемым.'
        );

    }

    private function getWorkflows(Registry $workflowRegistry): array
    {
        $refRegistry = new \ReflectionClass(Registry::class);
        $property = $refRegistry->getProperty('workflows');
        $property->setAccessible(true);

        return $property->getValue($workflowRegistry);
    }

    //Была идея с суффиксами WF нужно делать декоратор на Registry, а это удалить

//    /** @var Workflow[] $workflows */
//    private function getWorkflowNamesWithOverrides(array $workflows)
//    {
//        $rawWorkflowNames = [];
//        /** @var  $workflow Workflow */
//        foreach ($workflows as [$workflow, $strategy]) {
//            $rawWorkflowNames[] = explode(".", $workflow->getName());
//        }
//
//        return $rawWorkflowNames;
//    }
}