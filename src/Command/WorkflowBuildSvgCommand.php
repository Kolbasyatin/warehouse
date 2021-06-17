<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Workflow\Dumper\DumperInterface;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'workflow:build:svg',
    description: 'Create WORKFLOW Svg',
    aliases: ['w:b:s']
)]
class WorkflowBuildSvgCommand extends Command
{
    public function __construct(private Registry $registry, private string $kernelProjectDir)
    {

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Workflow name', 'all')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $workFlowName = $input->getArgument('name');
        $workflows = $this->getWorkflows();
        foreach ($workflows as [$workflow, $strategy]) {
            $name = $workflow->getName();
            /** @var Workflow $workflow */
            if ($workFlowName !== 'all' && $workFlowName !== $name) {
                continue;
            }
            $dump = $this
                ->createDumper($workflow)
                ->dump($workflow->getDefinition(), null, ['node' => ['width' => 1.6]]);

            $svg = $this->createSVG($dump, $name);
            $this->dumpTwig($svg, $name);
        }



        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    private function dumpTwig(string $svg, string $name)
    {
        file_put_contents(sprintf('%s/templates/svg/%s.svg.twig', $this->kernelProjectDir, $name), $svg);
    }

    private function getWorkflows(): array
    {
        $refRegistry = new \ReflectionClass(Registry::class);
        $property = $refRegistry->getProperty('workflows');
        $property->setAccessible(true);

        return $property->getValue($this->registry);
    }

    private function createDumper(WorkflowInterface $workflow): DumperInterface
    {
        return match (get_debug_type($workflow)) {
            StateMachine::class => new StateMachineGraphvizDumper(),
            Workflow::class => new GraphvizDumper()
        };
    }

    private function createSVG(string $dump, string $name): string
    {
        $process = new Process(['dot', '-Tsvg']);
        $process->setInput($dump);
        $process->mustRun();

        $svg = $process->getOutput();
        $svg = preg_replace('/.*<svg/ms', sprintf('<svg class="img-responsive" id="%s"', str_replace('.', '-', $name)), $svg);

        return $svg;
    }

    /**

    $name = $input->getArgument('service_name');

    $workflow = $this->container->get($name);
    $definition = $workflow->getDefinition();

    if ($workflow instanceof StateMachine) {
    $dumper = new StateMachineGraphvizDumper();
    } else {
    $dumper = new GraphvizDumper();
    }

    $dot = $dumper->dump($definition, null, ['node' => ['width' => 1.6]]);

    $process = new Process(['dot', '-Tsvg']);
    $process->setInput($dot);
    $process->mustRun();

    $svg = $process->getOutput();

    $svg = preg_replace('/.*<svg/ms', sprintf('<svg class="img-responsive" id="%s"', str_replace('.', '-', $name)), $svg);

    $shortName = explode('.', $name)[1];

    file_put_contents(sprintf('%s/templates/%s/doc.svg.twig', $this->container->getParameter('kernel.project_dir'), $shortName), $svg);

    return 0;
     */
}
