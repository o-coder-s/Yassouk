<!-- navbar -->
<div class="col-12 col-lg-11 mx-auto">
    <nav class="navbar shadow navbar-expand-lg navbar-light bg-gblue text-light mt-4">
        <a class="navbar-brand border-custom-left my-auto my-lg-0 "> <span class="ml-2"><?php
    switch ($_SESSION['role']) {
        case '0':
            echo 'Admin';
            break;
        
        case '1':
            echo 'Moniteur';
            break;
        
        case '2':
            echo 'Candidat';
            break;
        
        case '3':
            echo 'Client';
            break;
        
        default:
            break;
    }
    ?> </span></a>
        <img id="message" class=" ml-auto my-auto mx-3 d-lg-none  msg_icon" style="width:1.8em;cursor:pointer;"
            src="<?php echo URLROOT; ?>/svg/11.svg">
        <div style="height:2em;width:1.5px;" class="my-auto bg-light d-lg-none"></div>
        <img id="notification" class=" mx-3 my-auto  d-lg-none  " style="width:1.5em;cursor:pointer;"
            src="<?php echo URLROOT; ?>/svg/7.svg">
        <div style="height:2em;width:1.5px;" class="my-auto bg-light d-lg-none"></div>
        <div id="nav-toggler" style="cursor:pointer;" class="border-0 navbar-toggler text-white" data-target="#my-nav"
            data-toggle="collapse" aria-controls="#my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <li class="nav-item my-auto mr-2 d-inline " style="font-size:1rem;"><?php echo $data['familyname']; ?></li>
            <img src="<?php echo $_SESSION['dp'];?>" class="rounded-circle " style="width:2em;" alt="">
        </div>
        <div id="my-nav" class="collapse navbar-collapse">
            <div class="dropdown-divider d-lg-none"></div>
            <ul class="navbar-nav mx-auto">
                <li class=" nav-item">
                    <a class=" nav-link mx-2 text-light " href="<?php echo URLROOT ?>"><i class="fa fa-tachometer "
                            style="width:1.5em;<?php echo ($_SESSION['page'] == "dashbord")? "color:#FB4B09;" : ""; ?>"
                            aria-hidden="true"></i>Dashboard </a>
                </li>
                <li class=" nav-item">
                    <a class=" nav-link mx-2 text-light " href="<?php echo URLROOT ?>/ressources/"><i
                            class="fa fa-leanpub"
                            style="width:1.5em; <?php echo ($_SESSION['page'] == "ressources")? "color:#FB4B09;" : ""; ?>"
                            aria-hidden="true"></i>Ressources </a>
                </li>
                <li class="nav-item">
                    <a class=" nav-link mx-2  text-light" href="<?php echo URLROOT ?>/forum/publications"><i
                            class="fa fa-rss-square"
                            style="width:1.5em; <?php echo ($_SESSION['page'] == "forum")? "color:#FB4B09;" : ""; ?>"
                            aria-hidden="true"></i>Forum</a>
                </li>
                <?php
            $color="";
            if($_SESSION['page'] == "rendez-vous"){$color="#FB4B09";}
            if($_SESSION['role']==3 ){
                echo
                '
                <li class="nav-item">
                    <a class=" nav-link mx-2  text-light" href="'.URLROOT.'/client/rendez_vous"><i class="fa fa-calendar-o" style="width:1.5em;color:'.$color.'; aria-hidden="true"></i>Rendez-vous</a>
                </li>
                ';
            }
            if($_SESSION['page'] == "rendez-vous"){$color="#FB4B09";}
            if($_SESSION['role']==2 && $data['niveau'] >1){
                echo
                '
                <li class="nav-item">
                    <a class=" nav-link mx-2  text-light" href="'.URLROOT.'/candidat/rendez_vous"><i class="fa fa-calendar-o" style="width:1.5em;color:'.$color.'; aria-hidden="true"></i>Rendez-vous</a>
                </li>
                ';
            }
            if($_SESSION['page'] == "mplanning"){$color="#FB4B09";}
            if($_SESSION['role']==1){
                echo
                '
                <li class="nav-item">
                    <a class=" nav-link mx-2  text-light" href="'.URLROOT.'/moniteur/planning"><i class="fa fa-calendar-o" style="width:1.5em;color:'.$color.'; aria-hidden="true"></i>Planning</a>
                </li>
                ';
            }
            ?>
                <?php 
            $color = [
                'Candidat' =>'',
                'Client' =>'',
                'Moniteur' =>'',
                'Vehicul' =>'',
                'Planning' =>'',
                'Examens' =>'',
                'Gestion'=>'',
                'Parametres'=>''
            ];

            empty($color['Gestion'])? $color['Gestion'] = $color['Candidat'] = ($_SESSION['page'] == "candidats")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Client'] = ($_SESSION['page'] == "clients")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Moniteur'] = ($_SESSION['page'] == "moniteurs")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Vehicul'] = ($_SESSION['page'] == "vehiculs")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Planning'] = ($_SESSION['page'] == "planning")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Examens'] = ($_SESSION['page'] == "examens")? "color:#FB4B09;" : "" : $color['Gestion'];
            empty($color['Gestion'])? $color['Gestion'] = $color['Parametres'] = ($_SESSION['page'] == "parametres")? "color:#FB4B09;" : "" : $color['Gestion'];
            

            if($_SESSION['role']==0){
            echo '<div class="dropdown-divider"></div>
            <li class="nav-item d-none d-lg-block">
                <div class="dropdown">
                    <div  type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup=""
                        aria-expanded="false">
                        <a class=" nav-link mx-2 text-light" href="#"><i class="fa fa-sliders" style="width:1.5em;'. $color['Gestion'] .'" aria-hidden="true"></i>Gestion <span class="dropdown-toggle"></span></a>
                    </div>
                    <div class="dropdown-menu shadow mt-2 border-white bg-gblue" aria-labelledby="dropdownMenuButton">
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/candidats"><i class="fa fa-user" style="width:1.5em;'. $color['Candidat'] .' " aria-hidden="true"></i>Candidats</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/clients"><i class="fa fa-user" style="width:1.5em;'. $color['Client'] .'" aria-hidden="true"></i>Clients</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/moniteurs"><i class="fa fa-male" style="width:1.5em;'. $color['Moniteur'] .'" aria-hidden="true"></i>Moniteurs</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/vehiculs"><i class="fa fa-car" style="width:1.5em;'. $color['Vehicul'] .'" aria-hidden="true"></i>Vehiculs</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/planning"><i class="fa fa-calendar" style="width:1.5em;'. $color['Planning'] .'" aria-hidden="true"></i>Planning</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/examens"><i class="fa fa-calendar-plus-o" style="width:1.5em;'. $color['Examens'] .'" aria-hidden="true"></i>Examens</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link ml-2 text-light" href="'. URLROOT .'/gestion/parametres"><i class="fa fa-wrench" style="width:1.5em;'. $color['Parametres'] .'" aria-hidden="true"></i>Paramètres</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class=" nav-link  mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/candidats"><i class="fa fa-user" style="width:1.5em; '. $color['Candidat'] .'" aria-hidden="true"></i>Candidats</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link  mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/clients"><i class="fa fa-user" style="width:1.5em; '. $color['Client'] .'" aria-hidden="true"></i>Clients</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/moniteurs"><i class="fa fa-male" style="width:1.5em;'. $color['Moniteur'] .'" aria-hidden="true"></i>Moniteurs</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/vehiculs"><i class="fa fa-car" style="width:1.5em;'. $color['Vehicul'] .'" aria-hidden="true"></i>Vehiculs</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/planning"><i class="fa fa-calendar" style="width:1.5em;'. $color['Planning'] .'" aria-hidden="true"></i>Planning</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/examens"><i class="fa fa-calendar-plus-o" style="width:1.5em;'. $color['Examens'] .'" aria-hidden="true"></i>Exmaens</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link mx-2 text-light d-lg-none" href="'. URLROOT .'/gestion/parametres"><i class="fa fa-wrench" style="width:1.5em;'. $color['Parametres'] .'" aria-hidden="true"></i>Parametres</a>
            </li>';
            }?>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a class=" nav-link mx-2 d-lg-none text-light" href="<?php echo URLROOT ?>/users/modifier"><i
                            class="fa fa-cog" style="width:1.5em;" aria-hidden="true"></i>Modifier</a>
                </li>
                <li class="nav-item">
                    <a class=" nav-link  mx-2 d-lg-none  text-light" href="<?php echo URLROOT ?>/users/logout"><i
                            class="fa fa-sign-out" aria-hidden="true" style="width:1.5em;"></i>Se deconecter </span></a>
                </li>
            </ul>

            <!--Messages-->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-lg-block">
                    <div class="dropdown">
                        <div type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup=""
                            aria-expanded="true">
                            <img class=" mx-3 my-auto d-none d-lg-inline msg_icon" style=" width:1.8em;cursor:pointer;"
                                src="<?php echo URLROOT; ?>/svg/11.svg">
                        </div>
                        <div style="width:373px;max-height:300px;overflow: scroll;overflow-x:auto; "
                            class="dropdown-menu dropdown-menu-center text-light  p-2 shadow mt-3 border-white bg-gblue"
                            aria-labelledby="dropdownMenuButton">

                            <div class="col-12 mr-auto">
                                <div class="row new_message my-2"
                                    style=" cursor:pointer;text-decoration: none; color: inherit;">
                                    <div class="col-1 my-auto mr-2 ">
                                        <img src="<?php echo URLROOT.'/svg/add.svg'?>" class="border" style="width:2em;"
                                            alt="">
                                    </div>
                                    <div class="col-10 ml-3 my-auto">
                                        <h6 class="pt-2">Nouveau message</h6>
                                    </div>
                                </div>

                                <div class="conv">

                                </div>

                            </div>

                        </div>
                    </div>
                </li>
            </ul>
            <div style="height:2.1em;width:2px;" class="my-auto bg-light d-none d-lg-inline"></div>
            <!--Notification-->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-lg-block">
                    <div class="dropdown">
                        <div type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup=""
                            aria-expanded="true">
                            <img class=" mx-3 my-auto d-none d-lg-inline " style="width:1.5em;cursor:pointer;"
                                src="<?php echo URLROOT; ?>/svg/7.svg">
                        </div>
                        <div style="width:373px;max-height:300px;overflow-y:auto;"
                            class="dropdown-menu dropdown-menu-center text-light  p-2 shadow mt-3 border-white bg-gblue"
                            aria-labelledby="dropdownMenuButton">

                            <div class="col-12 mr-auto">
                                <div class="row my-3" style="cursor:pointer;text-decoration: none; color: inherit;">
                                    <div class="col-2 my-auto mx-auto">
                                        <!-- image -->
                                    </div>
                                    <div class="col-10">
                                        <!-- Text -->
                                    </div>
                                </div>
                                <div class="bg-white" style="height:1px;width:100%;"></div>
                                <div class="row" style="cursor:pointer;text-decoration: none; color: inherit;">
                                    <div class="col-2 my-auto mx-auto">
                                        
                                    </div>
                                    <div class="col-10">
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav" style="width:142px;">
                <div style="height:2em;width:1.5px;" class="my-auto bg-light d-none d-lg-inline"></div>
                <div style="cursor:pointer"
                    class="nav-item dropdown-toggle my-auto  ml-lg-auto d-none d-lg-inline text-light"
                    id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <li class="nav-item my-auto mx-3 d-none d-lg-inline "><?php echo $data['familyname']; ?></li>
                    <img src="<?php echo $_SESSION['dp'];?>" class="rounded-circle d-none d-lg-inline my-auto"
                        style="width:2.5em;" alt="">
                </div>

                <div class="dropdown-menu shadow dropdown-menu-right bg-gblue border-light"
                    aria-labelledby="navbarDropdown">
                    <a class="nav-link  text-light" href="<?php echo URLROOT ?>/users/modifier"><i class="fa fa-cog"
                            style="width:1.5em;" aria-hidden="true"></i>Modifier</a>
                    <div class="dropdown-divider"></div>
                    <a class="nav-link  text-light" href="<?php echo URLROOT ?>/users/logout"><i class="fa fa-sign-out"
                            aria-hidden="true" style="width:1.5em;"></i> Se deconecter</a>
                </div>
            </ul>
        </div>
    </nav>
    <!--notifications-->
    <div id="not" class="d-lg-none mx-auto mt-1 bg-gblue w-100 text-white" style="max-height:50vh; overflow:auto;">
        <div class="col-12 mr-auto">

        </div>

    </div>
    <!--messages-->
    <div id="mess" class="d-lg-none mx-auto mt-1 bg-gblue text-light w-100">
        <div class="col-12 mr-auto" style="overflow:auto;max-height:50vh;">

            <div class="row new_message my-2" style=" cursor:pointer;text-decoration: none; color: inherit;">
                <div class="col-1 my-auto mr-2 ">
                    <img src="<?php echo URLROOT.'/svg/add.svg'?>" class="border" style="width:2em;" alt="">
                </div>
                <div class="col-10 mr-auto my-auto">
                    <h6 class="pt-2">Nouveau message</h6>
                </div>
            </div>

            <div class="conv"></div>
        </div>
    </div>
