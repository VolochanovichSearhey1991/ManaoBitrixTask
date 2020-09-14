<?
   if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
   <h3> <?=$APPLICATION->ShowTitle()?> </h3>
   <p>Каталог: </p>
   <ul>
<?

    foreach ($arResult as $classifier) {
        echo '<li>' . $classifier[0] . '</li>';
        echo '<ul>';

        foreach ($classifier['ELEMS'] as $element) {
            $elemData = $element['NAME'] . ' ' . $element['PROPERTY_PRICE_VALUE'] . 
                ' ' . $element['PROPERTY_MATERIAL_VALUE'] . 
                    ' ' . $element['PROPERTY_ARTNUMBER_VALUE'];
            echo '<li>' . $elemData . " <a href='" . $element['DETAIL_PAGE_URL'] . "'>смотреть детально</a> </li>";
        }

        echo '</ul>';
        $elemData = '';
    }

?>
</ul>