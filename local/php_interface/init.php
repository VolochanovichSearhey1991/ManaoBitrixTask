<?
  $eventManager = \Bitrix\Main\EventManager::getInstance();
  $eventManager->addEventHandler("iblock", "OnBeforeIBlockElementUpdate",array("ElemDeactivateController","brakeDeactivateElem"));

  class ElemDeactivateController {

    static function brakeDeactivateElem(&$arFields) {
      global $APPLICATION;
      $elemDeactivateController = new ElemDeactivateController();
      $thisElementShowCount = $elemDeactivateController->getShowCounOfElem($arFields["ID"]);
  
      if ( ($arFields["ACTIVE"] === "N") && 	($thisElementShowCount > 2) ) {
        $APPLICATION->throwException("Товар невозможно деактивировать, у него " .  $thisElementShowCount . " просмотров");
        return false;
      }
    }

    function getShowCounOfElem($elemId) {
      global $APPLICATION;
      $res = CIBlockElement::GetByID($elemId);
      $thisElementShowCount = $res->Fetch()["SHOW_COUNTER"];
      return $thisElementShowCount;
    }

  }


	

?>