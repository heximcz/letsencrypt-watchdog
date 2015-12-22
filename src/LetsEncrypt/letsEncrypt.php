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
	 * @return text
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
	 * @return text
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
	 * @return text
	 */
	public function revokeDomain($input)
	{
		$this->wsStop();
		echo shell_exec( $this->config['system']['le-script'] . DIRECTORY_SEPARATOR .
				"letsencrypt-auto revoke --cert-path " . $this->config['system']['le-domains'] . DIRECTORY_SEPARATOR .
				$input . DIRECTORY_SEPARATOR . "fullchain.pem" );
		$this->wsStart();
		echo $this->wsStatus();
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