<?php

namespace Famelo\ContentTargeting\Hooks;

/**
 * DataHandler
 */
class DataHandler {

	/**
	 * @param string $status 'new' (ignoring) or 'update'
	 * @param string $tableName
	 * @param int $recordId
	 * @param array $databaseData
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
	 * @return void
	 */
	public function processDatamap_afterDatabaseOperations($status, $tableName, $recordId, array $databaseData, /** @noinspection PhpUnusedParameterInspection */ \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler) {
		var_dump($tableName, $recordId);
		exit();
		// if ($tableName === 'pages') {
		// 	$core = new Core();
		// 	$core->generateRouteCacheForArguments(array(
		// 		'pid' => $recordId
		// 	));
		// } else if (($pid = $dataHandler->getPID($tableName, $recordId)) > 0) {
		// 	$core = new Core();
		// 	$core->generateRouteCacheForArguments(array(
		// 		'pid' => $pid
		// 	));
		// }
	}
}
