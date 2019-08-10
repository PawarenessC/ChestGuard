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
			"status"=>"free",
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
			$owner = $this->chest->getAll()[$data]["name"]; //ToDo: オーナー判定
			if($this->chest->exists($data) && $owner == $name){
				$this->config->remove($data);
				$player->sendMessage("ChestGuard>> §cチェストを破壊しました");
			}
		}
	}
	
	/*public function OpenChest(PlayerInteractEvent $event){
		if($id = $event->getBlock()->getId() == BID::CHEST){
		}
	}*/
	
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		$this->MainUI($sender);
	}
	
	public function MainUI($player){
		$buttons[] = [
		'text' => "戻る"];
		$buttons[] = [
		'text' => "情報を確認する"];
		$buttons[] = [
		'text' => "チェストを保護する"];
		$buttons[] = [
		'text' => "保護を解除する"];
		$buttons[] = [
		'text' => "チェストを開放する"];
		$buttons[] = [
		'text' => "開けれる人物を追加する"];
		$this->sendForm($player,"§7Chest Guard","\n\n",$buttons,9000);
	}
}
	
	
		
