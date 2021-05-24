<?php
	function phase_replace($phase) {
		$phase = strtolower($phase);
		switch($phase) {
			case "f0":
				return "1a";
				break;
			case "f1(+/-)":
				return "1b";
				break;
			case "f2(-/-)":
				return "1c";
				break;
			case "immunization":
				return "2a";
				break;
			case "antibody screening":
				return "2b";
				break;
			case "in vitro":
				return "3a";
				break;
			case "in vivo":
				return "3b";
				break;
			case "complete":
				return "4";
				break;
		}
	}

	function private_replace($private) {
		if($private == "Yes") :
			return true;
		else :
			return false;
		endif;
	}
?>