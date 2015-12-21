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
	private $fs;
	
	public function __construct($config) {
		$this->config = $config;
		$this->fs = new Filesystem();
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

	/**
	 *
	 * Simple renew only one certificate
	 *
	 * @see \Src\Watchdog\IWatchdog::renewOneDomain($domain)
	 * @param name of $domain
	 * @return none
	 */
	public function renewOneDomain($domain) {
		$this->simpleActionOne('renew', $domain);
	}

	/**
	 *
	 * Simple revoke only one certificate
	 *
	 * @see \Src\Watchdog\IWatchdog::revokeOneDomain($domain)
	 * @param name of $domain
	 * @return none
	 */
	public function revokeOneDomain($domain) {
		$this->simpleActionOne('revoke', $domain);
	}
	
	private function simpleAction($action = 'renew') {
		if ( $this->checkLetsEncrypt () ) {
			$check = new domainCheck ();
			$finder = new Finder ();
			$certCheck = new certsCheck ();
			$le = new letsEncrypt ( $this->config );
			$counter = 0;
			$finder->directories ()->in ( $this->config ['system'] ['le-domains'] );
			foreach ( $finder as $file ) {
				if ($certCheck->isCertExpire ( $file->getRealpath () )) {
					if ($check->isSubdomain ( $file->getRelativePathname () )) {
						if ($action == 'renew')
							$le->renewSubDomain ( $file->getRelativePathname () );
						elseif ($action == 'revoke')
							$le->revokeDomain ( $file->getRelativePathname () );
					} 
					else {
						if ($action == 'renew')
							$le->renewDomain ( $file->getRelativePathname () );
						elseif ($action == 'revoke')
							$le->revokeDomain ( $file->getRelativePathname () );
					}
					$counter ++;
				}
			}
			return $counter;
		}

	}
	
	private function simpleActionOne($action, $domain) {
		if ( $this->checkLetsEncrypt () ) {
			$check = new domainCheck ();
			$le = new letsEncrypt ( $this->config );
			if ($this->fs->exists($this->config['system']['le-domains'] . DIRECTORY_SEPARATOR . $domain)) {
				if ($check->isSubdomain ( $domain )) {
					if ($action == 'renew')
						$le->renewSubDomain ( $domain );
					elseif ($action == 'revoke')
						$le->revokeDomain ( $domain );
				} 
				else {
					if ($action == 'renew')
						$le->renewDomain ( $domain );
					elseif ($action == 'revoke')
						$le->revokeDomain ( $domain );
				}
			}
			else {
				throw new Exception(
					"FATAL ERROR: Directory " . $this->config['system']['le-domains'] . DIRECTORY_SEPARATOR . $domain .
					" not exist. Is Let's Encrypt installed ?");
			}
		}
		
	}
	
	private function checkLetsEncrypt() {

		if (! $this->fs->exists($this->config['system']['le-domains']) ) {
			throw new Exception(
					"FATAL ERROR: Directory " . $this->config['system']['le-domains'] . " not exist. Is Let's Encrypt installed ?");
		}
		elseif (! $this->fs->exists($this->config['system']['le-script'].DIRECTORY_SEPARATOR."letsencrypt-auto") ) {
			throw new Exception(
					"FATAL ERROR: File " . $this->config['system']['le-script'] . DIRECTORY_SEPARATOR . "letsencrypt-auto not exist. Is Let's Encrypt installed ?");
		}
		else
			return true;
	}
	
}