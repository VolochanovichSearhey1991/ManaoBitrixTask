<?
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/autoload.php'); 
    $eventManager = \Bitrix\Main\EventManager::GetInstance();
    $eventManager->AddEventHandler('main', 'OnEpilog', ['lib\EventsClasses\Page404Logger','addToLog']);
?>