<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


if(!CModule::IncludeModule("iblock"))
	return;


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '1',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			GetMessage("T_IBLOCK_DESC_DETAIL_PAGE_URL"),
			"",
			"URL_TEMPLATES"
		),
		
	),
);
