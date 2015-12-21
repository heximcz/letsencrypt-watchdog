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

    protected function execute(InputInterface $input, OutputInterface $output) {
		$action = $input->getOption ( 'action' );
		$wd = new WatchdogSimple ( $this->config );
		switch ($action) {
			// RENEW Certificate/s if expire during 24 hour
			case 'renew' :
				if ($input->getOption ( 'domain' ) == "all") {
					if ($x = $wd->renewAllDomain () > 0)
						echo PHP_EOL . "Renew: " . $x . " certificate/s." . PHP_EOL;
				} 
				else {
					$wd->renewOneDomain ( $input->getOption ( 'domain' ) );
				}
				break;
			// REVOKE Certificate/s
			case 'revoke' :
				if ($input->getOption ( 'domain' ) == "all") {
					if ($x = $wd->revokeAllDomain () > 0)
						echo PHP_EOL . "Revoke: " . $x . " certificate/s." . PHP_EOL;
				}
				else {
					$wd->revokeOneDomain( $input->getOption ( 'domain' ) );
				}
				break;
			default :
				echo '?? Nothing to do.' . PHP_EOL;
				break;
		}
	}
}
