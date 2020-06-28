<?php
require_once './views/top.php';
?>
</head>

<body>

    <!-- Header -->
    <?php
    require_once './views/blog/blog_header.php';
    ?>
    <!-- /Header -->

    <!-- Blog -->
    <div id="blog" class="section mdpadding">
        <!-- Container -->

        <!--containter have wrong spell here-->
        <div class="container-fluid">
            <?php
            require_once './views/blog/left.php';
            ?>
            <!-- Row -->
            <!--<div class="row">-->
            <!-- Main -->
            <?php
            require_once './views/blog/main.php';
            ?>

            <!-- /Main -->
            <!--</div>-->

            <!-- Aside -->
            <?php
            require_once 'views/blog/right.php';
            ?>
            <!-- /Aside -->

        </div>
        <!-- /Row -->
        <!-- /Container -->
    </div>

    <!-- /Blog -->
</div>
<!-- Footer -->
<footer id="footer" class="sm-padding bg-dark">

    <!-- Container -->
    <div class="container">

        <!-- Row -->
        <div class="row">

            <div class="col-md-12">

                <!-- footer logo -->
                <div class="footer-logo">
                    <a href="index.html"><img src="img/rami.png" alt="logo"></a>
                </div>
                <!-- /footer logo -->

                <!-- footer follow -->
                <ul class="footer-follow">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                </ul>
                <!-- /footer follow -->

                <!-- footer copyright -->
                <div class="footer-copyright">
                    <p>Copyright © 2017. All Rights Reserved. Designed by <a href="https://baurami.com" target="_blank">Baurami</a></p>
                </div>
                <!-- /footer copyright -->

            </div>

        </div>
        <!-- /Row -->

    </div>
    <!-- /Container -->

</footer>
<!-- /Footer -->

<!-- Back to top -->
<div id="back-to-top"></div>
<!-- /Back to top -->

<!-- Preloader -->
<div id="preloader">
    <div class="preloader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- /Preloader -->

<!-- jQuery Plugins -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
<script type="text/javascript" src="js/main.js"></script>

</body>

</html>
