<!-- Sections with Image & Text -->
<section id="about" class="container content-section">
    <div class="row">
        <div class="col-md-6">
            <h2 class="section-title"><?php the_field('about_title'); ?></h2>
            <p><?php the_field('about_content'); ?></p>

            <!-- Football Clubs Section -->
            <ul>
                <?php if (get_field('about_club_1')) : ?>
                    <li><strong><?php the_field('about_club_1'); ?></strong> (<?php the_field('about_club_1_location'); ?>)</li>
                <?php endif; ?>
                <?php if (get_field('about_club_2')) : ?>
                    <li><strong><?php the_field('about_club_2'); ?></strong> (<?php the_field('about_club_2_location'); ?>)</li>
                <?php endif; ?>
                <?php if (get_field('about_club_3')) : ?>
                    <li><strong><?php the_field('about_club_3'); ?></strong> (<?php the_field('about_club_3_location'); ?>)</li>
                <?php endif; ?>
            </ul>

            <!-- Academy Locations Section -->
            <p>Currently, we have around 250 students at different locations as follows:</p>
            <ul>
                <?php if (get_field('about_location_1')) : ?>
                    <li><strong><?php the_field('about_location_1'); ?></strong>, <?php the_field('about_location_1_area'); ?></li>
                <?php endif; ?>
                <?php if (get_field('about_location_2')) : ?>
                    <li><strong><?php the_field('about_location_2'); ?></strong>, <?php the_field('about_location_2_area'); ?></li>
                <?php endif; ?>
                <?php if (get_field('about_location_3')) : ?>
                    <li><strong><?php the_field('about_location_3'); ?></strong>, <?php the_field('about_location_3_area'); ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Carousel for About Us Images -->
        <div class="col-md-6">
            <div id="carouselAboutUs" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $first = true;
                    for ($i = 1; $i <= 3; $i++) {
                        $image = get_field("about_image_$i");
                        if ($image) : ?>
                            <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($image['url']); ?>" class="d-block w-100" alt="<?php echo esc_attr($image['alt']); ?>">
                            </div>
                            <?php $first = false; ?>
                        <?php endif;
                    }
                    ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAboutUs" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselAboutUs" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section>
