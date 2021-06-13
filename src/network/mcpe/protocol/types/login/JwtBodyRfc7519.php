<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model class for JsonMapper which describes the RFC7519 standard fields in a JWT. Any of these fields might not be
 * provided.
 */
class JwtBodyRfc7519{
	public string $iss;
	public string $sub;
	/** @var string|string[] */
	public $aud;
	public int $exp;
	public int $nbf;
	public int $iat;
	public string $jti;
}
