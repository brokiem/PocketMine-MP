<?php

declare(strict_types=1);

namespace pocketmine\updater;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Internet;
use function is_array;
use function is_string;
use function json_decode;

class UpdateCheckTask extends AsyncTask{
	private const TLS_KEY_UPDATER = "updater";

	/** @var string */
	private $endpoint;
	/** @var string */
	private $channel;
	/** @var string */
	private $error = "Unknown error";

	public function __construct(AutoUpdater $updater, string $endpoint, string $channel){
		$this->storeLocal(self::TLS_KEY_UPDATER, $updater);
		$this->endpoint = $endpoint;
		$this->channel = $channel;
	}

	public function onRun() : void{
		$error = "";
		$response = Internet::getURL($this->endpoint . "?channel=" . $this->channel, 4, [], $error);
		$this->error = $error;

		if($response !== null){
			$response = json_decode($response->getBody(), true);
			if(is_array($response)){
				if(isset($response["error"]) and is_string($response["error"])){
					$this->error = $response["error"];
				}else{
					$mapper = new \JsonMapper();
					$mapper->bExceptionOnMissingData = true;
					$mapper->bEnforceMapType = false;
					try{
						/** @var UpdateInfo $responseObj */
						$responseObj = $mapper->map($response, new UpdateInfo());
						$this->setResult($responseObj);
					}catch(\JsonMapper_Exception $e){
						$this->error = "Invalid JSON response data: " . $e->getMessage();
					}
				}
			}else{
				$this->error = "Invalid response data";
			}
		}
	}

	public function onCompletion() : void{
		/** @var AutoUpdater $updater */
		$updater = $this->fetchLocal(self::TLS_KEY_UPDATER);
		if($this->hasResult()){
			/** @var UpdateInfo $response */
			$response = $this->getResult();
			$updater->checkUpdateCallback($response);
		}else{
			$updater->checkUpdateError($this->error);
		}
	}
}
