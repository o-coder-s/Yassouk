<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 mb-5 col-lg-11 mt-5 mx-auto">
    <form action="<?php echo URLROOT;?>/gestion/editPermis/<?php echo $data['id']; ?>" class="border shadow p-4" method="post">
        <div class="mb-4">
            <h2>Ajouter un nouveau permis</h2>
        </div>
        <div class="my-2 border p-3 shadow-sm">
            <h5>Volume horraire</h5>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="code">Code </label>
                    <input type="text" class="form-control <?php echo empty($data['code_err'])? '':'is-invalid' ?>" id="code" name="code" value="<?php echo $data['code'] ?>"  placeholder="code">
                    <small class="<?php echo empty($data['code_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['code_err'])? 'required': $data['code_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="creneau">Créneaux </label>
                    <input type="text" class="form-control <?php echo empty($data['creneau_err'])? '':'is-invalid' ?>" id="creneau" name="creneau" value="<?php echo $data['creneau'] ?>" placeholder="créneaux">
                    <small class="<?php echo empty($data['creneau_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['creneau_err'])? 'required': $data['creneau_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="conduite">Conduire</label>
                    <input type="text" class="form-control <?php echo empty($data['conduite_err'])? '':'is-invalid' ?>" id="conduite" name="conduite" value="<?php echo $data['conduite'] ?>" placeholder="conduite">
                    <small class="<?php echo empty($data['conduite_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['conduite_err'])? 'required': $data['conduite_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="add">Ajouté en case d'échoue</label>
                    <input type="text" class="form-control <?php echo empty($data['add_h_err'])? '':'is-invalid' ?>" name="add_h" id="add" value="<?php echo $data['add_h'] ?>" placeholder="Volume a ajouter">
                    <small class="<?php echo empty($data['add_h_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['add_h_err'])? 'required': $data['add_h_err']; ?></small>
                </div>
            </div>
        </div>
        <div class="my-2 border p-3 shadow-sm">
            <h5>Prix & Catégorie</h5>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="categorie">Catégorie</label>
                    <input type="text" class="form-control <?php echo empty($data['categorie_err'])? '':'is-invalid' ?>" id="categorie" name="categorie" value="<?php echo $data['categorie'] ?>" placeholder="Catégorie">
                    <small class="<?php echo empty($data['categorie_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['categorie_err'])? 'required': $data['categorie_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="prix">Prix</label>
                    <input type="text" class="form-control <?php echo empty($data['prix_err'])? '':'is-invalid' ?>" id="prix" name="prix" value="<?php echo $data['prix'] ?>" placeholder="Prix de permis">
                    <small class="<?php echo empty($data['prix_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['prix_err'])? 'required': $data['prix_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="prix_rdv">Prix de rendez-vous</label>
                    <input type="text" class="form-control <?php echo empty($data['prix_rdv_err'])? '':'is-invalid' ?>" id="prix_rdv" name="prix_rdv" value="<?php echo $data['prix_rdv'] ?>" placeholder="Prix de rendez-vous">
                    <small class="<?php echo empty($data['prix_rdv_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['prix_rdv_err'])? 'required': $data['prix_rdv_err']; ?></small>
                </div>
                <div class="form-group col-md-3">
                    <label for="add_p">Ajouté en case d'echoue</label>
                    <input type="text" class="form-control <?php echo empty($data['add_p_err'])? '':'is-invalid' ?>" id="add_p" name="add_p" value="<?php echo $data['add_p'] ?>" placeholder="Purcentage a ajouter">
                    <small class="<?php echo empty($data['add_p_err'])? '' : 'text-danger' ;?>"><?php echo empty($data['add_p_err'])? 'required': $data['add_p_err']; ?></small>
                </div>
            </div>
        </div>
        <div class="my-2 border p-3 shadow-sm">

        <div class="form-group">
            <label for="summernote">Dossier nécessaire</label>
            <textarea class="form-control " class="my-5" id="summernote" name="dossier"></textarea>
        </div>
        </div>
        <input type="submit" value="MODIFIER" class="btn btn-success">
        <a href="<?php echo URLROOT?>/gestion/parametres" class="btn btn-secondary">ANNULER</a>
    </form>


</div>

<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 300,
        lang: 'fr-FR' // default: 'en-US'
    });

    //set the code 
    var markupStr = '<?php echo $data['dossier'] ?>';
    $('#summernote').summernote('code', markupStr);

    markupStr = $('#summernote').summernote('code');
    console.log(markupStr);
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>