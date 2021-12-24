<?php

require_once (__DIR__.'/Database.php');

class App extends Database
{
    public static function setNotif(string $notif, bool $success = false) : string
    {
        return 
        $success ? 
        '<label class="list-group-item list-group-item-success">'.$notif.'</label>'
        :
        '<label class="list-group-item list-group-item-danger">'.$notif.'</label>';
    }

    protected static function getKeys(array $datas) : array
    {
        $res = [];

        foreach ($datas as $key => $value)
            $res[] = $key;
        return $res;
    }

    private static function getSELECTQuery(array $datas, string $table) : string
    {
        $sql = 'SELECT * FROM '.$table.' WHERE ';
        $lengthDatas = count($datas);

        if ($lengthDatas > 1)
        {
            $sql .= '(';
            for ($i = 0; $i < $lengthDatas; $i++)
            {
                $sql .= $datas[$i].'=:'.$datas[$i];
                if ($i !== $lengthDatas - 1)
                    $sql .= ' AND ';
            }
            $sql .= ')';
        } else {
            $sql .= $datas[0].'=:'.$datas[0];
        }
        return $sql;
    }

    public static function search(?array $props, string $table, int $fetchMode = 1) : ?array
    {
        if (is_null($props) || empty($table))
            return null;

        if (count($props) === 0)
            return parent::getInstance()->execute('SELECT * FROM '.$table, []);
        
        $props = parent::getInstance()->protectDatas($props);
        $sql = self::getSELECTQuery(self::getKeys($props), $table);

        $datas = parent::getInstance()->execute($sql, $props, $fetchMode);
        return $datas;
    }
}