</div>

<div id="message_container" class="d-none"
    style="right:0;top:0;left:0; bottom:0; position:fixed;z-index:10;background:rgba(0,0,0,0.4);">
    <div class="bg-gblue col-11 col-md-6 p-3 mx-auto h-75 mt-auto shadow border" style="transform:translateY(15vh);">
        <div class="head col-12 text-light">
            <div class="row">
                <span id="username"></span>
                <span id="close_message" class=" ml-auto bg-gblue text-right text-light"
                    style="cursor:pointer;">X</span>
            </div>
        </div>
        <div class="dropdown-divider"></div>

        <div id="body_msg" class="body bg-white" style="height:54vh; overflow-x:hidden;overflow-y:auto;">


        </div>

        <div class="dropdown-divider"></div>
        <div class="footer">
            <div class="input-group mb-3">
                <input id="write_msg" type="text" class="form-control" placeholder="Ecrire un message"
                    aria-label="Recipient's username" aria-describedby="send_msg">
                <div class="input-group-append text-light">
                    <button class="btn text-white" style="background-color:#FB4B09;" type="button"
                        id="send_msg">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contact_list" class="d-none"
    style="right:0;top:0;left:0; bottom:0; position:fixed;z-index:10;background:rgba(0,0,0,0.4);">
    <div class="bg-gblue col-11 col-md-6 p-3 mx-auto mt-auto shadow border" style="transform:translateY(15vh);">
        <div class="head col-12 text-light">
            <div class="row">
                <span class="col-10">List des contactes</span>
                <span id="close_contact" class=" ml-auto bg-gblue text-right text-light"
                    style="cursor:pointer;">X</span>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div id="contact_l" class=" body bg-gbule" style="max-height:54vh; overflow-x:hidden;overflow-y:auto;">
            <div id="30" class="row message_element" style="cursor:pointer;">
                <div class="col-1 my-auto mr-2">
                    <img src="<?php echo $_SESSION['dp'];?>" class="rounded-circle" style="width:3em;" alt="">
                </div>
                <div class="col-10 mr-auto text-light">
                    <small>Admin</small>
                    <h6>Bouniar Mouhamed</h6>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    //get new messege and add it to the body 



    $(document).ready(function () {
        //get conversations and put them :) 
        $("#mess").hide();
        $("#message").click(function () {
            $("#not").hide();
            $("#mess").fadeToggle(100);
        });
        $("#not").hide();
        $("#notification").click(function () {
            $("#mess").hide();
            $("#not").fadeToggle(100);
        });
    });

    //getconversations

    $.ajax({
        type: "POST",
        url: "<?php echo URLROOT ?>/gestion/getConversation",
        success: function (response) {
            $('.conv').html(response);
        }
    });

    $('#close_contact').click(function () {
        $('#contact_list').addClass('d-none');
    });
    $('.new_message').click(function () {
        //request contact 
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/getContacts",
            success: function (response) {
                $('#contact_l').html(response);
            }
        });
        $('#contact_list').removeClass('d-none');
    });

    function updateViewedMessage(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT; ?>/gestion/updateViewedMessage",
            data: {
                id: id
            },
        });
    }

    function isThereNewMessage(){
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/isThereNewMessage",
            success: function (response) {
                if(response.trim()=="1"){
                    $('.msg_icon').attr('src',"<?php echo URLROOT; ?>/svg/10.svg");
                }else{
                    $('.msg_icon').attr('src',"<?php echo URLROOT; ?>/svg/11.svg");
                }             
            }
        });
    }

    function scrollDown() {
        var n = $('#body_msg').height();
        $('#body_msg').animate({
            scrollTop: n * 1000
        }, 50);
    }

    function getName(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT ?>/gestion/getName",
            data: {
                id: id
            },
            success: function (response) {
                $('#username').html(response);
            }
        });
    }


    function run(id) {
        scrollDown();
        $('#contact_list').addClass('d-none');
        //get the messeges
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT;?>/gestion/getMessages",
            data: {
                id: id
            },
            success: function (response) {
                $("#body_msg").html(response);
            }
        });
        $('#message_container').removeClass('d-none');
        updateViewedMessage(id);
        getName(id);
        $('#write_msg').keypress(function (event) {

            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var msg_txt = $('#write_msg').val().trim();
                event.preventDefault();
                $('#write_msg').val("");
                if (msg_txt != "") {
                    var msg = `<div class="row my-2 ml-4 ">
                <div class="col-9 ml-auto pb-2  shadow-sm bg-info text-white rounded">
                    <span>` + msg_txt + `</span>
                </div>
                <div class="col-1 mr-4">
                    <img src="<?php echo $_SESSION['dp']?>" class="rounded-circle" style="width:2.5em;" alt="">
                </div>
            </div>`;
                    $('#body_msg').append(msg);
                    scrollDown()

                    //add the messege to the database

                    $.ajax({
                        type: "POST",
                        url: "<?php echo URLROOT;?>/gestion/addMessage",
                        data: {
                            desc_msg: msg_txt,
                            id: id
                        },
                    });

                }
            }

        });

        $('#send_msg').click(function () {
            var msg_txt = $('#write_msg').val().trim();
            $('#write_msg').val("");
            if (msg_txt != "") {
                var msg = `
                <div class="row my-2 ml-4 ">
                    <div class="col-9 ml-auto pb-2  shadow-sm bg-info text-white rounded">
                        <span>` + msg_txt + `</span>
                    </div>
                    <div class="col-1 mr-4">
                        <img src="<?php echo $_SESSION['dp']?>" class="rounded-circle" style="width:2.5em;" alt="">
                    </div>
                </div>`;
                $('#body_msg').append(msg);
                n = $('#body_msg').height();
                $('#body_msg').animate({
                    scrollTop: n * 1000
                }, 50);

                //add the messege to the database

                $.ajax({
                    type: "POST",
                    url: "<?php echo URLROOT;?>/gestion/addMessage",
                    data: {
                        desc_msg: msg_txt,
                        id: id
                    },
                    success: function (response) {}
                });

            }

        });

    }
    $('#close_message').click(function () {
        $('#send_msg').unbind();
        $('#write_msg').val("");
        $('#send_msg').unbind();
        $('#message_container').addClass('d-none');
    });
    $('.message_element').click(function () {
        $('#contact_list').addClass('d-none');
        $('#message_container').removeClass('d-none');
    });
</script>

<!--End of navbar-->