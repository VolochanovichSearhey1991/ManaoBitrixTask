<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
  print_r($arResult);

  if (isset($arResult["FIRST_NEWS_DATE"])) {
    $APPLICATION->SetPageProperty("specialdateContent", $arResult["FIRST_NEWS_DATE"]);
  }
?>