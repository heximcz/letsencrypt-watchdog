<?php
namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class Cli extends Command
{
	protected function configure()
	{
		$this
		->setName('cli:nobody')
		->setDescription('NO body text')
		->addArgument(
				'action',
				InputArgument::REQUIRED,
				'tip -> neco'.PHP_EOL.
				'tip2 -> neco2'
				)
		->addOption(
               'xxxxx',
               'x',
               InputOption::VALUE_REQUIRED,
               'zxxzxx',
				100
            );
		
	
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$action = $input->getArgument('action');
		switch ($action) {
			case 'xxx':
				if ($input->getOption('xxx')) {
					echo " ".$input->getOption('xxx').PHP_EOL;
				}
				else echo PHP_EOL;
				break;
			default:
				echo 'Nothing to do.';
				break;
		}
	}
}
