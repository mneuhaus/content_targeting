<?php
namespace Famelo\ContentTargeting\ViewHelpers;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Category\Collection\CategoryCollection;
use Famelo\ContentTargeting\Core;

/**
 */
class CallbackViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @param int $activityThreshold
	 * @return string
	 */
	public function render($activityThreshold = 10) {
		$persona = Core::getPersona(false);
		if ($persona['tracking'] == 0) {
			return;
		}

		return '<script type="text/javascript">
			var activityThreshold = (new Date().getTime() + ' . ($activityThreshold * 1000) . ');
			var activityTriggered = false;
			$.get("index.php?eID=content_targeting&weight=1&pid=' . $GLOBALS['TSFE']->id .'");
			$("body").bind("mousedown mousemove keydown scroll", function(event) {
				if (activityTriggered) {
					return;
				}
				if (activityThreshold < (new Date().getTime())) {
					return;
				}
				activityTriggered = true;
				$.get("index.php?eID=content_targeting&weight=10&pid=' . $GLOBALS['TSFE']->id .'");
				// console.log("activity detected after threshold");
			});
		</script>';
	}

}
