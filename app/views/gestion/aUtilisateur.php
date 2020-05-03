<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mx-auto mt-5 mb-5 ">
    <div id="r-container" class="row">
        <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
            <form method="post" action="<?php echo URLROOT .'/gestion/aUtilisateur/'. $data['role'];?>">
                <div class="row">
                    <div class="form-group col-md-4">
                    <label for="nom">Nom</label>
                            <input id="nom" class="form-control <?php  echo (!empty($data['ufamilyname_err'])) ? 'is-invalid' : ''?>" type="text" name="ufamilyname" required value="<?php echo $data['ufamilyname']; ?>"> 
                            <small class="form-text <?php  echo (!empty($data['ufamilyname_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['ufamilyname_err'])) ? $data['ufamilyname_err'] : 'Required'?></small>
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
                    <div class="form-group oo col-md-3">
                    <label for="dn">Date de naissace</label>
                            <input id="dn" class="form-control <?php  echo (!empty($data['birth_err'])) ? 'is-invalid' : ''?>" type="date" name="birth" required value="<?php echo $data['birth']; ?>">
                            <small class="form-text <?php  echo (!empty($data['birth_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['birth_err'])) ? $data['birth_err'] : 'Required'?></small>
                    </div>
                    <div class="form-group oo col-md-3">
                    <label for="sexe">Sexe</label>
                            <select id="sexe" class="custom-select" name="sexe">
                                <option value="male">Male</option>
                                <option value="female" <?php if($data['sexe']=='Female') echo 'selected'?>>Female</option>
                            </select>
                            <small class="text-muted form-text ">Required</small>
                    </div>
                    <div class="form-group oo col-md-3">
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
                    <div id="permis" class="form-group col-md-3">
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
                <div class="row">
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
                    <div class="form-group col-md-3">
                        <label for="password">Mot de pass</label>
                        <input id="password" class="form-control <?php  echo (!empty($data['password_err'])) ? 'is-invalid' : ''?>" type="password" name="password" value="<?php echo $data['password']; ?>"> 
                        <small class="form-text <?php  echo (!empty($data['password_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['password_err'])) ? $data['password_err'] : ''?></small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="repassword">Confirmer le mot de pass</label>
                        <input id="repassword" class="form-control <?php  echo (!empty($data['repassword_err'])) ? 'is-invalid' : ''?>" type="password" name="repassword" value="<?php echo $data['repassword']; ?>"> 
                        <small class="form-text <?php  echo (!empty($data['repassword_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['repassword_err'])) ? $data['repassword_err'] : ''?></small>
                    </div>
                </div>
                <button id="edit" class=" btn btn-info text-white" style="background-color:#14C446;">AJOUTER</button>
                <a href="<?php echo URLROOT; ?>" class="btn btn-secondary text-white">ANULLER</a>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () { 
    if(<?php echo $data['role']?>==1)
    {
        $('#permis').hide();
        $('.oo').removeClass('col-md-3');
        $('.oo').addClass('col-md-4');
    }
 });

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>