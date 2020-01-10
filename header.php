<!doctype html>
<html lang="<?php echo ICL_LANGUAGE_CODE ?>">
<head>
    <title><?php wp_title('|', true, 'right'); ?> <?php echo get_bloginfo( 'name' ); ?></title>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Josefin+Sans:400,600,700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/fonts/bpg-web-002-caps/css/bpg-web-002-caps.min.css">
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/fonts/bpg-arial/css/bpg-arial.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="<?php echo get_bloginfo('template_directory'); ?>/js/script.min.js"></script>

    <meta name="description" content="<?php echo get_post_meta(get_the_ID(), 'meta-description', TRUE); ?>">
    <meta name="keywords" content="<?php echo get_post_meta(get_the_ID(), 'meta-keys', TRUE); ?>">

    <meta property="og:title" content="<?php echo get_post_meta(get_the_ID(), 'facebook-title', TRUE); ?>">
    <meta property="og:description" content="<?php echo get_post_meta(get_the_ID(), 'facebook-description', TRUE); ?>">
    <meta property="og:image" content="<?php the_post_thumbnail_url(); ?>">
    <meta property="og:url" content="<?php global $wp; echo home_url( $wp->request ); ?>">

    <?php wp_head(); ?>
</head>
<body class="body body--lang-<?php echo ICL_LANGUAGE_CODE ?>">
<header class="header">
    <div class="languages">
        <?php language_switcher(); ?>
    </div>
    <?php
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo_src = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    ?>
    <a href="<?php echo get_home_url(); ?>" class="logo">
        <img src="<?php echo $logo_src[0]; ?>" alt="David Production" class="logo__image">
    </a>
    <button class="hamburger" id="hamburger">
        <span class="hamburger__line hamburger__first-line"></span>
        <span class="hamburger__line hamburger__second-line"></span>
        <span class="hamburger__line hamburger__third-line"></span>
    </button>
    <nav class="navigation" id="navigation">
        <menu class="categories-menu">
            <?php
            $walker_menu = new My_Walker_Nav_Menu();
            $walker_menu->set_menu_class('categories');
            wp_nav_menu( array(
                'theme_location' => 'categories_menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker'         => $walker_menu
            ) );
            ?>

        </menu>
        <menu class="about-menu">
            <?php
            $walker_menu = new My_Walker_Nav_Menu();
            $walker_menu->set_menu_class('about');
            wp_nav_menu( array(
                'theme_location' => 'about_menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker'         => $walker_menu,
            ) );
            ?>
        </menu>
    </nav>
</header>
<main class="main">