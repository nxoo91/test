<?php require (__DIR__.'/head.php') ?>

<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">TP Annonce</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/annonces">Annonces</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/annonce/favoris">Mes favoris <?php
          if (!empty($_COOKIE['favoris'])){
            echo '('.count((array)json_decode($_COOKIE['favoris']), true).')';
          }
        ?></a>
      </li>
    </ul>
  </div>
</nav>
</header>

<?php global $erreur; if ($erreur) echo $erreur;