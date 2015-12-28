<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Src\Watchdog\WatchdogSimple;
use Exception;

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
                 )
        ->addOption(
        		'time',
        		't',
        		InputOption::VALUE_REQUIRED,
        		'renew certificate before expiration (in seconds), min=86400',
        		'86400'
                 );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
		$action = $input->getOption ( 'action' );
		if ( !is_numeric($input->getOption ( 'time' )) )
			throw new Exception("FATAL ERROR: Input parametr time is not a number!");
		if ( $input->getOption ( 'time' ) < 86400 )
			throw new Exception("FATAL ERROR: Input parametr time is too small!");
		$wd = new WatchdogSimple ( $this->config );
		switch ($action) {
			// RENEW
			case 'renew' :
				if ( $input->getOption ( 'domain' ) == "all" ) {
					if ( $x = $wd->renewAllDomain ( $input->getOption ( 'time' ) ) > 0 )
						echo PHP_EOL . "Renew: " . $x . " certificate/s." . PHP_EOL;
				} 
				else {
					$wd->renewOneDomain ( $input->getOption ( 'domain' ), $input->getOption ( 'time' ) );
				}
				break;
			// REVOKE
			case 'revoke' :
				if ( $input->getOption ( 'domain' ) == "all" ) {
					if ( $x = $wd->revokeAllDomain () > 0 )
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
