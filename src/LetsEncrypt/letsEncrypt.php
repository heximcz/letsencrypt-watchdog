<?php
namespace Src\LetsEncrypt;

use Src\LetsEncrypt\letsEncrypt;


class letsEncrypt implements ILetsEncrypt {
	
	private $config;

	public function __construct($config) {
		$this->config = $config;
	}
	
	/**
	 * 
	 * @param $input - domain name
	 * @return boolean
	 */
	public function renewDomain($input)
	{
		$this->wsStop();
		echo shell_exec( $this->config['system']['le-script'] . DIRECTORY_SEPARATOR . 
				"letsencrypt-auto certonly --standalone --renew-by-default -d " . $input . " -d www." . $input );
		$this->wsStart();
		echo $this->wsStatus();
	}
	/**
	 *
	 * @param $input - domain name
	 * @return boolean
	 */
	public function renewSubDomain($input)
	{
		$this->wsStop();
		echo shell_exec( $this->config['system']['le-script'] . DIRECTORY_SEPARATOR .
				"letsencrypt-auto certonly --standalone --renew-by-default -d " . $input );
		$this->wsStart();
		echo $this->wsStatus();
	}
	/**
	 *
	 * @param $input - domain name
	 * @return boolean
	 */
	public function revokeDomain($input)
	{
		echo "No work in this time: revokeDomain ".$input.PHP_EOL;
	}
	/**
	 *
	 * @param $input - domain name
	 * @return boolean
	 */
	public function revokeSubDomain($input)
	{
		echo "No work in this time: revokeSubDomain ".$input.PHP_EOL;
	}
	
	private function wsStop() {
		@shell_exec($this->config['system']['ws-stop']);
	}
	
	private function wsStart() {
		@shell_exec($this->config['system']['ws-start']);
	}
	
	private function wsStatus() {
		return shell_exec($this->config['system']['ws-status']);
	}
	
}