<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Config\GetYAMLConfig;

class CliWDSimple extends Command
{

	private $config;
	
	public function __construct()
	{
		parent::__construct();
		$myConfig = new GetYAMLConfig();
		$this->config = $myConfig->getConfigData();
//		print_r($this->config);
//		exit;
	}
	
    protected function configure()
    {
        $this
        ->setName('wd:peace')
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
        	/*
        	 * Zobrazi cestu k poslednimu nalezenemu obrazku
        	 * */
            case 'renew':
            	
            	break;
            	
            default:
                echo 'Nothing to do.';
                break;
        }
    }
}
