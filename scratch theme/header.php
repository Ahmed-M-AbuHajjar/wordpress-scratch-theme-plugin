<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>scratch theme</title>
    <?php wp_head();?>
</head>
<body <?php body_class();?>>
<header>
    <nav>
    <div class="container d-flex justify-content-between h-100">
        <?php
         // Navigation Menu
        do_action('wp_body_open');
        wp_nav_menu(
            array(
                'theme_location'=>'top-menu',
                'menu_class'=>'top-bar'
            )
        );
        ?>
    </div>
    </nav>
</header>
    
