<?php

namespace pawarenessc\dc;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\block\BlockIds as BID;

Class Main extends pluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("=========================");
		$this->getLogger()->info("ChestGuardを読み込みました");
		$this->getLogger()->info("製作者: PawarenessC");
		$this->getLogger()->info("ライセンス: NYSL Version 0.9982");
		$this->getLogger()->info("http://www.kmonos.net/nysl/");
		$this->getLogger()->info("バージョン:v{$this->getDescription()->getVersion()}");
		$this->getLogger()->info("=========================");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->Config();
	}
	
	public function onDisable(){
		$this->getLogger()->info("=========================");
		$this->getLogger()->info("ChestGuardを停止");
		$this->getLogger()->info("製作者: PawarenessC");
		$this->getLogger()->info("バージョン:v{$this->getDescription()->getVersion()}");
		$this->getLogger()->info("=========================");
	}
	
	public function PlaceChest(BlockPlaceEvent $event){
		if($event->getBlock()->getId() == BID::CHEST){
			$player = $event->getPlayer();
			$name = $player->getName();
			$block = $event->getBlock();
			$x = $block->x;
			$y = $block->y;
			$z = $block->z;
			$data = $x.$y.$z;
			$this->chest->set($data,[
			"name"=>$name,
			"status"=>"guard",
			]);
		}
	}
	
	public function BreakChest(BlockBreakEvent $event){
		if($event->getBlock()->getId() == BID::CHEST){
			$player = $event->getPlayer();
			$name = $player->getName();
			$block = $event->getBlock();
			$x = $block->x;
			$y = $block->y;
			$z = $block->z;
			$data = $x.$y.$z;
			if($this->chest->exists($data)){ $this->config->remove($data); }
		}
	}
	
	/*public function OpenChest(PlayerInteractEvent $event){
		if($id = $event->getBlock()->getId() == BID::CHEST){
		}
	}*/
}
	
	
		
