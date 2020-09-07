<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сменить пароль");
?><?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.changepasswd",
	"flat",
	Array(
		"COMPONENT_TEMPLATE" => "flat",
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL" => "",
		"REGISTER_URL" => "",
		"SHOW_ERRORS" => "N"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>