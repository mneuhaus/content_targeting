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
class SortByInterestViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @param array $items
	 * @param string $targetType
	 * @param string $as
	 * @return string
	 */
	public function render($items, $targetType = 'tt_content', $as = 'sortedItems') {
		$sortedItems = Core::sortTargets($items, $targetType, 'uid');

		if ($this->templateVariableContainer->exists($as)) {
			$backup = $this->templateVariableContainer->get($as);
			$this->templateVariableContainer->remove($as);
		}
		$this->templateVariableContainer->add($as, $sortedItems);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);
		if (isset($backup)) {
			$this->templateVariableContainer->add($as, $backup);
		}
		return $output;
	}

}
