<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mx-2" style="margin-top: 22vh;">
    <div class="col-12 col-md-6 col-lg-6 col-sm-9  mx-auto border-custom-all-blue">
        <div class="row">
            <div class="col">
                <h3 class=" text-center p-4 "><span class="border-custom">REPONDE AUX QUESTIONS</span></h3>
            </div>
        </div>
        <form action="<?php echo URLROOT?>/users/question" method="post">
        <div class="row text-center pb-3">
            <div class="col text-left col-sm-10 mx-auto">
                <label for="family_name" class="form-label">Nom ?</label>
                <input id="family_name" name="family_name" type="text" placeholder="Nom" class="form-control" required>
            </div>
            <div class="col text-left col-sm-10 mx-auto">
                <label for="name" class="form-label">Prenom ?</label>
                <input id="name" name="name" type="text" placeholder="Prenom" class="form-control" required>
            </div>
            <div class="col text-left col-sm-10 mx-auto">
                <label for="phone" class="form-label">Téléphone ?</label>
                <input id="phone" name="phone" type="text" placeholder="Téléphone" class="form-control" required>
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