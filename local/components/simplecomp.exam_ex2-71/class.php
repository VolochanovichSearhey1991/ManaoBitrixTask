<?
    use Bitrix\Main\Context;

    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
    class CatalogCreator extends CBitrixComponent {

        private function getClassificatorList($arParams) {

            $arNavParams = array(
                'nPageSize'          => $arParams['PAGINATION_COUNT_ELEM'],
                'bDescPageNumbering' => false,
                'bShowAll'           => true,
            ); 
            $arFilterCl = ['IBLOCK_ID' => $arParams['CLASSIFIER_IBLOCK_ID'], 'CHECK_PERMISSIONS' => 'Y'];
            $arSelectCl = ['IBLOCK_ID', 'ID', 'NAME'];
            $resCl = CIBlockElement::GetList([], $arFilterCl, false, $arNavParams, $arSelectCl);
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
            
            $resCl->NavStart();

            while ($clData = $resCl->Fetch()) {
                $arClassifiersId[] = $clData['ID'];// массив id всех классификаторов для передачи в запрос(получить все товары с привязками)
                $result[$clData['ID']] = [$clData['NAME'], 'ELEMS' => []];
                $count++;
            }

            $additionalFilter = [
                'LOGIC' => 'OR', 
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

            $result['minMax'] = $this->getMinMaxPrice($result);
            $result['NAV_STRING'] = $resCl;
            return $result;

        }

        private function getCountElems($arResult) {

            $count = 0;

            foreach ($arResult as $key => $classifier) {

                if ($key == 'NAV_STRING') {
                    continue;
                }

                foreach($classifier['ELEMS'] as $elem) {
                    $count++;
                }

            }

            return $count;

        }

        private function getMinMaxPrice($result) {
            
            $minPrice = $result[array_key_first($result)]['ELEMS'][0]['PROPERTY_PRICE_VALUE'];
            $maxPrice = 0;

            foreach($result as $classifier) {

                foreach ($classifier['ELEMS'] as $elem) {

                    if ($elem['PROPERTY_PRICE_VALUE'] > $maxPrice) {
                        $maxPrice = $elem['PROPERTY_PRICE_VALUE'];
                    }

                    if ($elem['PROPERTY_PRICE_VALUE'] < $minPrice) {
                        $minPrice = $elem['PROPERTY_PRICE_VALUE'];
                    }

                }

                $minMaxPrice = ['min' => $minPrice, 'max' => $maxPrice];

            }

            return $minMaxPrice;

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

            if ($this->StartResultCache(false, $USER->GetGroups(), $filter, $this->navigation) ) {
               
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