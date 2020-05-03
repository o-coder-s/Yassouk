<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="mt-5">
    <div class="col-12 col-lg-11 mx-auto mb-3">
        <div class="row">
            <div class="input-group <?php if($_SESSION['role']==1){echo'col-8 col-lg-10';}else{echo'col-12';}?>"> 
                <div class="input-group-prepend">
                    <button class="btn btn-secondary" type="button" id="button-addon1">Chercher</button>
                </div>
                <input id="search" type="text" class="form-control" placeholder="" aria-label="Example text with button addon"
                    aria-describedby="button-addon1">
            </div>
            <?php if($_SESSION['role']==1){
                echo'
                <div class="col-4 col-lg-2">
                <a href="'.URLROOT.'/ressources/aRessource" class="btn  w-100 btn-primary" type="button"><span
                        style="font-weight: bold">+</span> Ressources</a>
                </div>
                ';
            }?>
        </div>
    </div>
</div>

<div class="col-12 mb-5" id="data">
    <!--Ressouces-->
    

</div>

<!-- Modal delete -->
<div id="delete" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="model-body">
                <p class="ml-3">Voulez-vous vraiment supprimer ?</p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-secondary">ANNULER</button>
                <button id="confirme" class="btn btn-danger">CONFIRMER</button>
            </div>
        </div>
    </div>
</div>

<script>

    $('#search').on('keyup', function() {
    let pattern = $('#search').val().trim();
        $.ajax({
        type: "POST",
        url: "<?php echo URLROOT; ?>/ressources/livesearch/",
        data: {pattern : pattern},
        success: function (data) {
            $('#data').html("");
            $('#data').html(data);
        }
    });
    
    });

    function sup(id){
        var str = "<?php echo URLROOT; ?>/ressources/rRessource/"+id;
        console.log(str);
        
        $("#confirme").click(function () {
            console.log("deleted");
            $.ajax({
            type:'POST',
            url: "<?php echo URLROOT; ?>/ressources/rRessource/"+id,
            success: function (data) {
                //flush message
                $.ajax({
                type:'POST',
                url: "<?php echo URLROOT; ?>/ressources/index",
                success: function (data) {  
                    var answer = data.search('>empty<');
                    if(answer==-1){
                    $("#search").prop("disabled", false)
                    $('#data').html(data);
                    }else{
                    $("#search").prop("disabled", true);
                    $('#data').html('');
                    }
            }
        });
            }
            });
            $("#delete").modal('hide');
            console.log("deletion success");
        });
    }

    function getRessource(){
        $.ajax({
            type:'POST',
            url: "<?php echo URLROOT; ?>/ressources/index/",
            success: function (data) {  
                var answer = data.search('>empty<');
                if(answer==-1){
                  $("#search").prop("disabled", false)
                  $('#data').html(data);
                }else{
                  $("#search").prop("disabled", true);
                  $('#data').html('');
                }
            }
        });
    }
    $(document).ready(function(){

        getRessource();

        function alignModal(){
            var modalDialog = $(this).find(".modal-dialog");
            
            // Applying the top margin on modal dialog to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);
        
        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(alignModal);
        }); 

    });

    // setInterval(() => {
    //     $.ajax({
    //         type:'POST',
    //         url: "<?php echo URLROOT; ?>/ressources/index",
    //         success: function (data) {  
    //             var answer = data.search('>empty<');
    //             if(answer==-1){
    //               $("#search").prop("disabled", false)
    //               $('#data').html(data);
    //             }else{
    //               $("#search").prop("disabled", true);
    //               $('#data').html('');
    //             }
    //         }
    //     });
    // }, 3000);
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
