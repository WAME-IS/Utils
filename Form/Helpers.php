<?php

namespace Wame\Utils\Form;

use Nette\Application\UI\Form;

class Helpers
{
	/**
	 * Get checkbox data
	 * 
	 * @param Form $form
	 * @param string $name
	 * @return int
	 */
	static function getCheckboxData($form, $name)
	{
		$checkbox = $form->getHttpData($form::DATA_TEXT, $name);
		
		if (!$checkbox) {
			return 0;
		} else {
			return 1;
		}
	}
    
}