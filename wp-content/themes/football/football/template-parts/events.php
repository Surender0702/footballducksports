<section id="latest-event" class="academy-section academy-section--events">
    <div class="container">
        <div class="section-heading">
            <span class="section-kicker"><?php esc_html_e('Academy Newsroom', 'football'); ?></span>
            <h2><?php esc_html_e('Highlights and latest updates', 'football'); ?></h2>
            <p><?php esc_html_e('Keep the homepage active with match clips, academy notices, achievements, and upcoming training announcements.', 'football'); ?></p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="event-panel event-panel--media">
                    <div class="event-panel__header">
                        <h3><?php esc_html_e('Highlights', 'football'); ?></h3>
                        <span><?php esc_html_e('Video wall', 'football'); ?></span>
                    </div>

                    <div class="video-container">
                        <?php
                        $video_query = new WP_Query(
                            array(
                                'post_type'      => 'events',
                                'posts_per_page' => 2,
                                'order'          => 'DESC',
                                'orderby'        => 'date',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'event_type',
                                        'field'    => 'slug',
                                        'terms'    => 'youtube',
                                    ),
                                ),
                            )
                        );

                        if ($video_query->have_posts()) :
                            while ($video_query->have_posts()) :
                                $video_query->the_post();
                                $video_url = football_youtube_embed_url(football_get_field('youtube_video_url', get_the_ID()));

                                if ($video_url) :
                                    ?>
                                    <div class="ratio ratio-16x9 academy-video">
                                        <iframe src="<?php echo esc_url($video_url); ?>" title="<?php the_title_attribute(); ?>" allowfullscreen loading="lazy"></iframe>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <div class="empty-highlight">
                                <span>01</span>
                                <h4><?php esc_html_e('Training highlight ready', 'football'); ?></h4>
                                <p><?php esc_html_e('Add an Events post tagged “youtube” with a YouTube URL to replace this placeholder.', 'football'); ?></p>
                            </div>
                            <div class="empty-highlight empty-highlight--alt">
                                <span>02</span>
                                <h4><?php esc_html_e('Matchday reels', 'football'); ?></h4>
                                <p><?php esc_html_e('Share tournament clips, player development moments, and academy event recaps.', 'football'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="event-panel">
                    <div class="event-panel__header">
                        <h3><?php esc_html_e('Latest Updates', 'football'); ?></h3>
                        <span><?php esc_html_e('Notice board', 'football'); ?></span>
                    </div>

                    <ul class="latest-updates">
                        <?php
                        $update_query = new WP_Query(
                            array(
                                'post_type'      => 'events',
                                'posts_per_page' => 5,
                                'order'          => 'DESC',
                                'orderby'        => 'date',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'event_type',
                                        'field'    => 'slug',
                                        'terms'    => 'latest-updates',
                                    ),
                                ),
                            )
                        );

                        if ($update_query->have_posts()) :
                            while ($update_query->have_posts()) :
                                $update_query->the_post();
                                ?>
                                <li class="update-item">
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('M j, Y')); ?></time>
                                    <strong><?php the_title(); ?></strong>
                                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                                </li>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            $fallback_updates = array(
                                array('New student trial sessions are open for weekday and weekend batches.', 'Admissions'),
                                array('Skill development groups focus on ball mastery, passing speed, and finishing.', 'Training'),
                                array('Academy locations are active in Faridabad, Delhi, and Dwarka.', 'Locations'),
                            );

                            foreach ($fallback_updates as $fallback_update) :
                                ?>
                                <li class="update-item">
                                    <time><?php echo esc_html($fallback_update[1]); ?></time>
                                    <strong><?php echo esc_html($fallback_update[0]); ?></strong>
                                    <p><?php esc_html_e('Update this area from the Events section in WordPress admin.', 'football'); ?></p>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
