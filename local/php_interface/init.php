<?
    use \Bitrix\Main\Config\Option;
    use Bitrix\Main\Mail\Event;

    function CheckUserCount()
    {
            $filter = ['GROUPS_ID' => '1'];
            $by = ['id' => 'asc'];
            $result = CUser::GetList($by, $order = 'desc', $filter);

            while ($user = $result->Fetch()) {
                $arAdminsId[] = $user['ID'];
                $arAdminsMail[] =  $user['EMAIL'];
            }

            $usersCountNow = CUser::GetCount();
            $dateNow = time();
            $usersCountBefore = Option::get("main", "usersCount");
            $dateBefore = Option::get("main", "date");
            $dateDiff = $dateNow - $dateBefore;
            

            $dateFrom = new \DateTime('@0');
            $dateTo = new \DateTime("@$dateDiff");
            $dateDiffConvert = $dateFrom->diff($dateTo)->format('%a дней, %h часов, %i минут и %s секунд');

            $usersCountDiff = $usersCountNow - $usersCountBefore;

                Option::set("main", "usersCount", $usersCountNow);
                Option::set("main", "date", $dateNow);
        
            Event::send(array(
                "EVENT_NAME" => "USER_INFO",
                "LID" => "s1",
                "C_FIELDS" => array(
                    "EMAIL" => $arAdminsMail,
                    "USER_ID" => $arAdminsId,
                    "MESSAGE" => "зарегистрировано новых пользователей: ". $usersCountDiff ." за " . $dateDiffConvert,
                ),
            ));

            return "CheckUserCount();";
    }

?>