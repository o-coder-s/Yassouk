<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container-fluid mt-5 mb-5 ">
    <div id="r-container" class="row">

      <div id="f-container" class="col-md-12 col-lg-11 bg-white border-custom-all-blue">
        <div class="row">
          <div class="col col-sm-6">
            <h3 class=" text-center p-3"><a class="text-muted" href="<?php echo URLROOT ?>/users/signup" style="text-decoration: none;">S'INSCRIRE</a>
            </h3>
          </div>
          <div class="col col-sm-6">
            <h3 class=" text-center p-3 "><span class="border-custom">SE CONNECTER</span></h3>
          </div>
        </div>
        <form action="<?php echo URLROOT ?>/users/signin" method="post">

          <div class="row">

            <div class="form-group col-md-6">
              <label for="email">Email</label>
              <input id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is invalid' : '' ;?>" type="email" name="email" placeholder="Email" required value="<?php echo $data['email']; ?>">
              <?php echo (!empty($data['email_err'])) ? '<small class ="text-danger">'.$data['email_err'].'</small>' : '<small class ="text-muted">required</small>' ;?>
            </div>

            <div class="form-group col-md-6">
              <label for="password">Mot de pass</label>
              <input id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is invalid' : '' ;?>" required type="password" name="password" placeholder="Mot de pass" value="<?php echo $data['password']; ?>">
              <?php echo (!empty($data['password_err'])) ? '<small class ="text-danger">'.$data['password_err'].'</small>' : '<small class="text-muted">required</small>' ;?>
            </div>
            <div class="form-group">
              <a class="ml-3" style="color:#FF880D" href="<?php echo URLROOT ?>/users/fpassword">Mot de passe oublier </a>
            </div>

          </div>
          <button class=" btn btn-danger text-white" style="background-color:#FF880D;">CONNECTER</button>
          <a href="<?php echo URLROOT; ?>" class="btn btn-secondary text-white">ANULLER</a>
        </form>
      </div>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>