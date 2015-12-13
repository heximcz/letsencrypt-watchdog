<?php
namespace Src\Checks;

class domainCheck {
	
	public function isSubdomain($input)
	{
		$exp = explode('.', $input);
		if( count( $exp ) > 2 ) {
			return true;
		} else{
			return false;
		}
	}

}