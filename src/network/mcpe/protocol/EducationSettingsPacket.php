<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class EducationSettingsPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::EDUCATION_SETTINGS_PACKET;

	/** @var string */
	private $codeBuilderDefaultUri;
	/** @var string */
	private $codeBuilderTitle;
	/** @var bool */
	private $canResizeCodeBuilder;
	/** @var string|null */
	private $codeBuilderOverrideUri;
	/** @var bool */
	private $hasQuiz;

	public static function create(string $codeBuilderDefaultUri, string $codeBuilderTitle, bool $canResizeCodeBuilder, ?string $codeBuilderOverrideUri, bool $hasQuiz) : self{
		$result = new self;
		$result->codeBuilderDefaultUri = $codeBuilderDefaultUri;
		$result->codeBuilderTitle = $codeBuilderTitle;
		$result->canResizeCodeBuilder = $canResizeCodeBuilder;
		$result->codeBuilderOverrideUri = $codeBuilderOverrideUri;
		$result->hasQuiz = $hasQuiz;
		return $result;
	}

	public function getCodeBuilderDefaultUri() : string{
		return $this->codeBuilderDefaultUri;
	}

	public function getCodeBuilderTitle() : string{
		return $this->codeBuilderTitle;
	}

	public function canResizeCodeBuilder() : bool{
		return $this->canResizeCodeBuilder;
	}

	public function getCodeBuilderOverrideUri() : ?string{
		return $this->codeBuilderOverrideUri;
	}

	public function getHasQuiz() : bool{
		return $this->hasQuiz;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->codeBuilderDefaultUri = $in->getString();
		$this->codeBuilderTitle = $in->getString();
		$this->canResizeCodeBuilder = $in->getBool();
		if($in->getBool()){
			$this->codeBuilderOverrideUri = $in->getString();
		}else{
			$this->codeBuilderOverrideUri = null;
		}
		$this->hasQuiz = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->codeBuilderDefaultUri);
		$out->putString($this->codeBuilderTitle);
		$out->putBool($this->canResizeCodeBuilder);
		$out->putBool($this->codeBuilderOverrideUri !== null);
		if($this->codeBuilderOverrideUri !== null){
			$out->putString($this->codeBuilderOverrideUri);
		}
		$out->putBool($this->hasQuiz);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleEducationSettings($this);
	}
}
