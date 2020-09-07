<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	
	if (!CModule::IncludeModule("iblock")) {
		return;
	}
	
	$arIblockTypes = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));
	
	$db_iblock = CIBlock::GetList(Array("SORT" => "ASC"), Array("SITE_ID" => $_REQUEST["site"], 
									"TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
	
	while ($res = $db_iblock->Fetch()) {
		$arIblockID[$res["ID"]] = "[" . $res["ID"] . "] " . $res["NAME"];
	}
	
	$arComponentParameters = Array(
		"GROUPS" => Array(),
		"PARAMETERS" => Array(
			"IBLOCK_TYPE" => Array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("IBlockType"),
				"TYPE" => "LIST",
				"VALUES" => $arIblockTypes,
				"REFRESH" => "Y"
			),
			"IBLOCK_ID" => Array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("IBlockID"),
				"TYPE" => "LIST",
				"VALUES" => $arIblockID,
				"REFRESH" => "Y"
			)
		)
	);
?>