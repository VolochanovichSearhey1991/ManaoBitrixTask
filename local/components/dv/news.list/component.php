<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $INTRANET_TOOLBAR;


	

	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"DETAIL_PAGE_URL",
	));

	$arFilter = array (
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
	);

	$rsElement = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
	$rsElement->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);

	while($obElement = $rsElement->GetNextElement())
	{
		$arItem = $obElement->GetFields();
		$arResult["ITEMS"][] = $arItem;
	}


	$this->includeComponentTemplate();

