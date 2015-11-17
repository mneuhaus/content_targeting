<?php

namespace Famelo\ContentTargeting;
use TYPO3\CMS\Core\Category\Collection\CategoryCollection;
use TYPO3\CMS\Core\Database\DatabaseConnection;

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

	public function registerInterest($params) {
		if (empty($_COOKIE)) {
			return;
		}
		$frontendController = $params['pObj'];
		if ($frontendController->id > 0) {
			$categories = static::getCategories('pages', 'categories', $frontendController->id);
			$persona = static::getPersona();
			foreach ($categories as $category) {
				static::updateInterest($persona, $category['uid_local']);
			}
		}
	}

	public static function updateInterest($persona, $categoryUid, $value = 1) {
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
		return 'static-persona-id';
		if (isset($_COOKIE['content-targeting'])) {
			$personaId = $_COOKIE['content-targeting'];
		} else {
			$personaId = uniqid();
		}

		setcookie('content-targeting', $personaId, time() + 60 * 60 * 24 * 365 * 3);
		return $personaId;
	}

	public static function sortTargets($items, $tableName, $uidField = 'uid') {
		$uids = array();
		$itemMap = array();
		foreach ($items as $item) {
			$uids[] = $item[$uidField];
			$itemMap[$item[$uidField]] = $item;
		}
		$sortedTargets = static::findTargets('foreign_table = "' . $tableName . '" AND foreign_uid IN (' . implode(',', $uids) . ')');
		if ($sortedTargets === NULL) {
			return $items;
		}
		$sortedItems = array();
		foreach ($sortedTargets as $sortedTarget) {
			$sortedItems[] = $itemMap[$sortedTarget['foreign_uid']];
		}
		return $sortedItems;
	}

	public static function findTargets($where = '1=1', $limit = 10) {
		$persona = static::getPersona(TRUE);
		$interests = array();
		foreach ($persona['interests'] as $interest) {
			$interests[] = '(cat_' . $interest['category']['uid'] . ' * ' . $interest['weight'] . ')';
		}
		return $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid, foreign_uid, foreign_table, (' . implode(' + ', $interests) . ') as weight',
			'tx_contenttargeting_targets',
			$where,
			'',
			'weight DESC',
			$limit
		);
	}
}
