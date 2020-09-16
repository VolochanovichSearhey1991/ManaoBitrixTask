<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    echo "<h3> Элементов: " . $arResult['COUNT_ELEMS'] . "</h3>";
    
    echo '<ul>';

    foreach ($arResult as $key => $news) {

        if ($key == 'COUNT_ELEMS') {
            continue;
        }

        $headStr = '<b>' . $news['NEWS_NAME'] . '</b> - ' . $news['NEWS_DATE'] . ' (';

        foreach ($news['DIRECTORY'] as $dirData) {
            $headStr .= ' ' . $dirData['NAME'];
        }

        $headStr .= ')';
        echo '<li>' . $headStr . '</li>';
            echo '<ul>';

        foreach ($news['ELEMS'] as $elem) {
           echo '<li>' . $elem['NAME'] . ' - ' . $elem['PROPERTY_PRICE_VALUE'] . ' - ' . $elem['PROPERTY_MATERIAL_VALUE'] . ' - ' . $elem['PROPERTY_ARTNUMBER_VALUE'] . '</li>';
        }

            echo '</ul>';
    }

    echo '</ul>';

?>