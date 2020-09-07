<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

  if ($arParams["SET_SPECIALDATE_PROPERTY"] === "Y") {
    $firstNewsDate = $arResult["ITEMS"]["0"]["ACTIVE_FROM"];
    $componentObject = $this->__component; 

    if (is_object($componentObject))
    {
        $componentObject->arResult['FIRST_NEWS_DATE'] = $firstNewsDate;
        $componentObject->SetResultCacheKeys(array("FIRST_NEWS_DATE"));

    }

  }

?>