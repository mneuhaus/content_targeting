<?php

namespace Famelo\ContentTargeting;

/**
 * FooController
 */
class Core {

	/**
	 * @var array()
	 */
	protected static $targets = array();

	public static function registerTarget($tableName, $fiedName)
	{
		$targets[] = array(
			'tableName' => $tableName,
			'fiedName' => $fiedName
		);
	}

}
