<?php

$erreur = null;
if (array_key_exists('PATH_INFO', $_SERVER)){
    switch ($_SERVER['PATH_INFO'])
    {
        case '/':
            require (__DIR__.'../../src/Controller/HomeController.php');
            break;
        case '/annonces':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            home();
            break;
        case '/annonce/success':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            $erreur = addAnnonce();
            home();
            break;
        case '/annonce/favoris/add':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            $erreur = addFavoris();
            if ($erreur)
                require (__DIR__.'../../templates/annonce/index.php');
            else
                header('Location: /annonce/favoris');
            break;
        case '/annonce/favoris':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            homeFavoris();
            break;
        case '/annonce/favoris/delete':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            deleteFavoris();
            header('Location: /annonce/favoris');
            break;
        case '/annonce/favoris/clear':
            require (__DIR__.'../../src/Controller/AnnonceController.php');
            clearCookies();
            homeFavoris();
            break;
        default:
            require (__DIR__.'../../src/Controller/NotfoundController.php');
            break;
    }
} else {
    require (__DIR__.'../../src/Controller/HomeController.php');
}