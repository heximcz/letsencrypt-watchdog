<?php
use App\Console\Cli;
use Symfony\Component\Console\Application;

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'vendor/autoload.php';


	try {
		$application = new Application("Ukazkovy CLI","1.0.0");
		$application->add(new Cli());
//		$application->add(new Cli2()); ...
		$application->run();
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
