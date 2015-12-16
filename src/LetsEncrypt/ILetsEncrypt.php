<?php
namespace Src\LetsEncrypt;

interface ILetsEncrypt {

	public function renewDomain($input);
	public function renewSubDomain($input);
	public function revokeDomain($input);
	public function revokeSubDomain($input);

}