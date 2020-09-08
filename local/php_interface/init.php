<?
  require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/autoload.php');
  $eventManager = \Bitrix\Main\EventManager::getInstance();
  $eventManager->addEventHandler("main", "OnBuildGlobalMenu",array("lib\EventsClasses\AdminMenuCreator","makeForContentManager"));

  
	
?>