<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mx-2" style="margin-top: 22vh;">
    <div class="col-12 col-md-6 col-lg-6 col-sm-9  mx-auto border-custom-all-blue">
        <div class="row">
            <div class="col">
                <h3 class=" text-center p-4 "><span class="border-custom">NOUVEAU MOT DE PASS</span></h3>
            </div>
        </div>
        <form action="<?php echo URLROOT?>/users/npassword" method="post">
        <div class="row text-center pb-3">
            <div class="col text-left  col-sm-10 mx-auto">
                <label for="password" class=" form-label">Nouveau mot de pass</label>
                <input id="password" class="form-control <?php  echo (!empty($data['password_err'])) ? 'is-invalid' : ''?>" type="password" name="password" required value="<?php echo $data['password']; ?>">
                <small class="form-text <?php  echo (!empty($data['password_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['password_error'])) ? $data['password_err'] : 'Required'?></small>
            </div>
                <div class="col text-left col-sm-10 mx-auto">
                <label for="password" class="form-label">Confirmer le mot de pass</label>
                <input id="npassword" class="form-control <?php  echo (!empty($data['npassword_err'])) ? 'is-invalid' : ''?>" type="password" name="npassword" required value="<?php echo $data['npassword']; ?>">
                <small class="form-text <?php  echo (!empty($data['npassword_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['npassword_err'])) ? $data['npassword_err'] : 'Required'?></small>
            </div>
        </div>
        <div class="row text-center pb-3">
            <div class="col">
                <button class="btn btn-danger text-center btn-sm " style="background-color: #FF880D">ENVOYER</button>
                <a href="<?php echo URLROOT ?>" class="btn btn-secondary text-center btn-sm text-light " style="text-decoration: none">ANULLER</a>
            </div>
        </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>