<?
//define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");

$userName = CUser::GetFullName();
if (!$userName)
	$userName = CUser::GetLogin();
?><p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	"flat", 
	array(
		"FORGOT_PASSWORD_URL" => "/auth/forget.php",
		"PROFILE_URL" => "/auth/personal.php",
		"REGISTER_URL" => "/auth/registration.php",
		"SHOW_ERRORS" => "Y",
		"COMPONENT_TEMPLATE" => "flat"
	),
	false
);?><br>
</p>
<p>
 <br>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>