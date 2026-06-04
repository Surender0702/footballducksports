<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="academy-topbar">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span>Football training for young players across Delhi NCR</span>
            <div class="academy-topbar__links">
                <a href="mailto:football.ducksports@gmail.com">football.ducksports@gmail.com</a>
                <a href="tel:+919821440038">+91 98214 40038</a>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark academy-navbar" aria-label="<?php esc_attr_e('Primary navigation', 'football'); ?>">
        <div class="container">
            <a class="navbar-brand academy-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (has_custom_logo()) : ?>
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'custom-logo'));
                    ?>
                <?php else : ?>
                    <span class="academy-brand__mark" aria-hidden="true">FD</span>
                    <span class="academy-brand__text">
                        <strong><?php bloginfo('name'); ?></strong>
                        <small><?php esc_html_e('Football Academy', 'football'); ?></small>
                    </span>
                <?php endif; ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'football'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'navbar-nav ms-auto align-items-lg-center',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 2,
                        'walker'         => new Bootstrap_NavWalker(),
                    )
                );
                ?>

                <?php if (!has_nav_menu('primary')) : ?>
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/#programs')); ?>">Programs</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/#latest-event')); ?>">Highlights</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/#about')); ?>">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/#contact')); ?>">Contact</a></li>
                    </ul>
                <?php endif; ?>

                <a class="btn btn-registration nav-registration" href="<?php echo esc_url(football_registration_url()); ?>">
                    <?php esc_html_e('Register', 'football'); ?>
                </a>
            </div>
        </div>
    </nav>
</header>
