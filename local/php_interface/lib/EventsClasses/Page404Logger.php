<?
    namespace lib\EventsClasses;

    class Page404Logger {

        function addToLog() {

            if (defined('ERROR_404') && ERROR_404 == 'Y') {
                 GLOBAL $APPLICATION;
                $APPLICATION->RestartBuffer();
                include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
                require ($_SERVER['DOCUMENT_ROOT'].'/404.php');
                $page404Uri = "$_SERVER[HTTP_HOST]" . $APPLICATION->GetCurPage(true);
                echo $_SERVER["HTTP_HOST"];
                \CEventLog::Add(array(
                    "SEVERITY" => "INFO",
                    "AUDIT_TYPE_ID" => "ERROR_404",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $page404Uri
                ));
                include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';

                die();
            }
          
        }

    }

?>