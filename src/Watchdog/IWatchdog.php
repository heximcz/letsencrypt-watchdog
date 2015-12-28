<?php
namespace Src\Watchdog;

interface IWatchdog {

	/**
	 * Renew all certificates in list
	 * @param $time renew certificate before expiration (in seconds), min=86400
	 * @return sum of all renewed certificates, 0 or x
	 */
	public function renewAllDomain($time);
	
	/**
	 * Revoke all certificates in list
	 * @return sum of all revoked certificates, 0 or x
	 */
	public function revokeAllDomain();
	
	/**
	 * Renew one certificate
	 * @param name of $domain
	 * @param $time renew certificate before expiration (in seconds), min=86400
	 * @return none
	 */
	public function renewOneDomain($domain, $time);
	
	/**
	 * Revoke one certificate
	 * @param name of $domain
	 * @return none
	 */
	public function revokeOneDomain($domain);
	
}