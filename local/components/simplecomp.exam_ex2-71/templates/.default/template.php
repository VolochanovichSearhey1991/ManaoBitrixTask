<?
   if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    echo '<h3>';
    echo $APPLICATION->ShowTitle(); //убрать глобальную переменную
    echo "
        </h3> 
        фильтр: <a href='http://980trainee.dev-bitrix.by/?F=Y'> 980trainee.dev-bitrix.by/?F=Y </a>
        <p> Каталог: <a href='http://980trainee.dev-bitrix.by'> 980trainee.dev-bitrix.by </a> </p> 
        <ul>";//убрать абсолютные ссылки
    $i = 1;

    foreach ($arResult as $key => $classifier) {

        if ($key == 'minMax' || $key == 'NAV_STRING') {
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
    echo $arResult['NAV_STRING']->NavPrint("раздел");
?>
</ul>
