<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row mx-2" style="margin-top: 22vh;">
        <div class="col-12 col-md-6 col-lg-6 col-sm-9  mx-auto border-custom-all-blue">
            <div class="row">
                <div class="col">
                    <h3 class=" text-center p-3"><span class="border-custom">ACTIVATION</span></h3>
                </div>
            </div>
            <div class="row p-3">
                <div class="col">
                    <ol>
                        <li>1-Rendre votre <a href="<?php echo URLROOT.'/users/dossier/'.$data['id'];?>">dossier</a> a l'auto-école YASSOUK.</li>
                        <li>2-Récupérer le code d'activation de votre compte. </li>
                        <li>3-Entrer le code et appuyer sur le button ACTIVER.</li>
                    </ol>
                </div>
            </div>
            <form action="<?php echo URLROOT ?>/users/activation?>" method="post">
                <div class="row text-center pb-3">
                    <div class="col col-sm-10 mx-auto">
                        <input type="text" name="code" placeholder="Code d'activation" class=" col form-control" required>
                        <small class="form-text <?php  echo (!empty($data['code_err'])) ? 'text-danger' : 'text-muted'?>"><?php  echo (!empty($data['code_err'])) ? $data['code_err'] : 'Required'?></small>
                    </div>
                </div>
                <div class="row text-center pb-3">
                    <div class="col">
                        <button class="btn text-center btn-sm text-white border bg-orange">ACTIVER</button>
                        <a href="<?php echo URLROOT?>/users/logout" class="btn text-center btn-sm text-white border bg-secondary">DECONECTER</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
