<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    class NewsByInterestCreator extends CBitrixComponent {

        private function getUsersList($arParams) {

            $arFilterUser = ['!' . $arParams['USER_PROPERTY'] => false];
            $arParamUser = ['SELECT' => [$arParams['USER_PROPERTY']], 'FIELDS' => ['ID', 'LOGIN']];
            $tmp = 'sort';
            $arSortUser = array('sort'=>'asc');
            $resUser = CUser::GetList($arSortUser, $tmp, $arFilterUser, $arParamUser);
            return $resUser;

        }

        private function getNewsList($arParams, $arAuthorID) {

            $arFilterNews = ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID'] => $arAuthorID];
            $arSelectNews = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM' ,'PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID']];
            $resNews = CIBlockElement::GetList(['sort' => 'asc'], $arFilterNews ,false, false, $arSelectNews);
            return $resNews;

        }

        private function delIfAuthorized($result, $curUserNewsID) {

            foreach ($result as $userKey => $user) {
    
                foreach ($user['NEWS'] as $newsKey => $news) {
                
                    foreach ($curUserNewsID as $newsId) {
    
                        if ($news['ID'] == $newsId) {
                            continue 2;
                        }
    
                    }
    
                    $userBuf['NEWS'][$newsKey] = $news;
                    $allOutputNewsId[] = $news['ID'];
                }
    
                $result[$userKey]['NEWS'] = $userBuf['NEWS'];
                $userBuf = [];
            }

            return $result;

        }

        private function getArResult($curUserID) {
            
            $resUser = $this->getUsersList($this->arParams);

            if (!$resUser) {
                $this->AbortResultCache();
            }
    
            while ($userData = $resUser->Fetch()) {
                $bufUsersData[] = $userData;
    
                if ($userData['ID'] ===  $curUserID) {
                    $curUserType = $userData[$this->arParams['USER_PROPERTY']];
                }
    
            }
    
            foreach ($bufUsersData as $user) {

                if ($user['UF_AUTHOR_TYPE'] === $curUserType) {//только если тип автора как у авторизованного пользователя
    
                    if ($user['ID'] !== $curUserID) {//сам авторизованный пользователь не включается
                        $result[$user['ID']] = $user; //формируем массив с данными по выбранным пользователям
                    }
                    
                    $arAuthorID[] =  $user['ID']; //массив id выбранных пользователей для выборки новостей(авторизованный здесь нужен чтобы потом получить массив id новостей у которых он автор)
                }

            }
    
            $resNews = $this->getNewsList($this->arParams, $arAuthorID);

            if (!$resNews) {
                $this->AbortResultCache();
            }
    
            while ($newsData = $resNews->Fetch()) {
    
                if ($newsData['PROPERTY_' . $this->arParams['PROPERTY_IBLOCK_ID'] . '_VALUE'] == $curUserID) {
                    $curUserNewsID[] = $newsData['ID'];// получаем массив id новостей у которых автор авторизованый пользователь
                }
                
                $propIblockId = $newsData['PROPERTY_' . $this->arParams['PROPERTY_IBLOCK_ID'] . '_VALUE'];
                if ($propIblockId != $curUserID)
                $result[$propIblockId]['NEWS'][] =  $newsData; // массив с данными по выбранным пользователям дополняем новостями по каждому пользователю(кроме авторизованного)
            }
    
            // убираем новости у которыв в авторстве есть авторизованный пользователь
            $result = $this->delIfAuthorized($result, $curUserNewsID);

            return $result;

        }

        private function getCountNews($result) {

            $count = 0;

            foreach ($result as $user) {

                foreach ($user['NEWS'] as $news) {
                    $count++;
                }

            }

            return $count;

        }

        public function executeComponent() {
            GLOBAL $USER;
            GLOBAL $APPLICATION;

            $curUserID = $USER->GetID();

            if ($this->StartResultCache(false, $curUserID) ) {
                $this->arResult = $this->getArResult($curUserID);
                $countNews = $this->getCountNews($this->arResult);
                $this->IncludeComponentTemplate();
            }
        
            $count = count(array_count_values($allOutputNewsId));
            $APPLICATION->SetTitle('Новостей: ' . $countNews);
            
        }

    }
?>