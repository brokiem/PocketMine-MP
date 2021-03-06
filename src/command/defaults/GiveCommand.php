<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\nbt\JsonNbtParser;
use pocketmine\nbt\NbtDataException;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\utils\TextFormat;
use function array_slice;
use function count;
use function implode;

class GiveCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_GIVE_DESCRIPTION,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_GIVE_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_GIVE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) < 2){
			throw new InvalidCommandSyntaxException();
		}

		$player = $sender->getServer()->getPlayerByPrefix($args[0]);
		if($player === null){
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
			return true;
		}

		try{
			$item = LegacyStringToItemParser::getInstance()->parse($args[1]);
		}catch(\InvalidArgumentException $e){
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.give.item.notFound", [$args[1]]));
			return true;
		}

		if(!isset($args[2])){
			$item->setCount($item->getMaxStackSize());
		}else{
			$item->setCount((int) $args[2]);
		}

		if(isset($args[3])){
			$data = implode(" ", array_slice($args, 3));
			try{
				$tags = JsonNbtParser::parseJson($data);
			}catch(NbtDataException $e){
				$sender->sendMessage(new TranslationContainer("commands.give.tagError", [$e->getMessage()]));
				return true;
			}

			$item->setNamedTag($tags);
		}

		//TODO: overflow
		$player->getInventory()->addItem(clone $item);

		Command::broadcastCommandMessage($sender, new TranslationContainer("%commands.give.success", [
			$item->getName() . " (" . $item->getId() . ":" . $item->getMeta() . ")",
			(string) $item->getCount(),
			$player->getName()
		]));
		return true;
	}
}
