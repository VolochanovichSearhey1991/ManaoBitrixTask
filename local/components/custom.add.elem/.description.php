<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	
	$arComponentDescription = Array(
		"NAME" => GetMessage('IBlockElemAdd'),
		"DESCRIPTION" => "this component is needed to add new elements into infoblocs",
		"CACHE_PATH" => "Y",
		"PATH" => Array(
			"ID" => "myComponents",
		)
	);
?>