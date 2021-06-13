<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\lang\TranslationContainer;
use pocketmine\utils\TextFormat;
use function count;

class EnchantCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.enchant.description",
			"%commands.enchant.usage"
		);
		$this->setPermission("pocketmine.command.enchant");
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

		$item = $player->getInventory()->getItemInHand();

		if($item->isNull()){
			$sender->sendMessage(new TranslationContainer("commands.enchant.noItem"));
			return true;
		}

		try{
			$enchantment = VanillaEnchantments::fromString($args[1]);
		}catch(\InvalidArgumentException $e){
			$sender->sendMessage(new TranslationContainer("commands.enchant.notFound", [$args[1]]));
			return true;
		}

		$level = 1;
		if(isset($args[2])){
			$level = $this->getBoundedInt($sender, $args[2], 1, $enchantment->getMaxLevel());
			if($level === null){
				return false;
			}
		}

		$item->addEnchantment(new EnchantmentInstance($enchantment, $level));
		$player->getInventory()->setItemInHand($item);

		self::broadcastCommandMessage($sender, new TranslationContainer("%commands.enchant.success", [$player->getName()]));
		return true;
	}
}
