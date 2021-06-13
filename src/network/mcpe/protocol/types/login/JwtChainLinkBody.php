<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model for JsonMapper exposing the data in the login JWT chain links.
 * TODO: extend this with more complete models
 */
final class JwtChainLinkBody extends JwtBodyRfc7519{
	public string $identityPublicKey;
}
