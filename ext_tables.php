<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Famelo.' . $_EXTKEY,
	'persona',
	'Information about your Persona - Content Targeting'
);
