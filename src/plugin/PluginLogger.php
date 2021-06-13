<?php

declare(strict_types=1);

namespace pocketmine\plugin;

use function spl_object_id;

class PluginLogger extends \PrefixedLogger implements \AttachableLogger{

	/** @var \LoggerAttachment[] */
	private $attachments = [];

	public function addAttachment(\LoggerAttachment $attachment){
		$this->attachments[spl_object_id($attachment)] = $attachment;
	}

	public function removeAttachment(\LoggerAttachment $attachment){
		unset($this->attachments[spl_object_id($attachment)]);
	}

	public function removeAttachments(){
		$this->attachments = [];
	}

	public function getAttachments(){
		return $this->attachments;
	}

	public function log($level, $message){
		parent::log($level, $message);
		foreach($this->attachments as $attachment){
			$attachment->log($level, $message);
		}
	}
}
