<?php
use Symfony\Component\Console\Application;
use App\Config\GetYAMLConfig;
use App\Console\CliWDSimple;

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'vendor/autoload.php';

try {
	$myConfig = new GetYAMLConfig();
	$config   = $myConfig->getConfigData();
	$application = new Application("Let's Encrypt Certificate Watchdog","0.0.3");
	$application->add(new CliWDSimple($config));
	$application->run();
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
