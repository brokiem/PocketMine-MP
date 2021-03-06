<?php

declare(strict_types=1);

namespace pocketmine\permission;

use function is_bool;
use function strtolower;

class PermissionParser{

	public const DEFAULT_OP = "op";
	public const DEFAULT_NOT_OP = "notop";
	public const DEFAULT_TRUE = "true";
	public const DEFAULT_FALSE = "false";

	public const DEFAULT_STRING_MAP = [
		"op" => self::DEFAULT_OP,
		"isop" => self::DEFAULT_OP,
		"operator" => self::DEFAULT_OP,
		"isoperator" => self::DEFAULT_OP,
		"admin" => self::DEFAULT_OP,
		"isadmin" => self::DEFAULT_OP,

		"!op" => self::DEFAULT_NOT_OP,
		"notop" => self::DEFAULT_NOT_OP,
		"!operator" => self::DEFAULT_NOT_OP,
		"notoperator" => self::DEFAULT_NOT_OP,
		"!admin" => self::DEFAULT_NOT_OP,
		"notadmin" => self::DEFAULT_NOT_OP,

		"true" => self::DEFAULT_TRUE,
		"false" => self::DEFAULT_FALSE,
	];

	/**
	 * @param bool|string $value
	 *
	 * @throws \InvalidArgumentException
	 */
	public static function defaultFromString($value) : string{
		if(is_bool($value)){
			if($value){
				return "true";
			}else{
				return "false";
			}
		}
		$lower = strtolower($value);
		if(isset(self::DEFAULT_STRING_MAP[$lower])){
			return self::DEFAULT_STRING_MAP[$lower];
		}

		throw new \InvalidArgumentException("Unknown permission default name \"$value\"");
	}

	/**
	 * @param mixed[][] $data
	 * @phpstan-param array<string, array<string, mixed>> $data
	 *
	 * @return Permission[][]
	 * @phpstan-return array<string, list<Permission>>
	 */
	public static function loadPermissions(array $data, string $default = self::DEFAULT_FALSE) : array{
		$result = [];
		foreach($data as $name => $entry){
			$desc = null;
			if(isset($entry["default"])){
				$default = PermissionParser::defaultFromString($entry["default"]);
			}

			if(isset($entry["children"])){
				throw new \InvalidArgumentException("Nested permission declarations are no longer supported. Declare each permission separately.");
			}

			if(isset($entry["description"])){
				$desc = $entry["description"];
			}

			$result[$default][] = new Permission($name, $desc);
		}
		return $result;
	}
}
