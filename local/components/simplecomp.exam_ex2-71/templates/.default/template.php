<?
   if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    echo '<h3>';
    echo $APPLICATION->ShowTitle(); 
    echo "
        </h3> 
        фильтр: <a href='http://980trainee.dev-bitrix.by/?F=Y'> 980trainee.dev-bitrix.by/?F=Y </a>
        <p> Каталог: <a href='http://980trainee.dev-bitrix.by'> 980trainee.dev-bitrix.by </a> </p> 
        <ul>";

    foreach ($arResult as $classifier) {
        echo '<li>' . $classifier[0] . '</li>';
        echo '<ul>';

        foreach ($classifier['ELEMS'] as $element) {
            $elemData = $element['NAME'] . ' ' . $element['PROPERTY_PRICE_VALUE'] . 
                ' ' . $element['PROPERTY_MATERIAL_VALUE'] . 
                    ' ' . $element['PROPERTY_ARTNUMBER_VALUE'];
            echo '<li>' . $elemData . " <a href='" . $element['DETAIL_PAGE_URL'] . "'>" . $element['DETAIL_PAGE_URL'] . "</a> </li>";
        }

        echo '</ul>';
        $elemData = '';
    }

?>
</ul>