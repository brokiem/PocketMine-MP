<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\login\JwtChain;
use pocketmine\utils\BinaryStream;
use function is_object;
use function json_decode;
use function json_encode;
use function json_last_error_msg;
use function strlen;

class LoginPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::LOGIN_PACKET;

	/** @var int */
	public $protocol;

	/** @var JwtChain */
	public $chainDataJwt;
	/** @var string */
	public $clientDataJwt;

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->protocol = $in->getInt();
		$this->decodeConnectionRequest($in->getString());
	}

	protected function decodeConnectionRequest(string $binary) : void{
		$connRequestReader = new BinaryStream($binary);

		$chainDataJson = json_decode($connRequestReader->get($connRequestReader->getLInt()));
		if(!is_object($chainDataJson)){
			throw new PacketDecodeException("Failed decoding chain data JSON: " . json_last_error_msg());
		}
		$mapper = new \JsonMapper;
		$mapper->bExceptionOnMissingData = true;
		$mapper->bExceptionOnUndefinedProperty = true;
		try{
			$chainData = $mapper->map($chainDataJson, new JwtChain);
		}catch(\JsonMapper_Exception $e){
			throw PacketDecodeException::wrap($e);
		}

		$this->chainDataJwt = $chainData;
		$this->clientDataJwt = $connRequestReader->get($connRequestReader->getLInt());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putInt($this->protocol);
		$out->putString($this->encodeConnectionRequest());
	}

	protected function encodeConnectionRequest() : string{
		$connRequestWriter = new BinaryStream();

		$chainDataJson = json_encode($this->chainDataJwt);
		if($chainDataJson === false){
			throw new \InvalidStateException("Failed to encode chain data JSON: " . json_last_error_msg());
		}
		$connRequestWriter->putLInt(strlen($chainDataJson));
		$connRequestWriter->put($chainDataJson);

		$connRequestWriter->putLInt(strlen($this->clientDataJwt));
		$connRequestWriter->put($this->clientDataJwt);

		return $connRequestWriter->getBuffer();
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleLogin($this);
	}
}
