<?php
namespace Src\Checks;

class certsCheck {

	/**
	 * 
	 * @param $path - path to check certificate 
	 * @param $time - renew certificate before expiration (in seconds), min=86400
	 * @return boolean
	 */
	public function isCertExpire($path, $time = 86400)
	{
		$output = trim(shell_exec("openssl x509 -checkend " . $time . " -noout -in " . $path . "/fullchain.pem ; echo $?"));
		return $output;
	}

}