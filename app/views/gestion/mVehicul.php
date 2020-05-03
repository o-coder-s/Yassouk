<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="container-fluid mt-5 mb-5 ">
    <div id="r-container" class="row col-12 mx-auto">
        <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
            <form method="post" action="<?php echo URLROOT;?>/gestion/mVehicul/<?php echo $data['mat']; ?>">
            <div class="row">
                    <div id="dp" class="col-3 mb-3 form-group">
                        <label for="upload_image" class="border-custom-all-blue" id="uploaded_image" style="cursor:pointer;">
                        <img class="hide" src="<?php echo $data['dp']; ?>" style="width:150px;" alt="Profile picture">
                        </label>
                        <input type="file" class="d-none" name="photo" id="upload_image" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                    <label for="matricule">Matricule</label>
                            <input id="matricule" class="form-control" type="text" name="matricule" value="<?php echo $data['matricule'] ?>" required> 
                             <small class="form-text <?php  echo (!empty($data['matricule_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['matricule_err'])) ? $data['matricule_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="marque">Marque</label>
                            <input id="marque" class="form-control" name="marque" value="<?php echo $data['marque']  ?>" required>
                            <small class="form-text <?php  echo (!empty($data['marque_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['marque_err'])) ? $data['marque_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-3">
                    <label for="modele">Modèle</label>
                            <input id="modele" class="form-control" name="modele" type="text" value="<?php echo $data['modele'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['modele_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['modele_err'])) ? $data['modele_err'] : 'Required'?></small>
                    </div>
                    <div id="permis_v" class="form-group col-md-3">
                        <label for="permis">Permis</label>
                        <select id="permis" class="custom-select" name="permis">
                        <?php foreach($data['listpermis'] as $lp)
                            {
                                if($data['permis']==$lp->categorie){
                                    echo '<option value="'. $lp->categorie .'" selected>'.$lp->categorie.'</option>';
                                }else{
                                    echo '<option value="'. $lp->categorie .'">'.$lp->categorie.'</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-5">
                    <label for="df_assu">Date de fin d'assurance</label>
                            <input id="df_assu" name="df_assu" class="form-control" type="date" value="<?php echo $data['df_assu'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['df_assu_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['df_assu_err'])) ? $data['df_assu_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-5">
                    <label for="dfc_tec">Date de fin de control</label>
                            <input id="dtc_tec" name="dfc_tec" class="form-control" type="date" value="<?php echo $data['dfc_tec'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['dfc_tec_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['dfc_tec_err'])) ? $data['dfc_tec_err'] : 'Required'?></small>
                    </div>
                    <div id="statut_v" class="form-group col-md-2">
                        <label for="statut">Statut</label>
                        <select id="statut" class="custom-select" name="statut">
                            <?php 
                                if($data['statut']==1){
                                    echo 
                                    '
                                    <option value="1" selected>actif</option>
                                    <option value="0">en panne</option>
                                    ';
                                }else{
                                    echo 
                                    '
                                    <option value="0" selected>en panne</option>
                                    <option value="1">actif</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <button class=" btn btn-info text-white" style="background-color:#14C446;">MODIFIER</button>
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
                    url: "<?php echo URLROOT;?>/gestion/upload/<?php echo $data['mat'] ?>",
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