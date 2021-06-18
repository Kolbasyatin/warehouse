<?php

declare(strict_types=1);


namespace App\Tests\Unit\Workflow;


use App\Entity\Package;
use App\Entity\Pallet;
use App\Infrastructure\Workflow\PlaceableInterface;
use App\Infrastructure\Workflow\WorkflowNameMatcher;
use PHPUnit\Framework\TestCase;

class WorkflowNameMatcherTest extends TestCase
{
    public function placeableData(): iterable
    {
        yield [
            'pallet' => (new Pallet())->setWorkflowType(WorkflowNameMatcher::PALLET_WORKFLOW_TYPE_REGULAR)
        ];

        yield [
            'package' => (new Package())->setWorkflowType(WorkflowNameMatcher::PACKAGE_WORKFLOW_TYPE_DELAY)
        ];
    }

    /**
     * Проверка на то что имена для типов PlaceableInterface уникальны.
     * @dataProvider placeableData
     */
    public function testNamingMap(PlaceableInterface $placeable): void
    {
        $mather = new WorkflowNameMatcher();

        $actual = $mather->match($placeable);

        self::assertNotNull($actual);
    }

    public function testNullResultNamingMap()
    {
        $mather = new WorkflowNameMatcher();

        $actual = $mather->match((new Pallet())->setWorkflowType('foo'));

        self::assertNull($actual);
    }
}