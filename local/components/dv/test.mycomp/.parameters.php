<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	
	CModule::IncludeModule("iblock");
	$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));
	$dbIblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID" => $_REQUEST["site"], "TYPE"=>($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
	
	while ($arRes = $dbIblock->Fetch()) {
		$arFinal[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];
	}
	
	print_r($dbIblock);
	$arComponentParameters = array(
		"GROUPS" => array(
		),
		"PARAMETERS" => array(
			"IBLOCK_TYPE" => array(
				"PARENT" => "BASE",
				"NAME" => "IBlockType",
				"TYPE" => "LIST",
				"VALUES" => $arTypesEx,
				"DEFAULT" => "news",
				"REFRESH" => "Y",
			),
			"IBLOCK_ID" => array(
				"PARENT" => "BASE",
				"NAME" => "iblock",
				"TYPE" => "LIST",
				"VALUES" => $arFinal
			),
			"STRING_COUNT" => array(
				"PARENT" => "BASE",
				"NAME" => "count",
				"TYPE" => "STRING"
			)
		)
	);
	
?>