<?php require __DIR__.'/../header.php' ?>

<h1>Annonce Favoris</h1>

<?php

if (!empty($_COOKIE['favoris']))
{
    $cookies = json_decode($_COOKIE['favoris']);
    foreach ($cookies as $cook)
        echo Annonce::render(Annonce::searchAnnonce(['id' => $cook])[0], false);
?>
<form action="/annonce/favoris/clear" method="post">
    <button class="btn btn-danger">Supprimer tous les favoris</button>
</form>
<?php } else { ?>
    <p class="badge text-danger" >Aucun cookies</p>
<?php } ?>
<?php require __DIR__.'/../footer.php' ?>