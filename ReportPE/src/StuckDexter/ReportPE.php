<?php

namespace StuckDexter;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;


class report extends PluginBase implements Listener{

public $prefix = "§7[§4Report§6PE§7]§r ";



public function onEnable(){

@mkdir($this->getDataFolder());
$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
if(empty($config->get("ReportMessage"))){
$config->set("ReportMessage", "§awir werden uns sofort um deinen report kümmern");
}
$config->save();

$this->getLogger()->info($this->prefix."§aLoading ReportPE!");

}



public function onDisable(){

$this->getLogger()->info($this->prefix."§4Deactivated ReportPE!");
}


public function onReport(Player $player, $grund, $reportet){

if(file_exists($this->getServer()->getDataPath()."players/".strtolower($reportet).".dat")){
foreach($this->getServer()->getOnlinePlayers() as $players){
if($players->hasPermission("report.recive")){
$players->sendMessage($this->prefix."§4".$reportet." §6wurde von §a".$player->getName()." §6für §4".$grund."§6 reportet");
$player->sendMessage($this->prefix." §awir werden uns sofort um deinen report kümmern!");
}
}
}else{
$player->sendMessage($this->prefix." §4Dieser Spieler existiert nicht!");
}
}



public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
if(strtolower($cmd->getName()) == "report"){
if($sender instanceof Player){
if(empty($args[1])){
$sender->sendMessage($this->prefix."/report <Spieler> <Grund>");
}else{
$this->onReport($sender, $args[1], $args[0]);
}
}else{
$this->getLogger()->info($this->prefix." §4Sei doch kein Scherzkeks :D Die Console kann leider niemanden reporten!!");
}
}
}
}


?>