<?php
namespace Src\LetsEncrypt;

use Src\LetsEncrypt\letsEncrypt;


class letsEncrypt implements ILetsEncrypt {

	/**
	 * 
	 * @param $input - path to
	 * @return boolean
	 */
	public function renewDomain($input)
	{
	}
	/**
	 *
	 * @param $input - path to
	 * @return boolean
	 */
	public function renewSubDomain($input)
	{
	}
	/**
	 *
	 * @param $input - path to
	 * @return boolean
	 */
	public function revokeDomain($input)
	{
	}
	/**
	 *
	 * @param $input - path to
	 * @return boolean
	 */
	public function revokeSubDomain($input)
	{
	}
	
}