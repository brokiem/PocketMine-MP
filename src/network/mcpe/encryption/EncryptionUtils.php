<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\encryption;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use pocketmine\network\mcpe\JwtUtils;
use function base64_encode;
use function gmp_strval;
use function hex2bin;
use function openssl_digest;
use function str_pad;

final class EncryptionUtils{

	private function __construct(){
		//NOOP
	}

	public static function generateSharedSecret(PrivateKeyInterface $localPriv, PublicKeyInterface $remotePub) : \GMP{
		return $localPriv->createExchange($remotePub)->calculateSharedKey();
	}

	public static function generateKey(\GMP $secret, string $salt) : string{
		return openssl_digest($salt . hex2bin(str_pad(gmp_strval($secret, 16), 96, "0", STR_PAD_LEFT)), 'sha256', true);
	}

	public static function generateServerHandshakeJwt(PrivateKeyInterface $serverPriv, string $salt) : string{
		return JwtUtils::create(
			[
				"x5u" => base64_encode((new DerPublicKeySerializer())->serialize($serverPriv->getPublicKey())),
				"alg" => "ES384"
			],
			[
				"salt" => base64_encode($salt)
			],
			$serverPriv
		);
	}
}
