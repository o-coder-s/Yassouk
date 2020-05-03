<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mx-2" style="margin-top: 22vh;">
    <div class="col-12 col-md-6 col-lg-6 col-sm-9  mx-auto border-custom-all-blue">
        <div class="row">
            <div class="col">
                <h3 class=" text-center p-4 "><span class="border-custom">MOT DE PASS OUBLIER</span></h3>
            </div>
        </div>
        <form action="<?php echo URLROOT?>/users/fpassword" method="post">
        <div class="row text-center pb-3">
            <div class="col col-sm-10 mx-auto">
                <label for="email">Votre email</label>
                <input id="email" class="form-control" type="email" name="email" required value="<?php echo $data['email']; ?>">
                <small class="form-text <?php  echo (!empty($data['email_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['email_err'])) ? $data['email_err'] : 'Required'?></small>
            </div>
        </div>
        <div class="row text-center pb-3">
            <div class="col">
                <button class="btn btn-danger text-center btn-sm " style="background-color: #FF880D">SUIVANT</button>
                <a href="<?php echo URLROOT ?>" class="btn btn-secondary text-center btn-sm text-light " style="text-decoration: none">ANULLER</a>
            </div>
        </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>