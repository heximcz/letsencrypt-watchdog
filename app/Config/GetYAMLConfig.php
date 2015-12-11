<?php
namespace App\Config;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class GetYAMLConfig {
	
	private $data;

	public function __construct($configPath) {
		$this->parseConfig($configPath);
	}
	
	public function getConfigData() {
		return $this->data;
	}
	
	protected function parseConfig($configPath) {
		$yaml = new Parser();
		try {
			$this->data = $yaml->parse(file_get_contents($configPath));
		} catch (ParseException $e) {
			printf("Unable to parse the YAML string from config file: %s \n", $e->getMessage());
			die();
		}		
	}
	
}
