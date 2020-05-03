<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mt-5 mx-auto">
    <form action="<?php echo URLROOT;?>/forum/modifier/<?php echo $data['id'];?>" class="border p-4" method="post">
    <div class="mb-4"><h2>Modifier la publication</h2></div>
    <div class="form-group">
        <label for="desc">Titre</label>
        <input type="text" class="form-control <?php  echo (!empty($data['title_err'])) ? 'is-invalid' : ''?>" name="title" value="<?php echo $data['title'];?>" required>
        <small class="form-text <?php  echo (!empty($data['title_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['title_err'])) ? $data['title_err'] : 'Required'?></small>
    </div>
    <div class="form-group">
      <label for="desc">Description</label>
      <textarea class="form-control" name="description" id="" rows="5"><?php echo $data['description']; ?></textarea>
      <small class="form-text <?php  echo (!empty($data['description_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['description_err'])) ? $data['description_err'] : 'Required'?></small>
    </div>
        <input type="submit" value="MODIFIER" class="btn btn-success">
        <a href="<?php echo URLROOT?>/forum/publications" class="btn btn-secondary" >ANNULER</a>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>