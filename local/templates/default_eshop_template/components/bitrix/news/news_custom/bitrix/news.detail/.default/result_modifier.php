<?
  if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

  if (!empty($arParams["ID_FOR_CANONICAL"])) {
    $thisElemId = $arResult["ID"];
    $canonicalIblockId = $arParams["ID_FOR_CANONICAL"];
    $arFilter = array("IBLOCK_ID" => $canonicalIblockId, "PROPERTY_NEWS_PROP" => $thisElemId);
    $arSelect = array("ID","NAME");
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    $arList = $res->Fetch();

    if (count($arList) > 0) {
      $componentObject = $this->__component;

    if (is_object($componentObject)){
        $componentObject->arResult['CANONICAL_ELEM_NAME'] = $arList["NAME"];
        $componentObject->SetResultCacheKeys(array("CANONICAL_ELEM_NAME"));
    }

    }
  }


?>