<?php require __DIR__.'/../header.php' ?>

<div class="container">
<form method="post" action="/annonce/success" enctype="multipart/form-data">
  <div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Titre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="title" placeholder="Une titre">
    </div>
  </div>
  <div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
      <textarea type="password" class="form-control" name="description" placeholder="Une description"></textarea>
    </div>
  </div>
  <div class="form-group row">
  <label for="file" class="col-sm-2 col-form-label">Ajouter une image</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" name="file" >
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button class="btn btn-info">Valider</button>
    </div>
  </div>
</form>

</div>
<?php require __DIR__.'/../footer.php' ?>