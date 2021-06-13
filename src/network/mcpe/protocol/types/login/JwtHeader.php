<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

final class JwtHeader{
	/** @required */
	public string $alg;
	/** @required */
	public string $x5u;
}
