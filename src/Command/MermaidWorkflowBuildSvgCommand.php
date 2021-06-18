<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Workflow\Dumper\DumperInterface;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Dumper\MermaidDumper;
use Symfony\Component\Workflow\Dumper\PlantUmlDumper;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'workflow:build:mermaid',
    description: 'Create WORKFLOW Mermaid',
    aliases: ['w:b:m']
)]
class MermaidWorkflowBuildSvgCommand extends AbstractWorkflowBuildCommand
{
    protected function createDumper(WorkflowInterface $workflow): DumperInterface
    {
        return match (get_debug_type($workflow)) {
            StateMachine::class => new MermaidDumper(MermaidDumper::TRANSITION_TYPE_STATEMACHINE),
            Workflow::class => new MermaidDumper(MermaidDumper::TRANSITION_TYPE_WORKFLOW)
        };
    }

    protected function createSVG(string $dump, string $name, OutputInterface $output): string
    {
        #На данном этапе невозможно запустить создание svg из контейнера, возвращаем дамп как есть
        return $dump;
    }

    protected function dump(string $svg, string $name): void
    {
        file_put_contents(sprintf('%s/public/build/mermaid.%s.dump', $this->kernelProjectDir, $name), $svg);
    }


}
