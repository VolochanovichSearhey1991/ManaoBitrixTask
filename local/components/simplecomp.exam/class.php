<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    class CatalogCreator extends CBitrixComponent {

        private function getNewsList() {

            $arFilterNews = ['IBLOCK_ID' => $this->arParams['NEWS_IBLOCK_ID']];
            $arSelectNews = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
            $resNews = CIBlockElement::GetList([], $arFilterNews, false, false, $arSelectNews);
            return $resNews;

        }

        private function getProductSections($arNewsID) {

            $arFilterDir = ['IBLOCK_ID' => $this->arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'UF_NEWS_LINK' => $arNewsID];
            $arSelectDir = ['IBLOCK_ID', 'ID', 'NAME', 'UF_NEWS_LINK'];
            $resDir = CIBlockSection::GetList([], $arFilterDir, false, $arSelectDir);
            return $resDir;

        }

        private function getProductElems($arDirID) {


            $arFilterElem = ['IBLOCK_ID' => $this->arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'SECTION_ID' => $arDirID];
            $arSelectElem = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'IBLOCK_SECTION_ID'];
            $resElem = CIBlockElement::GetList([], $arFilterElem, false, false, $arSelectElem);
            return $resElem;

        }

        private function getArResult() {

                $resNews = $this->getNewsList();
        
                if (!$resNews) {
                    $this->AbortResultCache();
                }
        
                while ($newsData = $resNews->Fetch()) {
                    $arNewsID[] =  $newsData['ID'];
                    $result[$newsData['ID']] = [
                                                'NEWS_NAME' => $newsData['NAME'], 
                                                'NEWS_DATE' => $newsData['DATE_ACTIVE_FROM'], 
                                                'DIRECTORY' => [], 'ELEMS' => []
                                            ];
                }
        
                $resDir = $this->getProductSections($arNewsID);

                if (!$resDir) {
                    $this->AbortResultCache();
                }
        
                while ($dirData = $resDir->Fetch()) {
                    $arDirID[] = $dirData['ID'];
                    
                    foreach ($dirData['UF_NEWS_LINK'] as $newsLink) {
                        $result[$newsLink]['DIRECTORY'][$dirData['ID']] = $dirData;
                    }

                }
                
                $resElem = $this->getProductElems($arDirID);
                
                if (!$resElem) {
                    $this->AbortResultCache();
                }
                
                $countElems = $resElem->SelectedRowsCount();
                
                while ($elemData = $resElem->Fetch()) {
                    
                    foreach ($result as $key => $news) {

                        foreach ($news['DIRECTORY'] as $dir) {

                            if ($elemData['IBLOCK_SECTION_ID'] == $dir['ID']) {
                               $result[$key]['ELEMS'][] =  $elemData;
                               
                            }

                        } 

                    }
        
                }

                $result['COUNT_ELEMS'] = $countElems;
                return $result;

        }

        public function executeComponent() {

            GLOBAL $APPLICATION;

            if ($this->StartResultCache()) {
                $this->arResult = $this->getArResult();
                $this->SetResultCacheKeys(['COUNT_ELEMS']);
                $this->IncludeComponentTemplate();
            }

            $APPLICATION->SetTitle($this->arResult['COUNT_ELEMS']);
            
        } 
    }
?>