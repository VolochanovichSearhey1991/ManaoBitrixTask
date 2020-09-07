<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("testPage");
CModule::IncludeModule("iblock");
?>


<?
	$db_prop = CIBlockElement::GetProperty(1, 2, Array("sort"=>"asc"), Array("CODE"=>"SV4") );
	
	while ($arr = $db_prop->GetNext())
	print_r($arr["VALUE"]);
	
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>