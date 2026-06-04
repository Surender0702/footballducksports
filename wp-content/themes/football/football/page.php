<?php get_header(); ?>

<main id="primary" class="site-main page-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                $is_registration_page = is_page(array('online-registration', 'online-regisration'));
                ?>
                <article <?php post_class('page-content-card'); ?>>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="content-copy">
                        <?php the_content(); ?>
                        <?php if ($is_registration_page && function_exists('football_render_registration_form')) : ?>
                            <?php echo football_render_registration_form(); ?>
                        <?php endif; ?>
                    </div>
                </article>
                <?php
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
