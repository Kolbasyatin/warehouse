<?php

declare(strict_types=1);


namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Workflow\Dumper\DumperInterface;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\WorkflowInterface;

abstract class AbstractWorkflowBuildCommand extends Command
{
    public function __construct(private Registry $registry, protected string $kernelProjectDir)
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

            $svg = $this->createSVG($dump, $name, $output);
            $this->dump($svg, $name);
        }



        $io->success('All workflows were dumped!');

        return Command::SUCCESS;
    }

    abstract protected function createDumper(WorkflowInterface $workflow): DumperInterface;

    private function getWorkflows(): array
    {
        $refRegistry = new \ReflectionClass(Registry::class);
        $property = $refRegistry->getProperty('workflows');
        $property->setAccessible(true);

        return $property->getValue($this->registry);
    }

    abstract protected function dump(string $svg, string $name): void;

    abstract protected function createSVG(string $dump, string $name, OutputInterface $output): string;

}