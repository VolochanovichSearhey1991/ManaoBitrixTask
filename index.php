<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("type_of_page", "Самая главная");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam_ex2-71",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CATALOG_IBLOCK_ID" => "16",
		"CLASSIFIER_IBLOCK_ID" => "19",
		"DETAILED_LINK_TEMPLATE" => "/detailpage.php",
		"DETAIL_URL" => "catalog_exam/#SECTION_ID#/#ID#",
		"PAGINATION_COUNT_ELEM" => "2",
		"PROPERTY_ID" => "FIRM"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>