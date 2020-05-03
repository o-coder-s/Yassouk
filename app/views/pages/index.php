<?php require APPROOT . '/views/inc/header.php'; ?>

<!--Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
    <a class="navbar-brand" href="index.html"><span class="o_b">YASS</span><span>OUK</span></a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class=" nav-item">
                <a class="nav-link" href="#parcours">PARCOURS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#platform">PLATEFORME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#nous">NOUS</a>
            </li>
            
            <li class="nav-item d-lg-none">
                <a class="nav-link " href="<?php echo URLROOT;?>/users/signin">SE CONNECTER</a>
            </li>
            <li class="nav-item d-lg-none">
                <a class="nav-link " href="<?php echo URLROOT;?>/users/signup">S'INSCRIR</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-light d-none d-lg-flex mx-3 mr-3" href="<?php echo URLROOT;?>/users/signin">SE CONNECTER</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger btn-sm text-light d-none d-lg-flex mx-3 mr-3" href="<?php echo URLROOT;?>/users/signup"
                    style="background-color:#FF880D;">S'INSCRIRE</a>
            </li>
        </ul>
    </div>
</nav>

<!--TET LE LA PAGE-->

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="<?php echo URLROOT;?>/images/Avatar.png" alt="First slide">
        </div>
        <div class="carousel-caption d-block">
            <h1 style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5));font-size: 5vw;">La Meillieure Auto-Ecole En Algerie </h1>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!--PARCOURS-->

    <section class="parcours p-5" style="background-color: #F7F7F7">
        <div class="row  " id="parcours">
            <div class="col ">
                <h1 class="text-center "><span class="border-custom">PARCOURS</span></h1>
            </div>
        </div>
        <div class="row mb-5 ">
            <div class="col-12 col-lg-4 ">
                <img src="<?php echo URLROOT;?>/svg/1.svg" class="img-parcours w-100 " alt="">
                <h3 class="mb-4"><span class="border-custom">Code de la route</span></h3>
                <p>Apprendre le code de la route avec des formateurs professionnels, de façon interactive.</p>
            </div>
            <div class="col-12 col-lg-4 ">
                <img src="<?php echo URLROOT;?>/svg/2.svg" class="img-parcours w-100" alt="">
                <h3 class="mb-4"><span class="border-custom">Crénaux</span></h3>
                <p>Vous apprendrez a stationner les véhicules avec une formation efficace, nous assurons que vous serez près et capable le jour d’examen. </p>
            </div>
            <div class="col-12 col-lg-4 ">
                <img src="<?php echo URLROOT;?>/svg/3.svg" class="img-parcours w-100" alt="">
                <h3 class="mb-4"><span class="border-custom">Conduit</span></h3>
                <p>Vous apprendrez a Controller le véhicule, ainsi circuler dans les espaces routiers grâce a l’aide de nos moniteurs compétents.</p>
            </div>
        </div>
    </section>
    <!--PLATFORM-->
    <div class="row m-5 mb-5" id="platform">
        <div class="col">
            <h1 class="text-center "><span class="border-custom">PLATEFORME</span></h1>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-6 d-flex align-items-center ">
            <div class="platform-ul mx-auto">
                <ul>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Acceder
                        depuis
                        n'import quellle appariel.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Une
                        plateforme
                        completement responsive.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Réserver
                        vos
                        séances en-ligne.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Poser vos
                        question directement a l'administrateur.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Modifer
                        votre
                        planning comme vous voulez.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Recevoir des notification 
                    sur le changement des seances.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Gestion
                        du
                        compte.</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Consulter vos 
                    paiements .</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Forum pour intéragie avec d'autres utilisateurs</li>
                    <li class="platform-ls"><span><img src="<?php echo URLROOT;?>/svg/5.svg" style="width: 1em;" alt=""></span> Accès aux ressources crées par des moniteurs pour vous aider a améliorer vos connaisance </li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-6 ">
            <img class="d-inline-block w-100" src="<?php echo URLROOT;?>/images/platform.png" alt="Platform">
        </div>

    </div>

    
    <!--Nous-->
    <div class="row pt-5 " id="nous">
        <div class="col">
            <h1 class="text-center pb-3 "><span class="border-custom">NOUS</span></h1>
        </div>
    </div>
    <div class="row">
        <div class="embed-responsive embed-responsive-16by9 mx-auto col-11 w-100" style="height: 500px">
            <iframe id="gmap_canvas"
                src="https://maps.google.com/maps?q=University%20of%20boumerdes&t=&z=17&ie=UTF8&iwloc=&output=embed"
                frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
            </iframe>
        </div>

    </div>

    <!--Footer-->

    <div class="shadow-lg " style="background-color: rgb(240, 238, 238)">
        <footer class="page-footer font-small blue pt-4 container mx-auto">

            <!-- Footer Links -->
            <div class="container-fluid text-center text-md-left">

                <!-- Grid row -->
                <div class="row">

                    <!-- Grid column -->
                    <div class="col-md-5 pl-md-5 mt-md-0 mt-3 text-left">

                        <!-- Content -->
                        <h5 class="text-uppercase mb-4"><span class="border-custom"> CONTACT</span></h5>
                        <p>024950587</p>
                        <p>contact@yassouk.com</p>
                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none pb-3">

                    <!-- Grid column -->
                    <div class="col-md-4 mb-md-0 mb-3">

                        <!-- Links -->
                        <h5 class="text-uppercase mb-4 text-left"><span class="border-custom">RESEAUX SOCIAUX</span></h5>

                        <ul class="list-unstyled">

                        </ul>

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 mb-md-0 mb-3">

                        <!-- Links -->
                        <h5 class="text-uppercase mb-4 text-left"><span class="border-custom">promotions</span></h5>

                        <form action="" class="ml-3">
                            <div class="row">
                                <div class="form-group">
                                    <input id="email" class="form-control" type="email" name=""
                                        placeholder="Votre email">
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-danger btn-sm" style="background-color: #FF880D">INSCRIT</button>
                            </div>
                        </form>

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

            </div>
            <!-- Footer Links -->

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2019 Copyright:
                <span class="o_b">YASS</span><span>OUK</span>
            </div>
            <!-- Copyright -->

        </footer>
        <?php require APPROOT . '/views/inc/footer.php';?>
