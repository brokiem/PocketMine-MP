<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\encryption;

use Crypto\Cipher;
use pocketmine\utils\Binary;
use function bin2hex;
use function openssl_digest;
use function openssl_error_string;
use function strlen;
use function substr;

class EncryptionContext{
	private const ENCRYPTION_SCHEME = "AES-256-GCM";
	private const CHECKSUM_ALGO = "sha256";

	/** @var bool */
	public static $ENABLED = true;

	/** @var string */
	private $key;

	/** @var Cipher */
	private $decryptCipher;
	/** @var int */
	private $decryptCounter = 0;

	/** @var Cipher */
	private $encryptCipher;
	/** @var int */
	private $encryptCounter = 0;

	public function __construct(string $encryptionKey){
		$this->key = $encryptionKey;

		$this->decryptCipher = new Cipher(self::ENCRYPTION_SCHEME);
		$ivLength = $this->decryptCipher->getIVLength();
		$this->decryptCipher->decryptInit($this->key, substr($this->key, 0, $ivLength));

		$this->encryptCipher = new Cipher(self::ENCRYPTION_SCHEME);
		$ivLength = $this->encryptCipher->getIVLength();
		$this->encryptCipher->encryptInit($this->key, substr($this->key, 0, $ivLength));
	}

	/**
	 * @throws DecryptionException
	 */
	public function decrypt(string $encrypted) : string{
		if(strlen($encrypted) < 9){
			throw new DecryptionException("Payload is too short");
		}
		$decrypted = $this->decryptCipher->decryptUpdate($encrypted);
		$payload = substr($decrypted, 0, -8);

		$packetCounter = $this->decryptCounter++;

		if(($expected = $this->calculateChecksum($packetCounter, $payload)) !== ($actual = substr($decrypted, -8))){
			throw new DecryptionException("Encrypted packet $packetCounter has invalid checksum (expected " . bin2hex($expected) . ", got " . bin2hex($actual) . ")");
		}

		return $payload;
	}

	public function encrypt(string $payload) : string{
		return $this->encryptCipher->encryptUpdate($payload . $this->calculateChecksum($this->encryptCounter++, $payload));
	}

	private function calculateChecksum(int $counter, string $payload) : string{
		$hash = openssl_digest(Binary::writeLLong($counter) . $payload . $this->key, self::CHECKSUM_ALGO, true);
		if($hash === false){
			throw new \RuntimeException("openssl_digest() error: " . openssl_error_string());
		}
		return substr($hash, 0, 8);
	}
}
