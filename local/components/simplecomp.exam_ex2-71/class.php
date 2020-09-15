<?
    use Bitrix\Main\Context;

    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
    class CatalogCreator extends CBitrixComponent {

        private function getClassificatorList($arParams) {

            $arFilterCl = ['IBLOCK_ID' => $arParams['CLASSIFIER_IBLOCK_ID'], 'CHECK_PERMISSIONS' => 'Y'];
            $arSelectCl = ['IBLOCK_ID', 'ID', 'NAME'];
            $resCl = CIBlockElement::GetList([], $arFilterCl, false, false, $arSelectCl);
            return $resCl;

        }
        
        private function getElemsList($arParams, $arClassifiersId, $additionalFilter = '') {


            $arFilterEl = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 
            $additionalFilter, 
            'PROPERTY_FIRM.ID' => $arClassifiersId, 
            'CHECK_PERMISSIONS' => 'Y'];
            $arSelectEl = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FIRM', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'DETAIL_PAGE_URL'];
            $arSortEl = ['name' => 'asc', 'sort' => 'asc'];
            $resEl = CIBlockElement::GetList($arSortEl, $arFilterEl, false, false, $arSelectEl);
            $resEl->SetUrlTemplates($arParams["DETAIL_URL"], "", "");
            return $resEl;

        }

        private function getEditLinks(&$arElem) {

            $arButtons = CIBlock::GetPanelButtons(
                $arElem["IBLOCK_ID"],
                $arElem["ID"],
                0,
                array("SECTION_BUTTONS"=>false, "SESSID"=>false)
            );
            $arElem["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
            $arElem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
            $arElem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

        }

        private function getArResult($filter = null) {
            
            $resCl = $this->getClassificatorList($this->arParams);
                
            if (!$resCl) {
                $this->AbortResultCache();
            }
        
            while ($clData = $resCl->Fetch()) {
                $arClassifiersId[] = $clData['ID'];// массив id всех классификаторов для передачи в запрос(получить все товары с привязками)
                $result[$clData['ID']] = [$clData['NAME'], 'ELEMS' => []];
                $count++;
            }

            $additionalFilter = ['LOGIC' => 'OR', 
            ['<=PROPERTY_PRICE' => '1700', '=PROPERTY_MATERIAL' => 'Дерево, ткань'],
            ['<PROPERTY_PRICE' => '1500', '=PROPERTY_MATERIAL' => 'Металл, пластик']
            ];

            if (!empty($filter)) {
                $resEl = $this->getElemsList($this->arParams, $arClassifiersId, $additionalFilter);
            } else {
                $resEl = $this->getElemsList($this->arParams, $arClassifiersId);
            }
            
            if (!$resEl) {
                $this->AbortResultCache();
            }
        
            while ($elData = $resEl->GetNextElement()) {
                $bufAr = $elData->GetFields();
                $this->getEditLinks($bufAr);
                $result[$bufAr['PROPERTY_FIRM_VALUE']]['ELEMS'][] = $bufAr;//id классификатора ключ массива, PROPERTY_FIRM_VALUE также содержит id классификатора, каждый товар попадет в нужный подмассив
            }

            return $result;

        }

        private function getCountElems($arResult) {

            $count = 0;

            foreach ($arResult as $classifier) {

                foreach($classifier['ELEMS'] as $elem) {
                    $count++;
                }

            }

            return $count;

        }

        private function setAdditionalMenu($iblocId) {
            GLOBAL $APPLICATION;
            
            if ($APPLICATION->GetShowIncludeAreas()) {
            $this->AddIncludeAreaIcon(
                [
                    "ID" => "ibadmin",
                    "TITLE" => "ИБ в админке",
                    "URL" => "/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=" . $iblocId . "&type=products", 
                    "IN_PARAMS_MENU" => true, 
                    "IN_MENU" => false 
                ]
            );
            }

        }

        public function executeComponent() {
            
            GLOBAL $USER; 
            GLOBAL $APPLICATION;

            $request = Context::getCurrent()->getRequest();
            $filter = $request->getQuery("F");

            if ($this->StartResultCache(false, $USER->GetGroups() . $filter) ) {
               
                if (!empty($filter)) {
                    $this->AbortResultCache();
                }

                $this->arResult = $this->getArResult($filter);
                $countElems = $this->getCountElems($this->arResult);
                $this->IncludeComponentTemplate();
            }

            $this->setAdditionalMenu($this->arParams['CATALOG_IBLOCK_ID']);
            $APPLICATION->SetTitle('Разделов: ' . $countElems);
    
        }

    }
?>