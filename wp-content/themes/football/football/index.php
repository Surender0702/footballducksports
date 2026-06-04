<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    $slides = new WP_Query(
        array(
            'post_type'      => 'custom_slider',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        )
    );
    ?>

    <?php if ($slides->have_posts()) : ?>
        <section id="customCarousel" class="carousel slide carousel-fade academy-carousel" data-bs-ride="carousel" aria-label="<?php esc_attr_e('Academy highlights', 'football'); ?>">
            <div class="carousel-indicators">
                <?php for ($count = 0; $count < $slides->post_count; $count++) : ?>
                    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="<?php echo esc_attr($count); ?>" class="<?php echo $count === 0 ? 'active' : ''; ?>" <?php echo $count === 0 ? 'aria-current="true"' : ''; ?> aria-label="<?php echo esc_attr(sprintf(__('Slide %d', 'football'), $count + 1)); ?>"></button>
                <?php endfor; ?>
            </div>

            <div class="carousel-inner">
                <?php
                $active = 'active';
                while ($slides->have_posts()) :
                    $slides->the_post();
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $text = football_get_field('custom_slider_text', get_the_ID(), __('Build confidence, discipline, and match intelligence with structured football coaching.', 'football'));
                    $button_text = football_get_field('custom_slider_button_text', get_the_ID(), __('Join the Academy', 'football'));
                    $button_link = football_get_field('custom_slider_button_link', get_the_ID(), football_registration_url());
                    ?>
                    <div class="carousel-item <?php echo esc_attr($active); ?>">
                        <?php if ($image) : ?>
                            <img src="<?php echo esc_url($image); ?>" class="d-block w-100" alt="<?php the_title_attribute(); ?>">
                        <?php else : ?>
                            <div class="academy-carousel__fallback" aria-hidden="true"></div>
                        <?php endif; ?>

                        <div class="carousel-caption academy-carousel__caption">
                            <span class="section-kicker"><?php esc_html_e('Football Ducks Sports', 'football'); ?></span>
                            <h1><?php the_title(); ?></h1>
                            <p><?php echo esc_html($text); ?></p>
                            <a href="<?php echo esc_url($button_link); ?>" class="btn btn-registration">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        </div>
                    </div>
                    <?php
                    $active = '';
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#customCarousel" data-bs-slide="prev" aria-label="<?php esc_attr_e('Previous slide', 'football'); ?>">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#customCarousel" data-bs-slide="next" aria-label="<?php esc_attr_e('Next slide', 'football'); ?>">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </section>
    <?php else : ?>
        <section class="academy-hero">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <span class="section-kicker"><?php esc_html_e('Football Ducks Sports Academy', 'football'); ?></span>
                        <h1 class="academy-hero__title">
                            <span><?php esc_html_e('Train smarter.', 'football'); ?></span>
                            <span><?php esc_html_e('Play faster.', 'football'); ?></span>
                            <span><?php esc_html_e('Grow with purpose.', 'football'); ?></span>
                        </h1>
                        <p class="academy-hero__lead">
                            <?php esc_html_e('Professional football coaching for young players, built around fundamentals, tactical awareness, fitness, and match confidence.', 'football'); ?>
                        </p>

                        <div class="academy-hero__actions">
                            <a href="<?php echo esc_url(football_registration_url()); ?>" class="btn btn-registration">
                                <?php esc_html_e('Register Online', 'football'); ?>
                            </a>
                            <a href="<?php echo esc_url(home_url('/#programs')); ?>" class="btn btn-outline-light academy-btn-secondary">
                                <?php esc_html_e('View Programs', 'football'); ?>
                            </a>
                        </div>

                        <div class="academy-hero__meta" aria-label="<?php esc_attr_e('Academy highlights', 'football'); ?>">
                            <span><strong>250+</strong> students trained</span>
                            <span><strong>4</strong> active locations</span>
                            <span><strong>U-8 to U-17</strong> batches</span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="academy-visual" aria-hidden="true">
                            <div class="academy-visual__pitch">
                                <span class="pitch-line pitch-line--half"></span>
                                <span class="pitch-line pitch-line--circle"></span>
                                <span class="pitch-line pitch-line--box pitch-line--box-left"></span>
                                <span class="pitch-line pitch-line--box pitch-line--box-right"></span>
                            </div>
                            <div class="academy-visual__card academy-visual__card--top">
                                <span>Foundation</span>
                                <strong>Ball mastery</strong>
                            </div>
                            <div class="academy-visual__card academy-visual__card--bottom">
                                <span>Match Ready</span>
                                <strong>Speed + tactics</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="academy-stats" aria-label="<?php esc_attr_e('Academy strengths', 'football'); ?>">
        <div class="container">
            <div class="academy-stats__grid">
                <div>
                    <strong>Structured</strong>
                    <span>age-wise training plans</span>
                </div>
                <div>
                    <strong>Competitive</strong>
                    <span>match exposure and events</span>
                </div>
                <div>
                    <strong>Disciplined</strong>
                    <span>fitness, teamwork, confidence</span>
                </div>
            </div>
        </div>
    </section>

    <section id="programs" class="academy-section academy-section--programs">
        <div class="container">
            <div class="section-heading">
                <span class="section-kicker"><?php esc_html_e('Training Pathway', 'football'); ?></span>
                <h2><?php esc_html_e('Programs for every stage of a player journey', 'football'); ?></h2>
                <p><?php esc_html_e('A clear development pathway helps players build technique first, then pressure handling, decision-making, and match rhythm.', 'football'); ?></p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <article class="program-card">
                        <span class="program-card__label">U-8 to U-11</span>
                        <h3><?php esc_html_e('Foundation Training', 'football'); ?></h3>
                        <p><?php esc_html_e('First touch, passing habits, coordination, balance, and joy on the ball.', 'football'); ?></p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="program-card program-card--featured">
                        <span class="program-card__label">U-12 to U-15</span>
                        <h3><?php esc_html_e('Skill Development', 'football'); ?></h3>
                        <p><?php esc_html_e('Dribbling under pressure, positional play, finishing, defensive shape, and team play.', 'football'); ?></p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="program-card">
                        <span class="program-card__label">Advanced</span>
                        <h3><?php esc_html_e('Match Preparation', 'football'); ?></h3>
                        <p><?php esc_html_e('Game intelligence, speed endurance, set-piece discipline, and tournament readiness.', 'football'); ?></p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <?php
    $gallery_query = new WP_Query(
        array(
            'post_type'      => 'gallery_slide',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ),
            'no_found_rows'  => true,
        )
    );

    $gallery_items = array();

    if ($gallery_query->have_posts()) {
        while ($gallery_query->have_posts()) {
            $gallery_query->the_post();

            $image_id = get_post_thumbnail_id(get_the_ID());
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';

            if (!$image_url) {
                continue;
            }

            $caption = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 24);
            $image_alt = trim((string) get_post_meta($image_id, '_wp_attachment_image_alt', true));

            $gallery_items[] = array(
                'title'   => get_the_title(),
                'caption' => $caption,
                'image'   => $image_url,
                'alt'     => $image_alt ?: get_the_title(),
                'label'   => football_get_field('gallery_slide_label', get_the_ID(), __('Football Moments', 'football')),
            );
        }

        wp_reset_postdata();
    }
    ?>

    <?php if (!empty($gallery_items)) : ?>
        <section id="gallery" class="academy-section academy-section--gallery">
            <div class="container">
                <div class="section-heading">
                    <span class="section-kicker"><?php esc_html_e('Gallery', 'football'); ?></span>
                    <h2><?php esc_html_e('Prize distribution, tournaments, and academy moments', 'football'); ?></h2>
                    <p><?php esc_html_e('A rotating view of the moments that make players, parents, and the academy community proud.', 'football'); ?></p>
                </div>

                <div id="footballGalleryCarousel" class="carousel slide gallery-carousel" data-bs-ride="carousel" data-bs-interval="3800" aria-label="<?php esc_attr_e('Football gallery images', 'football'); ?>">
                    <?php if (count($gallery_items) > 1) : ?>
                        <div class="carousel-indicators">
                            <?php foreach ($gallery_items as $index => $gallery_item) : ?>
                                <button type="button" data-bs-target="#footballGalleryCarousel" data-bs-slide-to="<?php echo esc_attr($index); ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" <?php echo $index === 0 ? 'aria-current="true"' : ''; ?> aria-label="<?php echo esc_attr(sprintf(__('Gallery slide %d', 'football'), $index + 1)); ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="carousel-inner">
                        <?php foreach ($gallery_items as $index => $gallery_item) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($gallery_item['image']); ?>" class="d-block w-100" alt="<?php echo esc_attr($gallery_item['alt']); ?>" loading="lazy">
                                <div class="gallery-carousel__caption">
                                    <span><?php echo esc_html($gallery_item['label']); ?></span>
                                    <h3><?php echo esc_html($gallery_item['title']); ?></h3>
                                    <?php if ($gallery_item['caption']) : ?>
                                        <p><?php echo esc_html($gallery_item['caption']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($gallery_items) > 1) : ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#footballGalleryCarousel" data-bs-slide="prev" aria-label="<?php esc_attr_e('Previous gallery image', 'football'); ?>">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#footballGalleryCarousel" data-bs-slide="next" aria-label="<?php esc_attr_e('Next gallery image', 'football'); ?>">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/events'); ?>

    <section id="about" class="academy-section academy-section--split">
        <div class="container">
            <div class="row align-items-center g-5">
                <?php
                $about_query = new WP_Query(
                    array(
                        'category_name'  => 'about-us',
                        'posts_per_page' => 1,
                        'post_status'    => 'publish',
                    )
                );

                if ($about_query->have_posts()) :
                    while ($about_query->have_posts()) :
                        $about_query->the_post();
                        $about_us_content = football_get_field('about_us_content', get_the_ID(), get_the_content());
                        $about_us_image = football_image_url(football_get_field('about_us_image', get_the_ID()));
                        ?>
                        <div class="col-lg-6">
                            <span class="section-kicker"><?php esc_html_e('About Us', 'football'); ?></span>
                            <h2 class="section-title"><?php the_title(); ?></h2>
                            <div class="content-copy"><?php echo wp_kses_post(wpautop($about_us_content)); ?></div>
                        </div>
                        <div class="col-lg-6">
                            <?php if ($about_us_image) : ?>
                                <img src="<?php echo esc_url($about_us_image); ?>" class="content-image" alt="<?php esc_attr_e('Football academy training session', 'football'); ?>">
                            <?php else : ?>
                                <div class="content-image content-image--placeholder">
                                    <span><?php esc_html_e('Player Development', 'football'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="col-lg-6">
                        <span class="section-kicker"><?php esc_html_e('About Us', 'football'); ?></span>
                        <h2 class="section-title"><?php esc_html_e('A focused academy for confident young footballers', 'football'); ?></h2>
                        <div class="content-copy">
                            <p><?php esc_html_e('Football Ducks Sports Academy develops young players through disciplined coaching, match exposure, and a positive training culture. Every session is planned to improve technique, awareness, fitness, and teamwork.', 'football'); ?></p>
                            <p><?php esc_html_e('The academy works across schools and local grounds in Faridabad, Delhi, and Dwarka, making quality football training accessible for growing players.', 'football'); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-image content-image--placeholder">
                            <span><?php esc_html_e('Technique. Fitness. Teamwork.', 'football'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="skill-development" class="academy-section academy-section--light">
        <div class="container">
            <div class="row align-items-center g-5">
                <?php
                $skill_query = new WP_Query(
                    array(
                        'category_name'  => 'skill-development',
                        'posts_per_page' => 1,
                        'post_status'    => 'publish',
                    )
                );

                $skill_title = __('Skill Development', 'football');
                $skill_content = __('Players progress through ball mastery, passing patterns, finishing, defending principles, agility, and game scenarios. The goal is simple: help every player become technically sharper and tactically calmer.', 'football');
                $skill_image = '';

                if ($skill_query->have_posts()) {
                    $skill_query->the_post();
                    $skill_title = get_the_title();
                    $skill_content = football_get_field('skill_dev_content', get_the_ID(), get_the_content());
                    $skill_image = football_image_url(football_get_field('skill_dev_image', get_the_ID()));
                    wp_reset_postdata();
                }
                ?>

                <div class="col-lg-6 order-lg-2">
                    <span class="section-kicker"><?php esc_html_e('Coaching Method', 'football'); ?></span>
                    <h2 class="section-title"><?php echo esc_html($skill_title); ?></h2>
                    <div class="content-copy"><?php echo wp_kses_post(wpautop($skill_content)); ?></div>

                    <div class="method-list">
                        <span>Technical drills</span>
                        <span>Small-sided games</span>
                        <span>Fitness circuits</span>
                        <span>Match review</span>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <?php if ($skill_image) : ?>
                        <img src="<?php echo esc_url($skill_image); ?>" class="content-image" alt="<?php esc_attr_e('Football skill development training', 'football'); ?>">
                    <?php else : ?>
                        <div class="training-board" aria-hidden="true">
                            <span class="training-board__dot training-board__dot--one"></span>
                            <span class="training-board__dot training-board__dot--two"></span>
                            <span class="training-board__dot training-board__dot--three"></span>
                            <span class="training-board__path"></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    $contact_title = football_get_field('contact_title', false, __('Contact Us', 'football'));
    $contact_subtitle = football_get_field('contact_subtitle', false, __('Book a trial session or ask about batches near you.', 'football'));
    $contact_email = football_get_field('contact_email', false, 'football.ducksports@gmail.com');
    $contact_phone = football_get_field('contact_phone', false, '+91 98214 40038');
    $contact_address = football_get_field(
        'contact_address',
        false,
        '<ul><li>The Shree Jee School, Lakewood City, Surajkund Road, Faridabad</li><li>KL Mehta Dayanand Public School, Sector 17, Faridabad</li><li>Pt. Yadram Public School, Bhajanpura, Delhi</li><li>Dwarka Sector 2, Mahalaxmi Apartments</li></ul>'
    );
    ?>

    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-heading section-heading--light">
                <span class="section-kicker"><?php esc_html_e('Start Training', 'football'); ?></span>
                <h2><?php echo esc_html($contact_title); ?></h2>
                <p><?php echo esc_html($contact_subtitle); ?></p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <article class="contact-card">
                        <span>Email</span>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="contact-card">
                        <span>Phone</span>
                        <a href="tel:+919821440038"><?php echo esc_html($contact_phone); ?></a>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="contact-card contact-card--locations">
                        <span>Locations</span>
                        <?php echo wp_kses_post($contact_address); ?>
                    </article>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
