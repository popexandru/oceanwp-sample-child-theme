<?php
    add_action( 'login_enqueue_scripts', function(){
        ?>
            <style type="text/css">
                body.login{
                    background: #f2f2f2;
                }
                body.login div#login h1 a {display: none;}
                body.login div#login h1{
                    background-image: url(<?php echo get_stylesheet_directory_uri() . '/public/assets/img/*-logo.png'; ?>);
                    background-repeat: no-repeat;
                    background-position: top center;
                    max-width: 100%;
                    width: 100%;
                    height: auto;
                    padding-bottom: 85px;
                    background-size: auto;
                }
            </style>
        <?php
    });
?>
