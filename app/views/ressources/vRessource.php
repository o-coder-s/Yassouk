<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

    <div class="col-12 col-lg-11 mt-5 mb-5 mx-auto py-4 pl-3 pr-2 shadow-sm border">
        <?php print $data['content']; ?>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-4 text-left">Createur<br>
            <img src="<?php echo $data['publisher']->data ?>" class="shadow border rounded-circle" title="<?php echo $data['publisher']->nom.' '.$data['publisher']->prenom;?>" style="width:2.5em;">  
            </div>
            <div class="col-12 col-lg-8 text-left">
            <?php if(sizeof($data['contributors'])>0){
                echo `Contributers<br>`;
            } ?>
            <?php foreach ($data['contributors'] as $contributer){
                echo '<img src="'.$contributer->data.'" class="shadow border mr-2 rounded-circle" title="'.$contributer->nom .' '.$contributer->prenom.'" style="width:2.5em;">';
            } ?>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
