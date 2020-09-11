<?
    namespace lib\EventsClasses;

    class Page404Logger {

        function addToLog() {

            if (defined('ERROR_404') && ERROR_404 == 'Y') {
                 GLOBAL $APPLICATION;
                $APPLICATION->RestartBuffer();
                include $_SERVER['DOCUMENT_ROOT'].'/local/templates/default_eshop_template/header.php';
                require ($_SERVER['DOCUMENT_ROOT'].'/404.php');
                $page404Uri = "http://$_SERVER[HTTP_HOST]" . $APPLICATION->GetCurPage(true);
                
                \CEventLog::Add(array(
                    "SEVERITY" => "INFO",
                    "AUDIT_TYPE_ID" => "ERROR_404",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $page404Uri
                ));
                include $_SERVER['DOCUMENT_ROOT'].'/local/templates/default_eshop_template/footer.php';

                die();
            }
          
        }

    }

?>