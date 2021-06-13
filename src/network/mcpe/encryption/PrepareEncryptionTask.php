<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\encryption;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\EccFactory;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\AssumptionFailedError;
use function random_bytes;

class PrepareEncryptionTask extends AsyncTask{

	private const TLS_KEY_ON_COMPLETION = "completion";

	/** @var PrivateKeyInterface|null */
	private static $SERVER_PRIVATE_KEY = null;

	/** @var PrivateKeyInterface */
	private $serverPrivateKey;

	/** @var string|null */
	private $aesKey = null;
	/** @var string|null */
	private $handshakeJwt = null;
	/** @var PublicKeyInterface */
	private $clientPub;

	/**
	 * @phpstan-param \Closure(string $encryptionKey, string $handshakeJwt) : void $onCompletion
	 */
	public function __construct(PublicKeyInterface $clientPub, \Closure $onCompletion){
		if(self::$SERVER_PRIVATE_KEY === null){
			self::$SERVER_PRIVATE_KEY = EccFactory::getNistCurves()->generator384()->createPrivateKey();
		}

		$this->serverPrivateKey = self::$SERVER_PRIVATE_KEY;
		$this->clientPub = $clientPub;
		$this->storeLocal(self::TLS_KEY_ON_COMPLETION, $onCompletion);
	}

	public function onRun() : void{
		$serverPriv = $this->serverPrivateKey;
		$sharedSecret = EncryptionUtils::generateSharedSecret($serverPriv, $this->clientPub);

		$salt = random_bytes(16);
		$this->aesKey = EncryptionUtils::generateKey($sharedSecret, $salt);
		$this->handshakeJwt = EncryptionUtils::generateServerHandshakeJwt($serverPriv, $salt);
	}

	public function onCompletion() : void{
		/**
		 * @var \Closure $callback
		 * @phpstan-var \Closure(string $encryptionKey, string $handshakeJwt) : void $callback
		 */
		$callback = $this->fetchLocal(self::TLS_KEY_ON_COMPLETION);
		if($this->aesKey === null || $this->handshakeJwt === null){
			throw new AssumptionFailedError("Something strange happened here ...");
		}
		$callback($this->aesKey, $this->handshakeJwt);
	}
}
