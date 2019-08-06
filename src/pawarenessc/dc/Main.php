<?php

namespace pawarenessc\dc;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\player\PlayerChatEvent;

use bboyyu51\discord\Sender;

class Main extends pluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("=========================");
 		$this->getLogger()->info("DiscordChatを読み込みました");
 		$this->getLogger()->info("制作者: PawarenessC");
		$this->getLogger()->info("ライセンス: NYSL Version 0.9982");
		$this->getLogger()->info("http://www.kmonos.net/nysl/");
		$this->getLogger()->info("バージョン:{$this->getDescription()->getVersion()}");
		$this->getLogger()->info("");
		$this->getLogger()->info("当プラグインはDiscordWebhookを使用しております");
		$this->getLogger()->info("DiscordWebhook製作者: bboyyu51");
 		$this->getLogger()->info("=========================");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		$this->config = new Config( $this->getDataFolder() . "Config.yml", Config::YAML,
		[
			"URL"=>"",
			"名前だけで送信する"=>false,
			"サーバー開放"=>"サーバーを開放しました",
			"サーバー閉鎖"=>"サーバーを閉鎖しました"
		]
		$this->getSender()->Send($this->config->get("サーバー開放"));
	}
	
	public function onDisable(){
		$this->getSender()->Send($this->config->get("サーバー閉鎖"));
		
		$this->getLogger()->info("=========================");
 		$this->getLogger()->info("DiscordChatを停止しています");
 		$this->getLogger()->info("制作者: PawarenessC");;
		$this->getLogger()->info("バージョン:{$this->getDescription()->getVersion()}");
 		$this->getLogger()->info("=========================");
	}
		
	/**
 	* @ignoreCancelled
 	*/
	public function onChat(PlayerChatEvent $event){
		$name = $event->getPlayer()->getName();
		$nametag = $event->getPlayer()->getDisplayName();
		$msg = $event->getMessage();
		if($this->config->get("名前だけで送信する") == "true"){
		$this->getSender()->Send("{$name}: {$msg}");
		}else{
			$this->getSender()->Send("{$nametag}: {$msg}");
		}
	}
	
	private function getSender(){
		return new Sender($this->config->get("URL"));
	}
}
