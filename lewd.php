<?php
use App\Console\CliWDSimple;
use Symfony\Component\Console\Application;

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'vendor/autoload.php';


	try {
		$application = new Application("Let's Encrypt Certificate Watchdog","0.0.1");
		$application->add(new CliWDSimple());
//		$application->add(new Cli2()); ...
		$application->run();
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
