<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>
<style>
    td {
        height: 110px;
        min-width: 160px;
    }

    .table-responsive::-webkit-scrollbar {
        height: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #17a2b8;
    }

    #scroll-hide::-webkit-scrollbar {
        width: 0px;
    }

    .caze:hover {
        opacity: .8;
        cursor: pointer;
    }

    .empty {
        color: grey;
    }

    .empty:hover {
        opacity: .8;
        cursor: pointer;
        background-color: grey;
        color: white;
    }
</style>

<div class="col-12 col-lg-11 mx-auto">
    <div class="col-12 shadow bg-info text-white mt-5">
        <div class="row py-2">
            <div class="col">
                <span onClick="previous()" class="bg-info my-auto" onMouseOver="this.style.color='grey'"
                    onMouseOut="this.style.color='white'" style="cursor:pointer;">
                    < Précedent</span> </div> <div class="col text-center">
                        <span onClick="today()" class="bg-info text-center  text-center my-auto"
                            onMouseOver="this.style.color='grey'" onMouseOut="this.style.color='white'"
                            style="cursor:pointer;">
                            Cette semaine</span> <span id=year></span>
            </div>
            <div class="col text-right">
                <span class="bg-info my-auto" onMouseOver="this.style.color='grey'"
                    onMouseOut="this.style.color='white'" onClick="next()" style="cursor:pointer;">Suivant ></span>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-5">
        <table id="data" class="text-center w-100 bg-secondary shadow border text-light">

        </table>
    </div>
</div>


<!-- Modal view seance -->
<div id="viewSeance" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="cancel close">&times;</span>
                </button>
            </div>
            <div id='seance-body' class="model-body">
                <!-- <div class="row">
                    <div class="mt-2 ml-4">
                        <label class="ml-2"><b>Groupe:</b> B5</label><br>
                        <label class="ml-2"><b>Moniteur:</b> Sethoum Oussama</label><br>
                        <label class="ml-2"><b>Date:</b> 27/03/2018</label><br>
                        <label class="ml-2"><b>Temps:</b> de 8:00 à 9:00</label><br>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">FERMER</button>
                <button id="viewSeanceConfirme" class="btn btn-sm btn-danger">SUPPRIMER</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal view rdv -->
<div id="viewRdv" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rendez-vous</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="cancel">&times;</span>
                </button>
            </div>
            <div id="rdv-body" class="model-body">
                <div class="row">
                    <div class="mt-2 ml-4">
                        <label class="ml-2"><b>Client:</b> B5</label><br>
                        <label class="ml-2"><b>Moniteur:</b> Sethoum Oussama</label><br>
                        <label class="ml-2"><b>Véhicule:</b> Sethoum Oussama</label><br>
                        <label class="ml-2"><b>Date:</b> 27/03/2018</label><br>
                        <label class="ml-2"><b>Temps:</b> de 8:00 à 9:00</label><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">FERMER</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal add -->
<div id="add" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une seance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="cancel">&times;</span>
                </button>
            </div>
            <div class="model-body">
                <div class="my-2 mb-4">
                    <label class="pl-3" for="">Groupe</label>
                    <select class="form-control ml-3 col-11" name="gSelect" id="gCreateSelect">
                        <!-- Eliminate - group in the future -->
                        <?php foreach ($data['groups'] as $grp) {echo '<option value="'.$grp->id_grp.'">'.$grp->nom_grp.'</option>';}?>
                    </select>
                    <label class="pl-3" for="">Moniteur</label>
                    <select class="form-control ml-3 col-11" name="gSelect" id="mCreateSelect">
                        <?php foreach ($data['moniteurs'] as $mnt) {echo '<option value="'.$mnt['moniteur']['id_mnt'].'">'.$mnt['user']['nom'].'</option>';}?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">ANNULER</button>
                <button id="addConfirme" class="btn btn-sm btn-success">AJOUTER</button>
            </div>
        </div>
    </div>
</div>

<script>
    function add(d, t) {
        d = d + " " + t + ":00";
        $('#add').modal('show');
        $('#addConfirme').click(function () {
            
            $('#add').modal('hide');
            $('#addConfirme').unbind();

            m = $('#mCreateSelect').val();
            g = $('#gCreateSelect').val();

            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT;?>/gestion/addSeance/",
                data: {
                    d: d,
                    g: g,
                    m: m
                },
                success: function (response) {
                    currentWeek();
                    return false;
                }
            });

        });
    }
    $('.cancel').click(function () {
            $('.caze').unbind();
            $('#viewSeanceConfirme').unbind();
            $('#addConfirme').unbind();
    });
    //condition in javascript using php
    function vSeance(id){
        //get info and place them 

        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/getSeance",
            data: {id:id},
            success: function (response) {
                $('#seance-body').html(response);
            }
        });

        $('#viewSeance').modal('show');
        $('#viewSeanceConfirme').click(function(){
            //remove the seance
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT ?>/gestion/deleteSeance",
                data: {id:id},
                success: function (response) {
                    currentWeek();
                }
            });
            //notify the groupe and the moniteur

            $('#viewSeanceConfirme').unbind();
            $('#viewSeance').modal('hide');

        });
    }
        
    function vRdv(id){
        $('#viewRdv').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/getRdv",
            data: {id:id},
            success: function (response) {
                $('#rdv-body').html(response);
            }
        });
    }


    $(document).ready(function () {
        today();
        //center the modal
        function alignModal() {
            var modalDialog = $(this).find(".modal-dialog");

            // Applying the top margin on modal dialog to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);

        // Align modal when user resize the window
        $(window).on("resize", function () {
            $(".modal:visible").each(alignModal);
        });
    });

    function today() {
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/getPlanning",
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }

    function next() {
        id = $('th[id]').attr('id');
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/nextWeek/" + id,
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }

    function currentWeek() {
        id = $('th[id]').attr('id');
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/currentWeek/" + id,
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }

    function previous() {
        id = $('th[id]').attr('id');
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/previousWeek/" + id,
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>