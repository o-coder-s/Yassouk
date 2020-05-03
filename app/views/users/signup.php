<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container-fluid mt-5 mb-5 ">
        <div id="r-container" class="row">

            <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class=" text-center p-3"><span class="border-custom">S'INSCRIRE</span></h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class=" text-center p-3 "><a class="text-muted" href="<?php echo URLROOT ?>/users/signin" style="text-decoration: none;">SE CONECTER</a></h3>
                    </div>
                </div>
                <form action="<?php echo URLROOT ?>/users/signup" method="post">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="nom">Nom</label>
                            <input id="nom" class="form-control <?php  echo (!empty($data['familyname_err'])) ? 'is-invalid' : ''?>" type="text" name="familyname" required value="<?php echo $data['ufamilyname']; ?>"> 
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
                            <label for="role">Type d'utilisateur</label>
                            <select id="role" class="custom-select <?php  echo (!empty($data['role_err'])) ? 'is-invalid' : ''?>" name="role"">
                                <option value="2">Candidat</option>
                                <option value="3"<?php if($data['role']=='Client') echo 'selected'?>>Client</option>
                            </select>
                            <small class="form-text <?php  echo (!empty($data['role_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['role_err'])) ? $data['role_err'] : 'Required'?></small>
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
                            <label for="sexe">Sexe</label>
                            <select id="sexe" class="custom-select" name="sexe">
                                <option value="male">Male</option>
                                <option value="female" <?php if($data['sexe']=='Female') echo 'selected'?>>Female</option>
                            </select>
                            <small class="text-muted form-text ">Required</small>
                        </div>
                            
                        <div class="form-group col-md-4">
                            <label for="tel">N°Telephone</label>
                            <input id="tel" class="form-control <?php  echo (!empty($data['phone_err'])) ? 'is-invalid' : ''?>" type="tel" name="phone" required value="<?php echo $data['phone']; ?>">
                            <small class="form-text <?php  echo (!empty($data['phone_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['phone_err'])) ? $data['phone_err'] : 'Required'?></small>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email" required value="<?php echo $data['email']; ?>">
                            <small class="form-text <?php  echo (!empty($data['email_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['email_err'])) ? $data['email_err'] : 'Required'?></small>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="password">Mot de pass</label>
                            <input id="password" class="form-control <?php  echo (!empty($data['password_err'])) ? 'is-invalid' : ''?>" type="password" name="password" required value="<?php echo $data['password']; ?>"> 
                            <small class="form-text <?php  echo (!empty($data['password_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['password_err'])) ? $data['password_err'] : 'Required'?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="repassword">Confirmer le mot de pass</label>
                            <input id="repassword" class="form-control <?php  echo (!empty($data['repassword_err'])) ? 'is-invalid' : ''?>" type="password" name="repassword" required value="<?php echo $data['repassword']; ?>">
                            <small class="form-text <?php  echo (!empty($data['repassword_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['repassword'])) ? $data['repassword_err'] : 'Required'?></small>
                        </div>
                    </div>
                    <input type="submit" value="SUIVANT" class=" btn btn-danger text-white" style="background-color:#FF880D;">
                    <a href="<?php echo URLROOT; ?>" class="btn btn-secondary text-white">ANULLER</a>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/header.php'; ?>