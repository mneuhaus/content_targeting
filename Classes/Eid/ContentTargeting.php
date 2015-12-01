<?php

namespace Famelo\ContentTargeting\Hooks;
use Famelo\ContentTargeting\Core;

$weight = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : 1;

$GLOBALS['TSFE'] = new \stdClass();
$GLOBALS['TSFE']->fe_user = \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser();

if (isset($_REQUEST['pid'])) {
	$categories = Core::getCategories('pages', 'categories', $_REQUEST['pid']);
	$persona = Core::getPersona();
	foreach ($categories as $category) {
		Core::updateInterest($persona, $category['uid_local']);
	}
}

if (isset($_REQUEST['reset'])) {
	Core::resetTracking();
}

if (isset($_REQUEST['stop'])) {
	Core::stopTracking();
}

if (isset($_REQUEST['start'])) {
	Core::startTracking();
}
