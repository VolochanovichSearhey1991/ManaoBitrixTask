<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	
	//$arResult = $arParams;
	$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"]);
	$arListElem = CIBlockElement::GetList(Array("id"=>"asc"),$arFilter);
	
	while ($arBuf = $arListElem->GetNext()) {
		
		$arrOfNeedInf[$arBuf["ID"]] = Array($arBuf["NAME"], $arBuf["PREVIEW_PICTURE"], $arBuf["PREVIEW_TEXT"],
			$arBuf["DETAIL_PICTURE"], $arBuf["DETAIL_TEXT"]);
		$arResult = $arrOfNeedInf;
		
	}
	
	$this->IncludeComponentTemplate();
?>