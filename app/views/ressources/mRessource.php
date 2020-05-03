<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 mb-5 col-lg-11 mt-5 mx-auto">
    <form action="<?php echo URLROOT.'/ressources/mRessource/'.$data['id_ress'];?>" class="border shadow p-4" method="post">
        <div class="mb-4">
            <h2>Cree une ressource</h2>
        </div>
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control <?php  echo (!empty($data['title_err'])) ? 'is-invalid' : ''?>"
                name="title" id="" value="<?php echo $data['title'];?>" aria-describedby="helpId" required>
            <small
                class="form-text <?php  echo (!empty($data['title_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['title_err'])) ? $data['title_err'] : 'Required'?></small>
        </div>
        <div class="form-group">
            <label for="desc">Description</label>
            <textarea
                class="form-control <?php  echo (!empty($data['description_err'])) ? 'is-invalid' : ''?>"
                name="description" id="" rows="5" required><?php echo $data['description'];?></textarea>
            <small
                class="form-text <?php  echo (!empty($data['description_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['description_err'])) ? $data['description_err'] : 'Required'?></small>

        </div>
        <div class="form-group">
            <label for="cont">Contonaire</label>
            <textarea class="form-control" class="my-5" id="summernote" name="content"></textarea>
            <small class="form-text <?php  echo (!empty($data['content_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['content_err'])) ? $data['content_err'] : 'Required'?></small>
        </div>
        <input type="submit" value="MODIFIER" class="btn btn-success">
        <a href="<?php echo URLROOT?>/ressources/index" class="btn btn-secondary">ANNULER</a>
    </form>

</div>

<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 300,
        lang: 'fr-FR' // default: 'en-US'
    });
    //set the code 
     var markupStr = `<?php echo $data['content'] ?>`;
     $('#summernote').summernote('code', markupStr);
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>