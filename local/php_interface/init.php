<?

    use \Bitrix\Main\Config\Option;
    use Bitrix\Main\Mail\Event;

    class NewUsersCounter {

        private function getAdminUsers() {
            $filter = ['GROUPS_ID' => '1'];
            $by = ['id' => 'asc'];
            $result = CUser::GetList($by, $order = 'desc', $filter);
            return $result;
        }

        private function dateDiffConvert($dateDiff) {

            $dateFrom = new \DateTime('@0');
            $dateTo = new \DateTime("@$dateDiff");
            $dateDiffConvert = $dateFrom->diff($dateTo)->format('%a дней, %h часов, %i минут и %s секунд');
            return $dateDiffConvert;

        }

        static function CheckUserCount()
        {
            $userCounter = new NewUsersCounter();

            $result = $userCounter->getAdminUsers();

            while ($user = $result->Fetch()) {
                $arAdminsId[] = $user['ID'];
                $arAdminsMail[] =  $user['EMAIL'];
            }
    
            $usersCountNow = CUser::GetCount();
            $dateNow = time();
            $usersCountBefore = Option::get("main", "usersCount");
            $dateBefore = Option::get("main", "date");
            $dateDiff = $dateNow - $dateBefore;
            $usersCountDiff = $usersCountNow - $usersCountBefore;
            $dateDiffConvert = $userCounter->dateDiffConvert($dateDiff);
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
    
            return "NewUsersCounter::CheckUserCount();";
        }
    }
    


?>