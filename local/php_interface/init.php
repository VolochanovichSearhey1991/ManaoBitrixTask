<?
  \Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__, 'ru'); 
  use  \Bitrix\Main\Localization\Loc;
   
  $eventManager = \Bitrix\Main\EventManager::getInstance();
  $eventManager->addEventHandler("main", "OnBeforeEventAdd",array("LetterDataModifier","modifyLetterData"));

  class LetterDataModifier {

    static function modifyLetterData(&$event, &$lid, &$arFields, &$message_id)	{
      global $USER;
      $letterDataModifier = new LetterDataModifier();
      
      if ($message_id === 7 || $message_id === 19) {
  
       if ($USER->IsAuthorized()) {
         $userId = $USER->GetId();
         $userLogin = $USER->GetLogin();
         $userName = $USER->GetFirstName();
  
         $arFields["AUTHOR"] = Loc::getMessage('USER_IS_AUTHORIZE') .
          $userId . " (" . $userLogin .") " . $userName . " " . Loc::getMessage('FORM_DATA') . " " .
            $arFields["AUTHOR"];
  
       } else {
         $arFields["AUTHOR"] = Loc::getMessage('USER_IS_NOT_AUTHORIZE') . " " . 
            Loc::getMessage('FORM_DATA') . " " . $arFields["AUTHOR"];
       }
       
       $authorString = $arFields["AUTHOR"];
       $letterDataModifier->addEventLogEntry($authorString);
      }
  
     }

     function addEventLogEntry($authorString) {
      CEventLog::Add(array(
        "SEVERITY" => "INFO",
        "AUDIT_TYPE_ID" => "REPLACEMENT_LETTER_DATA",
        "MODULE_ID" => "main",
        "ITEM_ID" => 123,
        "DESCRIPTION" => "Замена данных в отсылаемом письме – [ " . $authorString . " ]"
     ));
    }
  }
  

   
?>