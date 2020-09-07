<? 
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

  $canonicalElemName = $arResult["CANONICAL_ELEM_NAME"];
  
  if (!empty($canonicalElemName)) {
		$APPLICATION->SetPageProperty("canonical", $canonicalElemName);
	} 

?>