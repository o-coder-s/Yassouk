<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

    <div class="col-12 mb-5 col-lg-11 mt-5 mx-auto">
        <form action="<?php echo URLROOT.'/ressources/cRessource/'.$data['id_ress'];?>" class="border p-4" method="post">
        <div class="mb-4"><h2><?php echo $data['title']; ?></h2></div>
        <div class="form-group">
            <label for="cont">Contonaire</label>
            <textarea class="form-control" class="my-5" id="summernote" name="content"></textarea>
            <small class="form-text <?php  echo (!empty($data['content_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['content_err'])) ? $data['content_err'] : 'Required'?></small>
        </div>
            <input type="submit" value="MODIFIER" class="btn btn-primary">
            <a href="<?php echo URLROOT?>/ressources/index" class="btn btn-secondary" >ANNULER</a>
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
