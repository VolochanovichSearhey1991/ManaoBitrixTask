<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	$arResult["IBLOCK_TYPE"] =  $arParams["IBLOCK_TYPE"];
	$arResult["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
	
	$this->IncludeComponentTemplate();
?>