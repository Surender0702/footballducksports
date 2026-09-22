<footer class="site-footer">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <a class="footer-brand d-inline-flex align-items-center gap-3" href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url(content_url('/uploads/2026/08/logo.png')); ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo-img" style="max-height: 48px; width: auto;">
                    <span><?php bloginfo('name'); ?></span>
                </a>
                <p><?php esc_html_e('Professional youth football coaching focused on technique, discipline, confidence, and match readiness.', 'football'); ?></p>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h2><?php esc_html_e('Quick Links', 'football'); ?></h2>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/#programs')); ?>"><?php esc_html_e('Programs', 'football'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/#latest-event')); ?>"><?php esc_html_e('Highlights', 'football'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/#about')); ?>"><?php esc_html_e('About', 'football'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/#contact')); ?>"><?php esc_html_e('Contact', 'football'); ?></a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-4">
                <h2><?php esc_html_e('Admissions', 'football'); ?></h2>
                <p><?php esc_html_e('Book a trial class and find the right batch for your player.', 'football'); ?></p>
                <a class="btn btn-registration footer-cta" href="<?php echo esc_url(football_registration_url()); ?>">
                    <?php esc_html_e('Register Online', 'football'); ?>
                </a>
            </div>
        </div>

        <div class="site-footer__bottom">
            <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'football'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<?php
if (shortcode_exists('manual_ai_chatbot')) {
    echo do_shortcode('[manual_ai_chatbot]');
}
?>

</body>
</html>
