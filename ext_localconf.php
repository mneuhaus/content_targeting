<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['content_targeting'] = 'Famelo\ContentTargeting\Core->registerInterest';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['content_targeting'] = \Famelo\ContentTargeting\Hooks\DataHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['content_targeting'] = \Famelo\ContentTargeting\Hooks\DataHandler::class;


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Famelo.' . $_EXTKEY,
	'persona',
	array (
	  'Standard' => 'index,reset,stopTracking,resumeTracking',
	),
	// non-cacheable actions
	array (
	  'Standard' => 'index,reset,stopTracking,resumeTracking',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['content_targeting'] = 'EXT:content_targeting/Classes/Eid/ContentTargeting.php';

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class]['options']['tables'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class]['options']['tables'] = [];
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class]['options']['tables']['tx_contenttargeting_persona'] = [
    'dateField' => 'tstamp',
    'expirePeriod' => '90'
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class]['options']['tables']['tx_contenttargeting_persona_interests'] = [
    'dateField' => 'tstamp',
    'expirePeriod' => '90'
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class]['options']['tables']['tx_realurl_errorlog'] = [
    'dateField' => 'tstamp',
    'expirePeriod' => '90'
];