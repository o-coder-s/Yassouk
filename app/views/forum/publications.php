<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>


<div class="col-12 col-lg-11 mx-auto mt-5 mb-5">
    <div class="row">
        <div class="input-group mb-3 col-8 col-lg-10">
            <div class="input-group-prepend">
                <button class="btn btn-secondary" type="button" id="button-addon1">Chercher</button>
            </div>
            <input id="search" type="text" class="form-control" placeholder=""
                aria-label="Example text with button addon" aria-describedby="button-addon1">
        </div>
        <div class="col-4 col-lg-2">
            <a href="<?php echo URLROOT; ?>/forum/ajouter/" class="btn  w-100 btn-primary" type="button"><span
                    style="font-weight: bold">+</span> Publication</a>
        </div>
    </div>

    <!--Posts-->
    <div id="posts">

    </div>

</div>

<!-- Modal delete -->
<div id="delete" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="model-body">
                <p class="ml-3">Voulez-vous vraiment supprimer ?</p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">ANNULER</button>
                <button id="confirme" class="btn btn-sm btn-danger">CONFIRMER</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        getPosts();
        alignModal();
    });

    $('.cancel').click(function() {
        $('#confirme').unbind();
        $('.cancel').unbind();
    });

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

    function addReply(id) {
        reply = $('#newReply').val();
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT;?>/forum/addReply",
            data: {
                reply: reply,
                id: id
            },
            success: function (data) {
                //flush message and error check
                getReplies(id);
            }
        });
        getReplies(id);
    }

    function addComment(id) {
        comment = $('#newComment').val();
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT;?>/forum/addComment",
            data: {
                comment: comment,
                id: id
            },
            success: function (data) {
                //flush message and error check
            }
        });
        getComments(id);
    }

    function getPosts() {

        $.ajax({
            url: "<?php echo URLROOT ?>/forum/getPosts",
            success: function (data) {
                var answer = data.search('>empty<');
                if (answer == -1) {
                    $("#search").prop("disabled", false)
                    $('#posts').html(data);
                } else {
                    $("#search").prop("disabled", true);
                    $('#posts').html('');
                }
            }
        });
    }

    function getComments(id) {
        $.ajax({
            url: "<?php echo URLROOT ?>/forum/getComments/" + id,
            success: function (data) {
                $('#comments' + id).html(data);
            }
        });
    }

    function getReplies(id) {
        $.ajax({
            url: "<?php echo URLROOT ?>/forum/getReplies/" + id,
            success: function (data) {
                $('#replies' + id).html(data);
            }
        });
    }

    function deletePost(id) {
        $('#delete').modal('show');
        $("#confirme").click(function () {
            $.ajax({
                url: "<?php echo URLROOT; ?>/forum/deletePost/" + id,
                success: function (response) {
                    // deleted or not your post :)
                    $('#delete').modal('hide');
                    getPosts();
                }
            });
        });
    }

    $('#search').on('keydown', function () {
        let pattern = $('#search').val().trim();
        if (pattern == "") {
            getPosts();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/forum/liveSearch/",
                data: {
                    pattern: pattern
                },
                success: function (data) {
                    $('#posts').html("");
                    $('#posts').html(data);
                }
            });
        }

    });

    function editPost(id) {
        window.location.href = "<?php echo URLROOT; ?>/forum/modifier/" + id;
    }

    function editComment(id) {
        //handle the buttons
        var buttons = $('#buttonsComment' + id).html();
        var oldText = $('#descComment' + id).text().trim();
        //adding textarea
        let text = '<textarea id="editComment' + id + '" rows="4" class="form-control">' + oldText + '</textarea>';
        $('#descComment' + id).html(text);
        //new buttons
        let btns = '<button id="updateComment' + id +
            '" class="btn mr-2 d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button><button id="cancelComment' +
            id + '" class="btn d-block d-sm-inline btn-sm btn-secondary mt-1">Anuller</button>';
        $('#buttonsComment' + id).html(btns);

        $('#updateComment' + id).click(function () {
            let edited = $('#editComment' + id).val().trim();
            $('#descComment' + id).html(edited);
            $('#buttonsComment' + id).html(buttons);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/forum/updateComment/",
                data: {
                    id: id,
                    edited: edited
                },
                success: function (response) {

                }
            });
        });
        $('#cancelComment' + id).click(function () {
            $('#descComment' + id).html(oldText);
            $('#buttonsComment' + id).html(buttons);
        });

    }

    function editReply(id) {

        var buttons = $('#buttonsReply' + id).html();
        var oldText = $('#descReply' + id).text().trim();
        //adding textarea
        let text = '<textarea id="editReply' + id + '" rows="4" class="form-control">' + oldText + '</textarea>';
        $('#descReply' + id).html(text);
        //new buttons
        let btns = '<button id="updateReply' + id +
            '" class="btn mr-2 d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button><button id="cancelReply' +
            id + '" class="btn d-block d-sm-inline btn-sm btn-secondary mt-1">Anuller</button>';
        $('#buttonsReply' + id).html(btns);

        $('#updateReply' + id).click(function () {
            let edited = $('#editReply' + id).val().trim();
            $('#descReply' + id).html(edited);
            $('#buttonsReply' + id).html(buttons);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/forum/updateReply/",
                data: {
                    id: id,
                    edited: edited
                },
                success: function (response) {

                }
            });
        });
        $('#cancelReply' + id).click(function () {
            $('#descReply' + id).html(oldText);
            $('#buttonsReply' + id).html(buttons);
        });

    }

    function deleteComment(idComment, idPost) {
        $('#delete').modal('show');
        $("#confirme").click(function () {
            console.log("waiting");
            $.ajax({
                url: "<?php echo URLROOT; ?>/forum/deleteComment/" + idComment,
                success: function (response) {
                    console.log("deleted");

                    // deleted or not your post :)
                    $('#delete').modal('hide');
                    getComments(idPost);
                }
            });

        })
    }

    function deleteReply(idReply, idComment) {
        $('#delete').modal('show');
        $("#confirme").click(function () {
            $.ajax({
                url: "<?php echo URLROOT; ?>/forum/deleteReply/" + idReply,
                success: function (response) {
                    $('#delete').modal('hide');
                    getReplies(idComment);
                }
            });
        })
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>