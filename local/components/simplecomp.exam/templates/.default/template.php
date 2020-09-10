<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    $elemStr = '';
    $headStr = '';
    ?>
    <h3> Элементов - <? $APPLICATION->ShowTitle();?> </h3>
    <?
    echo '<ul>';

    foreach ($arResult as $news) {
        $headStr = '<b>' . $news['0'] . '</b> - ' . $news['1'] . ' (';

        foreach ($news['2'] as $dirData) {
            $headStr .= ' ' . $dirData['NAME'];

            foreach ($dirData['elems'] as $elem) {
                $arElems[] = $elem;
            }
            

        }

        $headStr .= ')';

        echo '<li>' . $headStr . '</li>';
            echo '<ul>';

                foreach ($arElems as $elem) {
                    echo '<li>' . $elem['NAME'] . ' - ' . $elem['PROPERTY_PRICE_VALUE'] . ' - ' . $elem['PROPERTY_MATERIAL_VALUE'] . ' - ' . $elem['PROPERTY_ARTNUMBER_VALUE'] . '</li>';
                }
                
            echo '</ul>';
            $arElems = [];
    }

    echo '</ul>';
?>