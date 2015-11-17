<?php

namespace Famelo\ContentTargeting\Hooks;
use TYPO3\CMS\Core\Database\DatabaseConnection;

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
		if (\Famelo\ContentTargeting\Core::hasTarget($tableName)) {
			\Famelo\ContentTargeting\Core::addTargetInstance($tableName, $recordId);
		}
		if ($tableName == 'sys_category') {
			\Famelo\ContentTargeting\Core::addCategory($recordId);
		}
	}

}
