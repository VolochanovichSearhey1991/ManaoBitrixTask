<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

	<div class="bx-404-container">
		<div class="bx-404-block"><img src="<?=SITE_DIR?>images/404.png" alt=""></div>
		<div class="bx-404-text-block">Неправильно набран адрес, <br>или такой страницы на сайте больше не существует.</div>
		<div class="">Вернитесь на <a href="<?=SITE_DIR?>">главную</a></div>
		<?
			$page404Uri = "http://$_SERVER[HTTP_HOST]" . $APPLICATION->GetCurPage(true);
			CEventLog::Add(array(
				"SEVERITY" => "INFO",
				"AUDIT_TYPE_ID" => "ERROR_404",
				"MODULE_ID" => "main",
				"DESCRIPTION" => $page404Uri
		 ));
		?>
	</div>
	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>