<?php

require_once (__DIR__.'/App.php');

class Annonce extends App
{
    private static string $table = 'annonce';
    private static array $fields = [
        'title', 'message', 'avatar'
    ];

    public static function addAnnonce(array $datas) : bool
    {
        $sql = 'INSERT INTO '.self::$table.' ('.self::$fields[0].', '.self::$fields[1].', '.self::$fields[2].') 
            VALUES(:title, :msg, :avatar)';

        return parent::getInstance()->executeBool($sql, [
            'title' => $datas[0],
            'msg' => $datas[1],
            'avatar' => $datas[2]
        ]);
    }

    public static function searchAnnonce(?array $props, int $fetchMode = 1) : ?array
    {
        return parent::search($props, self::$table, $fetchMode);
    }

    /*public static function renderAnnonce($annonce) : string
    {
        if (gettype($annonce) !== 'object')
            $annonce = (object)$annonce;
        return <<<HTML
        <nav class="container" style="padding: 10px;">
            <form method="post" action="/annonce/favoris/add">
                <h1 class="sr-only list-group-item list-group-item-primary">Annonce {$annonce->id}</h1>
                <ul>
                    <li class="list-group-item list-group-item-success">Titre: {$annonce->title}</li>
                    <li class="list-group-item list-group-item-info">Description: {$annonce->message}</li>
                </ul>
                <input type="hidden" name="id" value="{$annonce->id}">
                <button class="btn btn-success">Ajouter aux favoris</button>
            </form>
        </nav>
        HTML;
    }*/

    public static function render($annonce, bool $fav = true) : string
    {
        if (gettype($annonce) !== 'object')
            $annonce = (object)$annonce;
        $res ='
        <nav class="container" style="padding: 10px;">
            <form method="post" action="'.($fav ? '/annonce/favoris/add"' : '/annonce/favoris/delete"'). '>
                <h1 class="sr-only list-group-item list-group-item-primary">Annonce '.$annonce->id.'</h1>';
        if ($annonce->avatar)
            $res .= '<img src="../avatar/'.$annonce->avatar.'" alt="avatar" class="img-thumbnail" style="width:40%; height: 200px;" />';
                $res .= '
                <ul>
                    <li class="list-group-item list-group-item-success">Titre: '.$annonce->title.'</li>
                    <li class="list-group-item list-group-item-info">Description: '.$annonce->message.'</li>
                </ul>
                <input type="hidden" name="id" value="'.$annonce->id.'">';
        if ($fav){
            $res .='
                <button class="btn btn-success">Ajouter aux favoris</button>
                </form>
            </nav>';
        } else {
            $res .='
                <button class="btn btn-danger">Supprimer des favoris</button>
                </form>
            </nav>';
        }
        return $res;
    }
}