<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    $curUserID = $USER->GetID();

    if ( $this->StartResultCache(false, $curUserID) ) {

        $arFilterUser = ['!' . $arParams['USER_PROPERTY'] => false];
        $arParamUser = ['SELECT' => [$arParams['USER_PROPERTY']], 'FIELDS' => ['ID', 'LOGIN']];
        $tmp = 'sort';
        $arSortUser = array('sort'=>'asc');
        $resUser = CUser::GetList($arSortUser, $tmp, $arFilterUser, $arParamUser);

        while ($userData = $resUser->Fetch()) {
            $bufUsersData[] = $userData;

            if ($userData['ID'] ===  $curUserID) {
                $curUserType = $userData[$arParams['USER_PROPERTY']];
            }

        }

        foreach ($bufUsersData as $user) {
            if ($user['UF_AUTHOR_TYPE'] === $curUserType) {//только если тип автора как у авторизованного пользователя

                if ($user['ID'] !== $curUserID) {//сам авторизованный пользователь не включается
                    $arResult[$user['ID']] = $user; //формируем массив с данными по выбранным пользователям
                }
                
                $arAuthorID[] =  $user['ID']; //массив id выбранных пользователей для выборки новостей(авторизованный здесь нужен чтобы потом получить массив id новостей у которых он автор)
            }
        }

        $arFilterNews = ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID'] => $arAuthorID];
        $arSelectNews = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM' ,'PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID']];
        $resNews = CIBlockElement::GetList(['sort' => 'asc'], $arFilterNews ,false, false, $arSelectNews);

        while ($newsData = $resNews->Fetch()) {

            if ($newsData['PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID'] . '_VALUE'] == $curUserID) {
                $curUserNewsID[] = $newsData['ID'];// получаем массив id новостей у которых автор авторизованый пользователь
            }
            
            $propIblockId = $newsData['PROPERTY_' . $arParams['PROPERTY_IBLOCK_ID'] . '_VALUE'];
            if ($propIblockId != $curUserID)
            $arResult[$propIblockId]['NEWS'][] =  $newsData; // массив с данными по выбранным пользователям дополняем новостями по каждому пользователю(кроме авторизованного)
        }

        // убираем новости у которыв в авторстве есть авторизованный пользователь
        foreach ($arResult as $userKey => $user) {

            foreach ($user['NEWS'] as $newsKey => $news) {
            
                foreach ($curUserNewsID as $newsId) {

                    if ($news['ID'] == $newsId) {
                        continue 2;
                    }

                }

                $userBuf['NEWS'][$newsKey] = $news;
                $allOutputNewsId[] = $news['ID'];
            }

            $arResult[$userKey]['NEWS'] = $userBuf['NEWS'];
            $userBuf = [];
        }

        $this->IncludeComponentTemplate();
    }

    $count = count(array_count_values($allOutputNewsId));
    $APPLICATION->SetTitle('Новостей: ' . $count);

?>