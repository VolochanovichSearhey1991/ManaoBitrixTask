<?
    use \Bitrix\Main\Security\Random;
    use \Bitrix\Main\Type\DateTime;

    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    global $USER;

    CModule::IncludeModule("iblock");
    $el = new CIBlockElement;
    $objDateTime = new DateTime();
    $activeFrom = $objDateTime->format('d.m.Y');
        
    if ($USER->IsAuthorized()) {
        $userData = 'ID - ' . $USER->GetID() . ', login - ' . $USER->GetLogin() . ', Name - ' . $USER->GetFullName();
    } else {
        $userData = 'Не авторизован';
    }

    
    if (isset($_POST['complaint']) && $_POST['complaint'] == 'Y') {
        $propertyData = [
            'USER' => $userData,
            'NEWS' => $_POST['id'],
        ];
        $elemDate = [
            'IBLOCK_SECTION_ID' => false,
            'IBLOCK_ID' => 20,
            'PROPERTY_VALUES' => $propertyData,
            'NAME' => Random::getString(20),
            'ACTIVE' => 'Y',
            'ACTIVE_FROM' => $activeFrom,
        ];

        if ($newItemId = $el->Add($elemDate)) {
            echo 'Ваше мнение учтено, №' . $newItemId;
        } else {
            echo 'Ошибка';
        } 
        
      
    } elseif (isset($_GET['complaint']) && $_GET['complaint'] == 'Y') {
        $propertyData = [
            'USER' => $userData,
            'NEWS' => $_GET['COMPLAINT_ID'],
        ];
        $elemDate = [
            'IBLOCK_SECTION_ID' => false,
            'IBLOCK_ID' => 20,
            'PROPERTY_VALUES' => $propertyData,
            'NAME' => Random::getString(20),
            'ACTIVE' => 'Y',
            'ACTIVE_FROM' => $activeFrom,
        ];

        if ($newItemId = $el->Add($elemDate)) {
            echo "<script>
                    output.insertAdjacentHTML('afterend', '<p> Ваше мнение учтено, №' + " . $newItemId . " + '</p>');
                </script>";
        } else {
            echo "<script>
                    output.insertAdjacentHTML('afterend', '<p> Ошибка </p>');
                </script>"; 
        } 
        
    }
  
?>