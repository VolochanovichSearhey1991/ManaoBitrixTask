<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    class CatalogCreator extends CBitrixComponent {

        private function getNewsList($arParams) {

            $arFilterNews = ['IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID']];
            $arSelectNews = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
            $resNews = CIBlockElement::GetList([], $arFilterNews, false, false, $arSelectNews);
            return $resNews;

        }

        private function getProductSections($arParams, $arNewsID) {

            $arFilterDir = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'UF_NEWS_LINK' => $arNewsID];
            $arSelectDir = ['IBLOCK_ID', 'ID', 'NAME', 'UF_NEWS_LINK'];
            $resDir = CIBlockSection::GetList([], $arFilterDir, false, $arSelectDir);
            return $resDir;

        }

        private function getProductElems($arParams, $arDirID) {


            $arFilterElem = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'SECTION_ID' => $arDirID];
            $arSelectElem = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'IBLOCK_SECTION_ID'];
            $resElem = CIBlockElement::GetList([], $arFilterElem, false, false, $arSelectElem);
            return $resElem;

        }

        private function getArResult() {

                $resNews = $this->getNewsList($this->arParams);
        
                if (!$resNews) {
                    $this->AbortResultCache();
                }
        
                while ($newsData = $resNews->Fetch()) {
                    $arNewsID[] =  $newsData['ID'];
                    $result[$newsData['ID']] = [$newsData['NAME'], $newsData['DATE_ACTIVE_FROM'], 'SECTIONS'=>[]];
                }
        
                $resDir = $this->getProductSections($this->arParams, $arNewsID);

                if (!$resDir) {
                    $this->AbortResultCache();
                }
        
                while ($dirData = $resDir->Fetch()) {
                    $arDirID[] = $dirData['ID'];
                    $arDirData[$dirData['ID']] = $dirData;
                    
                }
        
                $resElem = $this->getProductElems($this->arParams, $arDirID);
        
                if (!$resElem) {
                    $this->AbortResultCache();
                }
        
                while ($elemData = $resElem->Fetch()) {
                    $arDirData[$elemData['IBLOCK_SECTION_ID']]['elems'][] = $elemData;
                }
        
                foreach ($arDirData as $dir) {
        
                    foreach ($dir['UF_NEWS_LINK'] as $property) {
                        $result[$property]['SECTIONS'][] = $dir;
                    }
        
                }

                return $result;

        }

        private function getCountElems($result) {

            $count = 0;
            
            foreach ($result as $news) {

                foreach ($news['SECTIONS'] as $section) {

                    foreach ($section['elems'] as $elem) {
                        $count++;
                    }

                }

            }

            return $count;

        }

        public function executeComponent() {

            GLOBAL $APPLICATION;

            if ($this->StartResultCache()) {
                $this->arResult = $this->getArResult();
                $countElems = $this->getCountElems($this->arResult);
                $this->IncludeComponentTemplate();
            }

            $APPLICATION->SetTitle($countElems);
            
        } 
    }
?>