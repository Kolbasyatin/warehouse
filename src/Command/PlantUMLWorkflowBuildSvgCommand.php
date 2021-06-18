<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Workflow\Dumper\DumperInterface;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Dumper\PlantUmlDumper;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'workflow:build:uml',
    description: 'Create WORKFLOW Svg',
    aliases: ['w:b:u']
)]
class PlantUMLWorkflowBuildSvgCommand extends AbstractWorkflowBuildCommand
{
    protected function createDumper(WorkflowInterface $workflow): DumperInterface
    {
        return match (get_debug_type($workflow)) {
            StateMachine::class => new PlantUmlDumper(PlantUmlDumper::STATEMACHINE_TRANSITION),
            Workflow::class => new PlantUmlDumper(PlantUmlDumper::WORKFLOW_TRANSITION)
        };
    }

    protected function createSVG(string $dump, string $name, OutputInterface $output): string
    {
        #На данном этапе невозможно запустить создание svg из контейнера, возвращаем дамп как есть
        return $dump;
    }

    protected function dump(string $svg, string $name): void
    {
        file_put_contents(sprintf('%s/public/build/plantuml.%s.dump', $this->kernelProjectDir, $name), $svg);
    }


}
