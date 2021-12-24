<?php require __DIR__.'/../header.php' ?>

<h1>Annonce</h1>

<?php

$annonces = Annonce::searchAnnonce([]);
foreach ($annonces as $annonce)
    echo printAnnonce($annonce);

?>

<?php require __DIR__.'/../footer.php' ?>