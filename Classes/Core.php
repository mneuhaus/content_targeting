<?php

namespace Famelo\ContentTargeting;
use TYPO3\CMS\Core\Category\Collection\CategoryCollection;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use Famelo\FameloCommon\CategoryApi;

/**
 * FooController
 */
class Core {

	/**
	 * @var array()
	 */
	protected static $targets = array();

	public static function registerTarget($tableName, $fiedName) {
		static::$targets[] = array(
			'tableName' => $tableName,
			'fiedName' => $fiedName
		);
	}

	public static function hasTarget($tableName) {
		foreach (static::$targets as $target) {
			if ($target['tableName'] == $tableName) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function getTargets($tableName) {
		$targets = array();
		foreach (static::$targets as $target) {
			if ($target['tableName'] == $tableName) {
				$targets[] = $target['fiedName'];
			}
		}
		return $targets;
	}

	public static function addTargetInstance($tableName, $recordId) {
		$targetFields = static::getTargets($tableName);

		/** @var $db DatabaseConnection */
		$db = $GLOBALS['TYPO3_DB'];
		foreach ($targetFields as $targetField) {
			$categories = static::getCategories($tableName, $targetField, $recordId);
			$data = array(
				'foreign_table' => $tableName,
				'foreign_uid' => $recordId
			);
			for ($i=1; $i <= 100; $i++) {
				$data['cat_' . $i] = 0;
			}
			foreach ($categories as $category) {
				$data['cat_' . $category['uid_local']] = 1;
			}
			$row = $db->exec_SELECTgetSingleRow(
				'*',
				'tx_contenttargeting_targets',
				'
					foreign_table = "' . $tableName . '"
					AND foreign_uid = "' . $recordId . '"
				'
			);
			if ($row === FALSE) {
				$db->exec_INSERTquery('tx_contenttargeting_targets', $data);
			} else {
				$db->exec_UPDATEquery('tx_contenttargeting_targets', 'uid = ' . $row['uid'], $data);
			}
		}
	}

	public static function addCategory($recordId) {
		/** @var $db DatabaseConnection */
		$db = $GLOBALS['TYPO3_DB'];
		$tableName = 'sys_category';
		$data = array(
			'foreign_table' => $tableName,
			'foreign_uid' => $recordId,
			'cat_' . $recordId => 1
		);

		$row = $db->exec_SELECTgetSingleRow(
			'*',
			'tx_contenttargeting_targets',
			'
				foreign_table = "' . $tableName . '"
				AND foreign_uid = "' . $recordId . '"
			'
		);
		if ($row === FALSE) {
			$db->exec_INSERTquery('tx_contenttargeting_targets', $data);
		} else {
			$db->exec_UPDATEquery('tx_contenttargeting_targets', 'uid = ' . $row['uid'], $data);
		}
	}

	public static function getCategories($tableName, $fieldName, $uid) {
		/** @var $db DatabaseConnection */
		$db = $GLOBALS['TYPO3_DB'];
		$where = '
			tablenames = "' . $tableName . '"
			AND fieldname = "' . $fieldName . '"
			AND uid_foreign = "' . $uid . '"
		';
		return $db->exec_SELECTgetRows('uid_local', 'sys_category_record_mm', $where);
	}

	// public function registerInterest($params) {
	// 	if (empty($_COOKIE)) {
	// 		return;
	// 	}
	// 	$frontendController = $params['pObj'];
	// 	if ($frontendController->id > 0) {
	// 		$categories = static::getCategories('pages', 'categories', $frontendController->id);
	// 		$persona = static::getPersona();
	// 		foreach ($categories as $category) {
	// 			static::updateInterest($persona, $category['uid_local']);
	// 		}
	// 	}
	// }

	public static function updateInterest($persona, $categoryUid, $value = 1) {
		if ($persona['tracking'] == 0) {
			return;
		}
		/** @var $db DatabaseConnection */
		$db = $GLOBALS['TYPO3_DB'];
		$row = $db->exec_SELECTgetSingleRow(
			'*',
			'tx_contenttargeting_persona_interests',
			'
				persona_uid = "' . $persona['uid'] . '"
				AND category_uid = "' . $categoryUid . '"
			'
		);
		if ($row === FALSE) {
			$db->exec_INSERTquery('tx_contenttargeting_persona_interests', array(
				'persona_uid' => $persona['uid'],
				'tstamp' => time(),
				'crdate' => time(),
				'weight' => $value,
				'category_uid' => $categoryUid
			));
		} else {
			$db->exec_UPDATEquery(
				'tx_contenttargeting_persona_interests',
				'uid = ' . $row['uid'] . ' AND tstamp < ' . (time() - 1),
				array(
					'weight' => $row['weight'] + $value,
					'tstamp' => time()
				)
			);
		}
	}

	public static function getPersona($includeInterests = FALSE) {
		/** @var $db DatabaseConnection */
		$db = $GLOBALS['TYPO3_DB'];
		$cookie = static::getPersonaId();
		$row = $db->exec_SELECTgetSingleRow(
			'*',
			'tx_contenttargeting_persona',
			'
				cookie_id = "' . $cookie . '"
			'
		);
		if ($row === FALSE) {
			$db->exec_INSERTquery('tx_contenttargeting_persona', array(
				'cookie_id' => $cookie,
				'tstamp' => time(),
				'crdate' => time()
			));
			$row = $db->exec_SELECTgetSingleRow(
				'*',
				'tx_contenttargeting_persona',
				'
					cookie_id = "' . $cookie . '"
				'
			);
		} else if ($includeInterests) {
			$interests = $db->exec_SELECTgetRows('*', 'tx_contenttargeting_persona_interests', '
				persona_uid = "' . $row['uid'] . '"
			');
			$row['interests'] = array();
			foreach ($interests as $interest) {
				$interest['category'] = $db->exec_SELECTgetSingleRow(
					'*',
					'sys_category',
					'uid = "' . $interest['category_uid'] . '"'
				);
				$row['interests'][$interest['category_uid']] = $interest;
			}
		}
		return $row;
	}

	public static function getPersonaId() {
		if (isset($GLOBALS['TSFE']->fe_user->sesData['content-targeting'])) {
			$personaId = $GLOBALS['TSFE']->fe_user->sesData['content-targeting'];
		} else {
			$personaId = uniqid();
		}

		$GLOBALS['TSFE']->fe_user->setKey('ses', 'content-targeting', $personaId);
		return $personaId;
	}

	public static function sortTargets($items, $tableName, $uidField = 'uid') {
		$persona = static::getPersona();
		if ($persona['tracking'] == 0) {
			return $items;
		}

		$uids = array();
		$itemMap = array();
		$maxSorting = 0;
		foreach ($items as $item) {
			$uids[] = $item[$uidField];
			$itemMap[$item[$uidField]] = $item;
			if ($itemMap[$item[$uidField]]['sorting'] > $maxSorting) {
				$maxSorting = $itemMap[$item[$uidField]]['sorting'];
			}
		}
		$sortedTargets = static::findTargets('foreign_table = "' . $tableName . '" AND foreign_uid IN (' . implode(',', $uids) . ')', 30, 0, $tableName);
		if ($sortedTargets === NULL) {
			return $items;
		}
		$sortedItems = array();
		foreach ($sortedTargets as $key => $sortedTarget) {
			$itemMap[$sortedTarget['foreign_uid']]['sorting'] = $maxSorting + $key;
		}
		// var_dump($itemMap);
		// exit();

		usort($itemMap, function($left, $right) {
			return $left['sorting'] < $right['sorting'];
		});

		return $itemMap;
	}

	public static function getWeight($uid, $tableName) {
		$targets = static::findTargets('foreign_table = "' . $tableName . '" AND foreign_uid IN (' . $uid . ')');
		if (is_array($targets)) {
			$target = current($targets);
			return $target['weight'];
		}
	}

	public static function findTargets($where = '1=1', $limit = 10, $offset = 0, $foreignSortByTable = NULL) {
		$persona = static::getPersona(TRUE);
		$interests = array('1');
		foreach ($persona['interests'] as $interest) {
			$interests[] = '(cat_' . $interest['category']['uid'] . ' * ' . $interest['weight'] . ')';
		}

		$results = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'tx_contenttargeting_targets.uid, foreign_uid, foreign_table, (' . implode(' + ', $interests) . ') as weight',
			'tx_contenttargeting_targets' . ($foreignSortByTable !== NULL ? ',' . $foreignSortByTable : ''),
			$where . ($foreignSortByTable !== NULL ? ' AND foreign_uid = ' . $foreignSortByTable . '.uid' : ''),
			'',
			'weight DESC' . ($foreignSortByTable !== NULL ? ' , ' . $foreignSortByTable . '.sorting DESC' : ''),
			$offset . ',' . $limit
		);
		return $results;
	}

	public static function getTableRows($categories, $table, $where, $limit = 10, $offset = 0, $orderBy = 'weight DESC') {
		if ($where === NULL) {
			$where = '1=1';
		}

		$where .= ' AND ' . $table . '.uid = tx_contenttargeting_targets.foreign_uid AND tx_contenttargeting_targets.foreign_table = "' . $table . '"';

		$persona = static::getPersona(TRUE);
		$interests = array();
		foreach ($persona['interests'] as $interest) {
			$interests[] = '(tx_contenttargeting_targets.cat_' . $interest['category']['uid'] . ' * ' . $interest['weight'] . ')';
		}

		if (empty($interests)) {
			$interests[] = '(1)';
		}

		if ($categories !== NULL) {
			$whereConditions = array();
			$logicalOrConditions = explode('OR', $categories);
			foreach ($logicalOrConditions as $logicalOrCondition) {
				$logicalOrCondition = trim($logicalOrCondition, ' ()');
				$logicalAndConditions = explode('AND', $logicalOrCondition);

				$whereCondition = array();
				foreach ($logicalAndConditions as $logicalAndCondition) {
					$whereCondition[] = 'tx_contenttargeting_targets.cat_' . trim($logicalAndCondition) . ' = 1';
				}

				$whereConditions[] = '(' . implode(' AND ', $whereCondition) . ')';
			}
			$where .= ' AND (' . implode(' OR ', $whereConditions) . ')';
		}

		$where .= $GLOBALS['TSFE']->cObj->enableFields($table);

		// $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$results = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$table . '.* , (' . implode(' + ', $interests) . ') as weight',
			$table . ', tx_contenttargeting_targets',
			$where,
			'',
			$orderBy,
			$offset . ',' . $limit
		);
		// echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;

		return $results;
	}

	public static function stopTracking() {
		$persona = static::getPersona();
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
			'tx_contenttargeting_persona',
			'uid = ' . $persona['uid'],
			array(
				'tracking' => 0
			)
		);
	}

	public static function resumeTracking() {
		$persona = static::getPersona();
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
			'tx_contenttargeting_persona',
			'uid = ' . $persona['uid'],
			array(
				'tracking' => 1
			)
		);
	}

	public static function resetTracking() {
		$persona = static::getPersona();
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
			'tx_contenttargeting_persona_interests',
			'persona_uid = ' . $persona['uid']
		);
	}
}
