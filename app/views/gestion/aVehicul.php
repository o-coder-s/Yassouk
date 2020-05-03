<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mx-auto">
<div class="container-fluid mt-5 mb-5 ">
    <div id="r-container" class="row col-12 mx-auto">
        <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
            <form method="post" action="<?php echo URLROOT ?>/gestion/aVehicul/">
                <div class="row">
                    <div class="form-group col-lg-4">
                    <label for="matricule">Matricule</label>
                            <input id="matricule" class="form-control" type="text" name="matricule" value="<?php echo $data['matricule'] ?>" required> 
                             <small class="form-text <?php  echo (!empty($data['matricule_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['matricule_err'])) ? $data['matricule_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-lg-4">
                    <label for="marque">Marque</label>
                            <input id="marque" class="form-control" name="marque" value="<?php echo $data['marque']  ?>" required>
                            <small class="form-text <?php  echo (!empty($data['marque_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['marque_err'])) ? $data['marque_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-lg-4">
                    <label for="modele">Modèle</label>
                            <input id="modele" class="form-control" name="modele" type="text" value="<?php echo $data['modele'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['modele_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['modele_err'])) ? $data['modele_err'] : 'Required'?></small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                    <label for="df_assu">Date de fin d'assurance</label>
                            <input id="df_assu" name="df_assu" class="form-control" type="date" value="<?php echo $data['df_assu'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['df_assu_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['df_assu_err'])) ? $data['df_assu_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="dfc_tec">Date de fin de control téchnique</label>
                            <input id="dtc_tec" name="dfc_tec" class="form-control" type="date" value="<?php echo $data['dfc_tec'] ?>" required>
                            <small class="form-text <?php  echo (!empty($data['dfc_tec_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['dfc_tec_err'])) ? $data['dfc_tec_err'] : 'Required'?></small>
                    </div>
                    <div id="permis" class="form-group col-md-4">
                        <label for="permis">Permis de conduire</label>
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
                <button class=" btn btn-info text-white" style="background-color:#14C446;">AJOUTER</button>
                <a href="<?php echo URLROOT; ?>/gestion/<?php echo $_SESSION['page'] ?>" class="btn btn-secondary text-white">ANULLER</a>
            </form>
        </div>
    </div>
</div>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>