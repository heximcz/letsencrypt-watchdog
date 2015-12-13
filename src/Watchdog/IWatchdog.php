<?php
namespace Src\Watchdog;

interface IWatchdog {

	/**
	 * Renew all domain in list
	 * @return sum of all renewed certificates, 0 or x
	 */
	public function renewAllDomain();
	
	/**
	 * Revoke all domain in list
	 * @return sum of all revoked certificates, 0 or x
	 */
	public function revokeAllDomain();
	
}