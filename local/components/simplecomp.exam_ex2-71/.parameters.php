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
                'DEFAULT' => ""
            ],
            'CLASSIFIER_IBLOCK_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_CLASSIFIER_IBLOCK_ID'),
                'TYPE' => 'STRING',
                'DEFAULT' => ""
            ],
            'PAGINATION_COUNT_ELEM' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_PAGINATION_COUNT_ELEM'),
                'TYPE' => 'STRING',
                'DEFAULT' => "3"
            ],
            "DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
                "DETAIL",
                "DETAIL_URL",
                GetMessage("T_IBLOCK_DESC_DETAIL_PAGE_URL"),
                "",
                "URL_TEMPLATES"
            ),
            'PROPERTY_ID' => [
                'PARENT' => 'BASE',
                'NAME' => GetMessage('MY_COMPONENT_PROPERTY_ID'),
                'TYPE' => 'STRING',
                'DEFAULT' => ""
            ],
            'CACHE_TIME'  =>  ["DEFAULT"=>36000000],
        ]
    ];
?>