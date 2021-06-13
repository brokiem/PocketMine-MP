<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe;

use pocketmine\network\mcpe\compression\Compressor;
use pocketmine\network\mcpe\protocol\serializer\PacketBatch;
use pocketmine\Server;
use function spl_object_id;

final class StandardPacketBroadcaster implements PacketBroadcaster{

	/** @var Server */
	private $server;
	/** @var int */
	private $protocolId;

	public function __construct(Server $server, int $protocolId){
		$this->server = $server;
		$this->protocolId = $protocolId;
	}

	public function broadcastPackets(array $recipients, array $packets) : void{
		$stream = PacketBatch::fromPackets($this->protocolId, ...$packets);

		/** @var Compressor[] $compressors */
		$compressors = [];
		/** @var NetworkSession[][] $compressorTargets */
		$compressorTargets = [];
		foreach($recipients as $recipient){
			$compressor = $recipient->getCompressor();
			$compressorId = spl_object_id($compressor);
			//TODO: different compressors might be compatible, it might not be necessary to split them up by object
			$compressors[$compressorId] = $compressor;
			$compressorTargets[$compressorId][] = $recipient;
		}

		foreach($compressors as $compressorId => $compressor){
			if(!$compressor->willCompress($stream->getBuffer())){
				foreach($compressorTargets[$compressorId] as $target){
					foreach($packets as $pk){
						$target->addToSendBuffer($pk);
					}
				}
			}else{
				$promise = $this->server->prepareBatch($stream, $compressor);
				foreach($compressorTargets[$compressorId] as $target){
					$target->queueCompressed($promise);
				}
			}
		}

	}
}
