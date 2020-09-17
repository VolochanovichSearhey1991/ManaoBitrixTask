<?
   if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    echo '<h3>';
    echo 'Разделов: ' . $arResult['count'] . "</h3> </br>"; 
    echo time() . "</br>";
    echo "фильтр: <a href='" . $APPLICATION->GetCurPage() . "?F=Y'> 
        " . SITE_SERVER_NAME . $APPLICATION->GetCurPage(true) . "?F=Y </a>
        <p> Каталог: <a href='" . $APPLICATION->GetCurPage() . "'> " . SITE_SERVER_NAME . $APPLICATION->GetCurPage(true) . " </a> </p> 
        <ul>";
    $i = 1;

    foreach ($arResult as $key => $classifier) {

        if ($key == 'minMax' || $key == 'NAV_STRING' || $key == 'count') {
            continue;
        }

        echo '<li>' . $classifier[0] . '</li>';
        echo '<ul>';

        foreach ($classifier['ELEMS'] as $element) {
            $elemData = $element['NAME'] . ' ' . $element['PROPERTY_PRICE_VALUE'] . 
                ' ' . $element['PROPERTY_MATERIAL_VALUE'] . 
                    ' ' . $element['PROPERTY_ARTNUMBER_VALUE'];

            $this->AddEditAction($element['ID'] . ++$i, $element['EDIT_LINK'], GetMessage('EDIT_ELEM'));
            $this->AddEditAction($element['ID'] . $i, $element['ADD_LINK'], GetMessage('ADD_ELEM'));
            $this->AddDeleteAction($element['ID']  . $i, $element['DELETE_LINK'], GetMessage('DEL_ELEM'), array("CONFIRM" => "Удалить?"));
            
            echo "<li id=" . $this->GetEditAreaId($element['ID'] . $i) . ">" . $elemData . " <a href='" . $element['DETAIL_PAGE_URL'] . "'>" . $element['DETAIL_PAGE_URL'] . "</a> </li>";
        }

        echo '</ul>';
        $elemData = '';
    }

    echo '<p><b>Навигация:</b></p>';
    echo $arResult['NAV_STRING'];
?>
</ul>
