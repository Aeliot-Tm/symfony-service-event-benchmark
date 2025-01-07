<?php

declare(strict_types=1);

namespace App\Console;

use App\Enum\Solution;
use App\Service\ProjectBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:project:build')]
class ProjectBuildCommand extends Command
{
    public function __construct(private ProjectBuilder $projectBuilder)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('count', InputArgument::REQUIRED, 'Count of alternatives');
        $this->addArgument('solution', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Implemented solutions');
        $this->addOption('symfony-version', null, InputOption::VALUE_REQUIRED, 'Version', '6.4');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = (int) $input->getArgument('count');
        if ($count < 1) {
            $output->writeln('<error>Count must be greater than 0</error>');
            return self::INVALID;
        }

        $solutions = array_map([Solution::class, 'from'], $input->getArgument('solution') ?: []);
        if (!$solutions) {
            $output->writeln('<error>No solutions defined</error>');
            return self::INVALID;
        }

        $version = (string) $input->getOption('symfony-version');
        if (!$this->isVersionSupported($version)) {
            $output->writeln('<error>Version ' . $version . ' is not supported</error>');
            return self::INVALID;
        }

        $this->projectBuilder->build($count, $solutions, $version);

        return self::SUCCESS;
    }

    private function isVersionSupported(string $version): bool
    {
        return '6.4' === $version;
    }
}
