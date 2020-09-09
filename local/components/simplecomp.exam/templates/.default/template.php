<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
    $elemStr = '';
    $headStr = '';
    ?>
    <h3> Элементов - <? $APPLICATION->ShowTitle();?> </h3>
    <?
    foreach ($arResult as $news) {

        $headStr = '<b>' . $news['0'] . '</b> - ' . $news['1'] . ' (';

        foreach ($news['2'] as $dirName) {
            $headStr .= ' ' . $dirName[1];

            foreach ($dirName[2] as $elemList) {

                    $bufArr[] = [$elemList['NAME'], $elemList['PROPERTY_PRICE_VALUE'], $elemList['PROPERTY_MATERIAL_VALUE'], $elemList['PROPERTY_ARTNUMBER_VALUE']];

            }
        }
        
        ?>
        <ul>
            <li><?=$headStr . ') </br>';?></li>
            <ul>
        <?
        foreach ($bufArr as $elem) {

            foreach ($elem as $field) {
                $elemStr .= $field . ' ';
            }
            
            ?>
            <li> <?=$elemStr?> </li>
            <?
            $elemStr = '';
        }
        
        ?>
        </ul>
            </ul>
        <?
        $bufArr = [];
    }  

?>