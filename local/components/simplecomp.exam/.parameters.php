<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    if(!CModule::IncludeModule("iblock")) {
        return;
    }

    $arComponentParameters = [
        'GROUPS' => [],
        'PARAMETERS' => [
            'CATALOG_IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_CATALOG_IBLOCK_ID'),
                'TYPE' => 'STRING',
                'MULTIPLE' => 'N',
                'DEFAULT' => ""
            ],
            'NEWS_IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_NEWS_IBLOCK_ID'),
                'TYPE' => 'STRING',
                'MULTIPLE' => 'N',
                'DEFAULT' => ""
            ],
            'UF_NEWS_LINK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_UF_NEWS_LINK_ID'),
                'TYPE' => 'STRING',
                'MULTIPLE' => 'N',
                'DEFAULT' => ""
            ],
            'CACHE_TIME'  =>  ["DEFAULT"=>36000000],
        ]
    ];
?>