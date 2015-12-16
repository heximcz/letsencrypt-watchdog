<?php
namespace Src\Watchdog;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Src\Checks\domainCheck;
use Src\Checks\certsCheck;
use Src\LetsEncrypt\letsEncrypt;
use Exception;

class WatchdogSimple implements IWatchdog {
	
	private $config;
	
	public function __construct($config) {
		$this->config = $config;
	}

	/**
	 * Simple renew All Domains
	 *
     * @see \Src\Watchdog\IWatchdog::renewAllDomain()
	 * @return sum of all renewed certificates, 0 or x
	 */
	public function renewAllDomain() {
		return $this->simpleAction('renew');
	}
	
	/**
	 *
	 * Simple revoke All Domains
	 *
	 * @see \Src\Watchdog\IWatchdog::revokeAllDomain()
	 * @return sum of all revoked certificates, 0 or x
	 */
	public function revokeAllDomain() {
		return $this->simpleAction('revoke');
	}
	
	private function simpleAction($action = 'renew') {
		$fs = new Filesystem();
		if (! $fs->exists($this->config['system']['le-domains']) ) {
			throw new Exception( 
					"FATAL ERROR: Directory " . $this->config['system']['le-domains'] . " not exist. Is Let's Encrypt installed ?");
		}
		$check = new domainCheck();
		$finder = new Finder();
		$certCheck = new certsCheck();
		$le = new letsEncrypt($this->config);
		$counter = 0;
		$finder->directories()->in( $this->config['system']['le-domains'] );
		foreach ($finder as $file) {
   			if ($certCheck->isCertExpire($file->getRealpath())) {
   		  		if ( $check->isSubdomain( $file->getRelativePathname() ) ) {
					if ($action == 'renew')
	   		   			$le->renewSubDomain($file->getRelativePathname());
					elseif ($action == 'revoke')
						$le->revokeSubDomain($file->getRelativePathname());
   		  		}
   				else {
					if ($action == 'renew')
   						$le->renewDomain($file->getRelativePathname());
					elseif ($action == 'revoke')
						$le->revokeDomain($file->getRelativePathname());
    			}
    		$counter++;
   			}
		}
		return $counter;
	}
	
	
}