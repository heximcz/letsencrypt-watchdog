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
	 * Simple renewAllDomain
	 * @namespace Src\Watchdog
	 * @return sum of all renewed certificates, 0 or x
	 */
	public function renewAllDomain() {
		$fs = new Filesystem();
		if (! $fs->exists($this->config['system']['domains']) ) {
			throw new Exception( 
					"FATAL ERROR: Directory " . $this->config['system']['domains'] . " not exist. Is Let's Encrypt installed ?");
		}
		$check = new domainCheck();
		$finder = new Finder();
		$certCheck = new certsCheck();
		$le = new letsEncrypt();
		$counter = 0;
		$finder->directories()->in( $this->config['system']['domains'] );
		foreach ($finder as $file) {
   			if ($certCheck->isCertExpire($file->getRealpath())) {
// 				echo $file->getRealpath()." Expire".PHP_EOL;
   		  		if ( $check->isSubdomain( $file->getRelativePathname() ) ) {
//   		   			echo $file->getRelativePathname()." isSubdomain".PHP_EOL;
   		   			$le->renewSubDomain($file->getRelativePathname());
   		  		}
   				else {
   		   			$le->renewDomain($file->getRelativePathname());
//   					echo $file->getRelativePathname()." isDomain".PHP_EOL;
    			}
    		$counter++;
   			}
		}
		return $counter;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Src\Watchdog\IWatchdog::revokeAllDomain()
	 * @return sum of all revoked certificates, 0 or x
	 */
	public function revokeAllDomain() {
		// TODO: Auto-generated method stub
	}
}