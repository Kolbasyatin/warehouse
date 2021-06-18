<?php

declare(strict_types=1);

namespace App\Tests\Integration\Workflow\SupportStrategies;

use App\Entity\Package;
use App\Infrastructure\Workflow\SupportStrategies\PlaceableSupportStrategyService;
use App\Infrastructure\Workflow\WorkflowNameMatchingInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Workflow\WorkflowInterface;

class PlaceableSupportStrategyServiceTest extends KernelTestCase
{

    public function dataProvider(): iterable
    {
        yield 'wrongSubjectType' => [new \stdClass(), 'foo', 'foo', false];
        yield 'valid Data1' => [new Package(), 'foo', 'foo', true];
        yield 'mismatch names' => [new Package(), 'foo', 'bar', false];
        yield 'mismatch names2' => [new Package(), 'bar', 'foo', false];
        yield 'null from matcher' => [new Package(), null, 'foo', false];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSupports($subject, ?string $matchName, string $workflowName, bool $expect): void
    {
        $matcher = $this->createMock(WorkflowNameMatchingInterface::class);
        $matcher->method('match')->willReturn($matchName);
        $workflow = $this->createMock(WorkflowInterface::class);
        $workflow->method('getName')->willReturn($workflowName);
        $service = new PlaceableSupportStrategyService($matcher);

        $actual = $service->supports($workflow, $subject);

        self::assertSame($expect, $actual);
    }
}
