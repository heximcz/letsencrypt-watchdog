<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
//use App\Config\GetYAMLConfig;
use Src\Watchdog\WatchdogSimple;

class CliWDSimple extends Command
{

	private $config;
	
	public function __construct($config)
	{
		parent::__construct();
		$this->config = $config;
	}
	
    protected function configure()
    {
        $this
        ->setName('wd:simple')
        ->setDescription('Simple renew/revoke based on check of certificate expire value.')
        ->addOption(
        		'action',
        		'a',
        		InputOption::VALUE_REQUIRED,
        		'renew / revoke certificate',
        		'renew'
                 )
        ->addOption(
        		'domain',
        		'd',
        		InputOption::VALUE_REQUIRED,
        		'check all or one specific domain',
        		'all'
                 );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$action = $input->getOption('action');
        switch ($action) {
            // RENEW Certificate/s if expire during 24 hour
            case 'renew':
            	$renew = new WatchdogSimple($this->config);
            	if ($input->getOption('domain') == "all") {
            		$renew->renewAllDomain();
            	}
            	else {
            		echo "Only ALL in this time, sory.".PHP_EOL;
            	}
            	break;
            // REVOKE Certificate/s
            case 'revoke':
               	echo "Only renew in this time, sory.".PHP_EOL;
            	break;
            default:
                echo '?? Nothing to do.'.PHP_EOL;
                break;
        }
    }
}
