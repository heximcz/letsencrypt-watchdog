<?php
namespace Src\Checks;

class certsCheck {

	/**
	 * 
	 * @param $input - path to check certificate 
	 * @return boolean
	 */
	public function isCertExpire($input)
	{
		//echo shell_exec("openssl x509 -enddate -noout -in " . $input . "/fullchain.pem").PHP_EOL;
		$output = trim(shell_exec("openssl x509 -checkend 86400 -noout -in " . $input . "/fullchain.pem ; echo $?"));
		//var_dump($output);
		return $output;
	}

}