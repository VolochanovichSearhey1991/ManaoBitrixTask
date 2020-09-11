<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    if ($USER->IsAuthorized()) {

    
    echo '<h3>';
    $APPLICATION->ShowTitle();
    echo '</h3>';
    echo '<p>Авторы и новости: </p>';
    echo '<ul>';
 
    foreach ($arResult as $users) {
        echo '<li>' . '[' . $users['ID'] . '] - ' . $users['LOGIN'] . '</li>';
        echo '<ul>';

        foreach ($users['NEWS'] as $news) {
            $newsData = $news['NAME'] . ' - ' . $news['DATE_ACTIVE_FROM'];
            echo '<li>' . $newsData . '</li>';
        }

        echo '</ul>';
        $newsData = '';
    }

    echo '</ul>';
    }
?>
