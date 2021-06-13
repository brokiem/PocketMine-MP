<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe;

use pocketmine\network\mcpe\compression\CompressBatchPromise;
use pocketmine\network\mcpe\compression\Compressor;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelChunkPacket;
use pocketmine\network\mcpe\protocol\serializer\PacketBatch;
use pocketmine\network\mcpe\serializer\ChunkSerializer;
use pocketmine\scheduler\AsyncTask;
use pocketmine\world\format\Chunk;
use pocketmine\world\format\io\FastChunkSerializer;

class ChunkRequestTask extends AsyncTask{
	private const TLS_KEY_PROMISE = "promise";
	private const TLS_KEY_ERROR_HOOK = "errorHook";

	/** @var string */
	protected $chunk;
	/** @var int */
	protected $chunkX;
	/** @var int */
	protected $chunkZ;

	/** @var Compressor */
	protected $compressor;
	/** @var int */
	protected $mappingProtocol;

	/** @var string */
	private $tiles = "";

	/**
	 * @phpstan-param (\Closure() : void)|null $onError
	 */
	public function __construct(int $chunkX, int $chunkZ, Chunk $chunk, int $mappingProtocol, CompressBatchPromise $promise, Compressor $compressor, ?\Closure $onError = null){
		$this->compressor = $compressor;
		$this->mappingProtocol = $mappingProtocol;

		$this->chunk = FastChunkSerializer::serializeWithoutLight($chunk);
		$this->chunkX = $chunkX;
		$this->chunkZ = $chunkZ;
		$this->tiles = ChunkSerializer::serializeTiles($chunk);

		$this->storeLocal(self::TLS_KEY_PROMISE, $promise);
		$this->storeLocal(self::TLS_KEY_ERROR_HOOK, $onError);
	}

	public function onRun() : void{
		$chunk = FastChunkSerializer::deserialize($this->chunk);
		$subCount = ChunkSerializer::getSubChunkCount($chunk);
		$payload = ChunkSerializer::serialize($chunk, RuntimeBlockMapping::getInstance(), $this->mappingProtocol, $this->tiles);
		$this->setResult($this->compressor->compress(PacketBatch::fromPackets($this->mappingProtocol, LevelChunkPacket::withoutCache($this->chunkX, $this->chunkZ, $subCount, $payload))->getBuffer()));
	}

	public function onError() : void{
		/**
		 * @var \Closure|null $hook
		 * @phpstan-var (\Closure() : void)|null $hook
		 */
		$hook = $this->fetchLocal(self::TLS_KEY_ERROR_HOOK);
		if($hook !== null){
			$hook();
		}
	}

	public function onCompletion() : void{
		/** @var CompressBatchPromise $promise */
		$promise = $this->fetchLocal(self::TLS_KEY_PROMISE);
		$promise->resolve($this->getResult());
	}
}
