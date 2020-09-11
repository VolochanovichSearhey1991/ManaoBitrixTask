<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    if(!CModule::IncludeModule("iblock")) {
        return;
    }

    $arComponentParameters = [
        'GROUPS' => [],
        'PARAMETERS' => [
            'IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_IBLOCK_ID'),
                'TYPE' => 'STRING',
                'DEFAULT' => ""
            ],
            'PROPERTY_IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_PROPERTY_IBLOCK_ID'),
                'TYPE' => 'STRING',
                'DEFAULT' => ""
            ],
            'USER_PROPERTY' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_USER_PROPERTY'),
                'TYPE' => 'STRING',
                'DEFAULT' => ""
            ],
            'CACHE_TIME'  =>  ["DEFAULT"=>36000000],
        ]
    ];
?>