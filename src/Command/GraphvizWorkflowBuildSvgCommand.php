<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Workflow\Dumper\DumperInterface;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'workflow:build:graph',
    description: 'Create WORKFLOW Svg',
    aliases: ['w:b:g']
)]
class GraphvizWorkflowBuildSvgCommand extends AbstractWorkflowBuildCommand
{
    protected function createDumper(WorkflowInterface $workflow): DumperInterface
    {
        return match (get_debug_type($workflow)) {
            StateMachine::class => new StateMachineGraphvizDumper(),
            Workflow::class => new GraphvizDumper()
        };
    }

    protected function createSVG(string $dump, string $name, OutputInterface $output): string
    {
        $process = new Process(['dot', '-Tsvg']);
        $process->setInput($dump);
        $process->mustRun();

        $svg = $process->getOutput();
        $output->writeln($svg);
        $svg = preg_replace('/.*<svg/ms', sprintf('<svg class="img-responsive" id="%s"', str_replace('.', '-', $name)), $svg);
        $svg = sprintf("<p>%s</p>\n%s", $name, $svg);

        return $svg;
    }

    protected function dump(string $svg, string $name): void
    {
        file_put_contents(sprintf('%s/templates/svg/%s.svg.twig', $this->kernelProjectDir, $name), $svg);
    }

}
