<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


  echo '<pre>'.print_r($arResult, true).'</pre>';

  if (isset($arResult["FIRST_NEWS_DATE"])) {
    $APPLICATION->SetPageProperty("specialdateContent", $arResult["FIRST_NEWS_DATE"]);
  }
?>