<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

    $outputLine = '---Текст из компонента ---</br> минимальная цена: ' . $arResult['minMax']['min'] . '</br>максимальная цена: ' .  $arResult['minMax']['max'];
    $APPLICATION->AddViewContent('minMaxPrice', $outputLine);

?>