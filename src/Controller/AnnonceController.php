<?php require __DIR__.'/../Entity/Annonce.php';

function home() : void
{
    require __DIR__.'/../../templates/annonce/index.php';
}

function homeFavoris() : void
{
    require __DIR__.'/../../templates/favoris/index.php';
}

function clearCookies() : void
{
    if (!empty($_COOKIE['favoris'])){
        unset($_COOKIE['favoris']);
        setcookie('favoris', null, -1, '/'); 
    }
}

function addAnnonce() : string
{
    if (!empty($_POST['title']) && !empty($_POST['description']))
    {
        if (empty($_FILES['file']['name']))
            Annonce::addAnnonce([$_POST['title'], $_POST['description'], null]);
        else{
            $dst =  __DIR__.'/../../src/avatar/'.$_FILES['file']['name'];
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $dst))
                return App::setNotif('Erreur pendant l\'upload du fichier');
            Annonce::addAnnonce([$_POST['title'], $_POST['description'], $_FILES['file']['name']]);
        }
        return App::setNotif('Annonce créée avec succès', 1);
    } 
    return App::setNotif('Merci de remplir tous les champs'); 
}

function addFavoris() : ?string
{
    if (!empty($_POST['id']) && is_numeric($_POST['id']))
    {
        $id = (int)$_POST['id'];
        if (empty($_COOKIE['favoris'])){
            $new = [$id];
            setcookie('favoris', json_encode($new), -1, '/');
        }
        else {
            $cook = json_decode($_COOKIE['favoris'], true);
            if (favorisExist($id, $cook))
                return App::setNotif('Cette article est déjà dans vos favoris');
            $cook[] = $id;
            setcookie('favoris', json_encode($cook), -1, '/');
        }
        return null;
    }
    return App::setNotif('Erreur article');
}

function favorisExist(int $id, array $cookies) : bool
{
    foreach ($cookies as $key => $cook){
        if ((int)$cook == $id)
            return true;
    }
    return false;
}

function deleteFavoris() : void
{
    if (!empty($_COOKIE['favoris']) && !empty($_POST['id']) && is_numeric($_POST['id']))
    {
        $cookies = json_decode($_COOKIE['favoris'], true);
        if (count($cookies) == 1)
            clearCookies();
        else{
            foreach ($cookies as $key => $cook){
                if ((int)$cook == (int)$_POST['id'])
                    unset($cookies[$key]);
            }
            $cookies = json_encode($cookies);
            setcookie('favoris', $cookies, -1, '/');
        }
    }
}

function printAnnonce($annonce) : string
{
    return Annonce::render($annonce);
}