<?
  namespace lib\EventsClasses;

  class AdminMenuCreator {

    function makeForContentManager(&$aGlobalMenu, &$aModuleMenu) {
      global $USER;
  
      $arUserGroups = $USER->GetUserGroupArray();
  
      foreach ($arUserGroups as $group) {
  
        if ($group === "8") {
  
          foreach ($aGlobalMenu as $key=>$value) {
  
            if ($key !== "global_menu_content" && $key !== "global_menu_store" && $key !== "global_menu_settings") {
              unset($aGlobalMenu[$key]);
            }
  
          }
  
          foreach ($aModuleMenu as $key=>$value) {
  
            if ($aModuleMenu[$key]["items_id"] !== "menu_iblock_/news") {
              unset($aModuleMenu[$key]);
            }
  
          }
  
        }
  
      }
    }

  }

?>