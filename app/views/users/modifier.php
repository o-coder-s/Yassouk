<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="container-fluid mt-5 mb-5 ">
    <div id="r-container" class="row col-12 mx-auto">
        <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
            <form method="post" action="<?php echo URLROOT ?>/users/modifier">
                <div class="row">
                    <div id="dp" class="col-3 mb-3 form-group">
                        <label for="upload_image" class="border-custom-all-blue" id="uploaded_image" style="cursor:pointer;">
                        <img class="hide" src="<?php echo $_SESSION['dp']; ?>" style="width:150px;" alt="Profile picture">
                        </label>
                        <input type="file" class="d-none" name="photo" id="upload_image" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                    <label for="nom">Nom</label>
                            <input id="nom" class="form-control <?php  echo (!empty($data['familyname_err'])) ? 'is-invalid' : ''?>" type="text" name="familyname" required value="<?php echo $data['familyname']; ?>"> 
                            <small class="form-text <?php  echo (!empty($data['familyname_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['familyname_err'])) ? $data['familyname_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-4 ">
                    <label for="prenom">Prénom</label>
                            <input id="prenom" class="form-control <?php  echo (!empty($data['name_err'])) ? 'is-invalid' : ''?>" type="text" name="name" required value="<?php echo $data['name']; ?>">
                            <small class="form-text <?php  echo (!empty($data['name_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['name_err'])) ? $data['name_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-4 ">
                    <label for="adresse">Adresse</label>
                            <input id="adresse" class="form-control <?php  echo (!empty($data['address_err'])) ? 'is-invalid' : ''?>" type="text" name="address" required value="<?php echo $data['address']; ?>">
                            <small class="form-text <?php  echo (!empty($data['address_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['address_err'])) ? $data['address_err'] : 'Required'?></small>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-3">
                    <label for="dn">Date de naissace</label>
                            <input id="dn" class="form-control <?php  echo (!empty($data['birth_err'])) ? 'is-invalid' : ''?>" type="date" name="birth" required value="<?php echo $data['birth']; ?>">
                            <small class="form-text <?php  echo (!empty($data['birth_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['birth_err'])) ? $data['birth_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="sexe">Sexe</label>
                            <select id="sexe" class="custom-select" name="sexe">
                                <option value="male">Male</option>
                                <option value="female" <?php if($data['sexe']=='female') echo 'selected'?>>Female</option>
                            </select>
                            <small class="text-muted form-text ">Required</small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="grp_sang">Groupe de sange</label>
                        <select id="grp_sang" class="custom-select" name="blood">
                            <option value="A+">A+</option>
                            <option value="A-"<?php if($data['blood']=='A-') echo 'selected'?>>A-</option>
                            <option value="B+"<?php if($data['blood']=='B+') echo 'selected'?>>B+</option>
                            <option value="B-"<?php if($data['blood']=='B-') echo 'selected'?>>B-</option>
                            <option value="AB+"<?php if($data['blood']=='AB+') echo 'selected'?>>AB+</option>
                            <option value="AB-"<?php if($data['blood']=='AB-') echo 'selected'?>>AB-</option>
                            <option value="O+"<?php if($data['blood']=='O+') echo 'selected'?>>O+</option>
                            <option value="O-"<?php if($data['blood']=='O-') echo 'selected'?>>O-</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="tel">N°Telephone</label>
                            <input id="tel" class="form-control <?php  echo (!empty($data['phone_err'])) ? 'is-invalid' : ''?>" type="tel" name="phone" required value="<?php echo $data['phone']; ?>">
                            <small class="form-text <?php  echo (!empty($data['phone_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['phone_err'])) ? $data['phone_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="email" name="email" required value="<?php echo $data['email']; ?>">
                        <small class="form-text <?php  echo (!empty($data['email_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['email_err'])) ? $data['email_err'] : 'Required'?></small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="cpassword">Mot de pass actuel</label>
                        <input id="cpassword" class="form-control <?php  echo (!empty($data['cpassword_err'])) ? 'is-invalid' : ''?>" type="password" name="cpassword" value="<?php echo $data['cpassword']; ?>"> 
                        <small class="form-text <?php  echo (!empty($data['cpassword_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['cpassword_err'])) ? $data['cpassword_err'] : ''?></small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="npassword">Nouveau</label>
                        <input id="npassword" class="form-control <?php  echo (!empty($data['npassword_err'])) ? 'is-invalid' : ''?>" type="password" name="npassword" value="<?php echo $data['npassword']; ?>"> 
                        <small class="form-text <?php  echo (!empty($data['npassword_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['npassword_err'])) ? $data['npassword_err'] : ''?></small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rn_password">Confirmer</label>
                        <input id="rn_password" class="form-control <?php  echo (!empty($data['rn_password_err'])) ? 'is-invalid' : ''?>" type="password" name="rn_password" value="<?php echo $data['rn_password']; ?>"> 
                        <small class="form-text <?php  echo (!empty($data['rn_password_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['rn_password_err'])) ? $data['rn_password_err'] : ''?></small>
                    </div>
                </div>
                <button id="edit" class=" btn btn-info text-white" style="background-color:#14C446;">MODIFIER</button>
                <a href="<?php echo URLROOT; ?>" class="btn btn-secondary text-white">ANULLER</a>
            </form>
        </div>
    </div>
</div>





<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Couper la photo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row mx-auto">
                    <div id="image_demo" style="margin-top:30px margin-bottom: -100px;">

                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-success ml-auto crop_image">MODIFIER</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ANULLER</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square' //circle
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#upload_image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                //ajax
                $.ajax({
                    url: "<?php echo URLROOT;?>/users/upload",
                    type: "POST",
                    data: {
                        "image": response
                    },
                    success: function (data) {
                        $('#uploadimageModal').modal('hide');
                        $('#hide').remove();
                        $('#uploaded_image').html(data); //show the data back from php_upload      
                    }
                });
            })
        });

    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>