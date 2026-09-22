<section id="latest-event" class="academy-section academy-section--events">
    <div class="container">
        <div class="section-heading">
            <span class="section-kicker"><?php esc_html_e('Academy Newsroom', 'football'); ?></span>
            <h2><?php esc_html_e('Highlights and latest updates', 'football'); ?></h2>
            <p><?php esc_html_e('Watch the DuckSports Football Academy video playlist and follow academy notices, achievements, and training announcements.', 'football'); ?></p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="event-panel event-panel--media">
                    <div class="event-panel__header">
                        <h3><?php esc_html_e('Highlights', 'football'); ?></h3>
                        <span><?php esc_html_e('YouTube channel', 'football'); ?></span>
                    </div>

                    <div class="video-container video-container--playlist">
                        <div class="ratio ratio-16x9 academy-video academy-video--playlist">
                            <iframe
                                src="<?php echo esc_url(football_youtube_uploads_embed_url()); ?>"
                                title="<?php esc_attr_e('DuckSports Football Academy YouTube uploads', 'football'); ?>"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                                loading="lazy"></iframe>
                        </div>

                        <div class="youtube-channel-link">
                            <div>
                                <strong><?php esc_html_e('DuckSports Football Academy', 'football'); ?></strong>
                                <span><?php esc_html_e('All public uploads load directly from the official YouTube channel.', 'football'); ?></span>
                            </div>
                            <a href="<?php echo esc_url(football_youtube_channel_url()); ?>" target="_blank" rel="noopener">
                                <?php esc_html_e('Open channel', 'football'); ?>
                            </a>
                        </div>
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
                        $notice_items = array();

                        $notice_query = new WP_Query(
                            array(
                                'post_type'      => 'notice_board',
                                'posts_per_page' => 5,
                                'post_status'    => 'publish',
                                'orderby'        => array(
                                    'menu_order' => 'ASC',
                                    'date'       => 'DESC',
                                ),
                                'no_found_rows'  => true,
                            )
                        );

                        if ($notice_query->have_posts()) {
                            while ($notice_query->have_posts()) {
                                $notice_query->the_post();

                                $notice_description = football_get_field('notice_board_description', get_the_ID());
                                $description = $notice_description ?: (has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 22));
                                $notice_label = football_get_field('notice_board_label', get_the_ID());

                                $notice_items[] = array(
                                    'meta'        => $notice_label ?: get_the_date('M j, Y'),
                                    'datetime'    => $notice_label ? '' : get_the_date('c'),
                                    'title'       => get_the_title(),
                                    'description' => $description,
                                );
                            }

                            wp_reset_postdata();
                        }

                        if (empty($notice_items)) {
                            $update_query = new WP_Query(
                                array(
                                    'post_type'      => 'events',
                                    'posts_per_page' => 5,
                                    'post_status'    => 'publish',
                                    'order'          => 'DESC',
                                    'orderby'        => 'date',
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'event_type',
                                            'field'    => 'slug',
                                            'terms'    => 'latest-updates',
                                        ),
                                    ),
                                    'no_found_rows'  => true,
                                )
                            );

                            while ($update_query->have_posts()) {
                                $update_query->the_post();

                                $notice_items[] = array(
                                    'meta'        => get_the_date('M j, Y'),
                                    'datetime'    => get_the_date('c'),
                                    'title'       => get_the_title(),
                                    'description' => get_the_excerpt(),
                                );
                            }

                            wp_reset_postdata();
                        }

                        if (empty($notice_items)) {
                            $notice_items = array(
                                array(
                                    'meta'        => __('Admissions', 'football'),
                                    'datetime'    => '',
                                    'title'       => __('New student trial sessions are open for weekday and weekend batches.', 'football'),
                                    'description' => __('Add notices from the Notice Board section in WordPress admin.', 'football'),
                                ),
                                array(
                                    'meta'        => __('Training', 'football'),
                                    'datetime'    => '',
                                    'title'       => __('Skill development groups focus on ball mastery, passing speed, and finishing.', 'football'),
                                    'description' => __('Add notices from the Notice Board section in WordPress admin.', 'football'),
                                ),
                                array(
                                    'meta'        => __('Locations', 'football'),
                                    'datetime'    => '',
                                    'title'       => __('Academy locations are active in Faridabad, Delhi, and Dwarka.', 'football'),
                                    'description' => __('Add notices from the Notice Board section in WordPress admin.', 'football'),
                                ),
                            );
                        }

                        foreach ($notice_items as $notice_item) :
                            ?>
                            <li class="update-item">
                                <?php if (!empty($notice_item['datetime'])) : ?>
                                    <time class="update-item__meta" datetime="<?php echo esc_attr($notice_item['datetime']); ?>"><?php echo esc_html($notice_item['meta']); ?></time>
                                <?php else : ?>
                                    <span class="update-item__meta"><?php echo esc_html($notice_item['meta']); ?></span>
                                <?php endif; ?>
                                <strong><?php echo esc_html($notice_item['title']); ?></strong>
                                <?php if (!empty($notice_item['description'])) : ?>
                                    <p><?php echo esc_html($notice_item['description']); ?></p>
                                <?php endif; ?>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
