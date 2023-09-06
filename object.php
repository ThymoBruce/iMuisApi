<?php

namespace iMuis\Object;

use iMuis\connection\connection;
use iMuis\config\config;

class objectClass{

    public function createObject($data)
    {
        $objectArray = [];
        foreach($data as $key => $field){
            $databaseKey = $this->switchOnDataKey($key);

            if(strpos($databaseKey, "_")){
                $financeNumber = explode("_", $databaseKey)[0];
                $referenceId = explode("_", $databaseKey)[1];
                $objectArray["financeNumber"] = (string) $field;
                $objectArray["referenceId"] = (string) $field;
                continue;
            }

            if(!empty($databaseKey))
                $objectArray[$databaseKey] = (string) $field;
        }

        $object = (object) $objectArray;

        return $object;
    }

    public function switchOnDataKey($key)
    {
        switch ($key){
            case "FACT":
                return "financeNumber_referenceId";
            case "TEGREK":
                return "debtorNumber";
            case "BTW":
                 return "vatCode";
            case "OPM":
                return "remark";
            case "BEDBOEK":
                return "price";
            case "DAT":
                return "createDate";
        }

        return null;
    }
}