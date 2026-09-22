<?php
function football_enqueue_styles() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array('bootstrap-css'), filemtime(get_template_directory() . '/style.css'));

    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'football_enqueue_styles');

function football_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 96,
            'width'       => 280,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );
}
add_action('after_setup_theme', 'football_theme_setup');

function football_widgets_init() {
    register_sidebar(
        array(
            'name'          => __('Latest Updates', 'football'),
            'id'            => 'latest-updates',
            'before_widget' => '<div class="update-item">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="section-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'football_widgets_init');

function create_events_post_type() {
    register_post_type(
        'events',
        array(
            'labels'       => array(
                'name'          => __('Events', 'football'),
                'singular_name' => __('Event', 'football'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
            'menu_icon'    => 'dashicons-calendar-alt',
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'create_events_post_type');

function football_register_slider_post_type() {
    register_post_type(
        'custom_slider',
        array(
            'labels'       => array(
                'name'          => __('Hero Slides', 'football'),
                'singular_name' => __('Hero Slide', 'football'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'supports'     => array('title', 'thumbnail', 'custom-fields'),
            'menu_icon'    => 'dashicons-images-alt2',
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'football_register_slider_post_type');

function football_register_gallery_slide_post_type() {
    register_post_type(
        'gallery_slide',
        array(
            'labels'       => array(
                'name'          => __('Gallery Slides', 'football'),
                'singular_name' => __('Gallery Slide', 'football'),
                'add_new_item'  => __('Add New Gallery Slide', 'football'),
                'edit_item'     => __('Edit Gallery Slide', 'football'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'supports'     => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes'),
            'menu_icon'    => 'dashicons-format-gallery',
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'football_register_gallery_slide_post_type');

function football_register_notice_board_post_type() {
    register_post_type(
        'notice_board',
        array(
            'labels'       => array(
                'name'          => __('Notice Board', 'football'),
                'singular_name' => __('Notice', 'football'),
                'add_new_item'  => __('Add New Notice', 'football'),
                'edit_item'     => __('Edit Notice', 'football'),
            ),
            'public'              => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'supports'            => array('title', 'editor', 'excerpt', 'custom-fields', 'page-attributes'),
            'menu_icon'           => 'dashicons-megaphone',
            'show_in_rest'        => true,
        )
    );

    register_post_meta(
        'notice_board',
        'notice_board_label',
        array(
            'single'       => true,
            'type'         => 'string',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );

    register_post_meta(
        'notice_board',
        'notice_board_description',
        array(
            'single'       => true,
            'type'         => 'string',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
}
add_action('init', 'football_register_notice_board_post_type');

function football_register_training_program_post_type() {
    register_post_type(
        'training_program',
        array(
            'labels'       => array(
                'name'          => __('Training Programs', 'football'),
                'singular_name' => __('Training Program', 'football'),
                'add_new_item'  => __('Add New Training Program', 'football'),
                'edit_item'     => __('Edit Training Program', 'football'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'supports'     => array('title', 'editor', 'excerpt', 'custom-fields', 'page-attributes'),
            'menu_icon'    => 'dashicons-welcome-learn-more',
            'show_in_rest' => true,
        )
    );

    register_post_meta(
        'training_program',
        'training_program_label',
        array(
            'single'       => true,
            'type'         => 'string',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );

    register_post_meta(
        'training_program',
        'training_program_description',
        array(
            'single'       => true,
            'type'         => 'string',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );

    register_post_meta(
        'training_program',
        'training_program_featured',
        array(
            'single'       => true,
            'type'         => 'boolean',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
}
add_action('init', 'football_register_training_program_post_type');

function football_default_training_programs() {
    return array(
        array(
            'label'       => __('U-8 to U-11', 'football'),
            'title'       => __('Foundation Training', 'football'),
            'description' => __('First touch, passing habits, coordination, balance, and joy on the ball.', 'football'),
            'featured'    => false,
        ),
        array(
            'label'       => __('U-12 to U-15', 'football'),
            'title'       => __('Skill Development', 'football'),
            'description' => __('Dribbling under pressure, positional play, finishing, defensive shape, and team play.', 'football'),
            'featured'    => true,
        ),
        array(
            'label'       => '',
            'title'       => __('Match Preparation', 'football'),
            'description' => __('Game intelligence, speed endurance, set-piece discipline, and tournament readiness.', 'football'),
            'featured'    => false,
        ),
    );
}

function football_training_pathway_heading_defaults() {
    return array(
        'kicker'      => __('Training Pathway', 'football'),
        'title'       => __('Programs for every stage of a player journey', 'football'),
        'description' => __('A clear development pathway helps players build technique first, then pressure handling, decision-making, and match rhythm.', 'football'),
    );
}

function football_get_training_pathway_heading() {
    $defaults = football_training_pathway_heading_defaults();

    return array(
        'kicker'      => get_theme_mod('football_training_pathway_kicker', $defaults['kicker']),
        'title'       => get_theme_mod('football_training_pathway_title', $defaults['title']),
        'description' => get_theme_mod('football_training_pathway_description', $defaults['description']),
    );
}

function football_training_pathway_customize_register($wp_customize) {
    $defaults = football_training_pathway_heading_defaults();

    $wp_customize->add_section(
        'football_training_pathway_section',
        array(
            'title'       => __('Training Pathway', 'football'),
            'description' => __('Edit the homepage Training Pathway heading. Program cards are managed from Training Programs in the dashboard.', 'football'),
            'priority'    => 35,
        )
    );

    $wp_customize->add_setting(
        'football_training_pathway_kicker',
        array(
            'default'           => $defaults['kicker'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'football_training_pathway_kicker',
        array(
            'label'   => __('Small Heading', 'football'),
            'section' => 'football_training_pathway_section',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'football_training_pathway_title',
        array(
            'default'           => $defaults['title'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'football_training_pathway_title',
        array(
            'label'   => __('Main Heading', 'football'),
            'section' => 'football_training_pathway_section',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'football_training_pathway_description',
        array(
            'default'           => $defaults['description'],
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'football_training_pathway_description',
        array(
            'label'   => __('Description', 'football'),
            'section' => 'football_training_pathway_section',
            'type'    => 'textarea',
        )
    );
}
add_action('customize_register', 'football_training_pathway_customize_register');

function football_payment_customize_register($wp_customize) {
    $wp_customize->add_section(
        'football_payment_section',
        array(
            'title'       => __('Registration & Payment Settings', 'football'),
            'description' => __('Manage the UPI ID and payment settings for online student registrations.', 'football'),
            'priority'    => 36,
        )
    );

    $wp_customize->add_setting(
        'football_registration_upi_id',
        array(
            'default'           => 'karmeshu.kaushik@icici',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'football_registration_upi_id',
        array(
            'label'       => __('UPI ID for Payment', 'football'),
            'description' => __('Enter the UPI ID (e.g. yourname@upi, 9821440038@paytm) used to generate the Rs. 500 QR code.', 'football'),
            'section'     => 'football_payment_section',
            'type'        => 'text',
        )
    );
}
add_action('customize_register', 'football_payment_customize_register');

function football_register_student_registration_post_type() {
    register_post_type(
        'student_registration',
        array(
            'labels'          => array(
                'name'          => __('Student Registrations', 'football'),
                'singular_name' => __('Student Registration', 'football'),
            ),
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'show_in_rest'    => false,
            'supports'        => array('title'),
            'menu_icon'       => 'dashicons-clipboard',
            'capability_type' => 'post',
        )
    );
}
add_action('init', 'football_register_student_registration_post_type');

function register_event_type_taxonomy() {
    register_taxonomy(
        'event_type',
        'events',
        array(
            'label'        => __('Event Type', 'football'),
            'rewrite'      => array('slug' => 'event-type'),
            'hierarchical' => true,
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'register_event_type_taxonomy');

function football_register_menus() {
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'football'),
        )
    );
}
add_action('init', 'football_register_menus');

function football_get_field($selector, $post_id = false, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id);

        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }
    }

    if ($post_id) {
        $value = get_post_meta($post_id, $selector, true);

        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }
    }

    return $default;
}

function football_registration_url() {
    $page = get_page_by_path('online-regisration');

    if (!$page) {
        $page = get_page_by_path('online-registration');
    }

    return $page ? get_permalink($page) : home_url('/#contact');
}

function football_maybe_create_registration_page() {
    if (get_page_by_path('online-registration') || get_page_by_path('online-regisration')) {
        return;
    }

    wp_insert_post(
        array(
            'post_title'   => __('Online Registration', 'football'),
            'post_name'    => 'online-regisration',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        )
    );
}
add_action('init', 'football_maybe_create_registration_page', 20);

function football_registration_school_options() {
    return array(
        '',
        'The Shree Jee School, Lakewood City, Surajkund Road, Faridabad',
        'KL Mehta Dayanand Public School, Sector 17, Faridabad',
        'Pt. Yadram Public School, Bhajanpura, Delhi',
        'Dwarka Sector 2, Mahalaxmi Apartments',
        'Other',
    );
}

function football_registration_age_groups() {
    return array('', 'U-8', 'U-10', 'U-12', 'U-14', 'U-17', 'Open');
}

function football_registration_nationalities() {
    return array('', 'Indian', 'Other');
}

function football_registration_upload_fields() {
    return array(
        'passport_photo'     => __('Passport Size Photo', 'football'),
        'parent_aadhar'      => __('Parent Aadhar', 'football'),
        'student_id_proof'   => __('Student ID Proof', 'football'),
        'guardian_signature' => __('Signature of Guardian', 'football'),
    );
}

function football_render_select_options($options, $placeholder) {
    foreach ($options as $option) {
        if ($option === '') {
            printf('<option value="">%s</option>', esc_html($placeholder));
            continue;
        }

        printf('<option value="%1$s">%1$s</option>', esc_attr($option));
    }
}

function football_render_registration_form() {
    $page_id = get_queried_object_id();
    $upi_id = get_theme_mod('football_registration_upi_id') ?: football_get_field('registration_upi_id', $page_id, 'karmeshu.kaushik@icici');
    $qr_image = football_image_url(football_get_field('registration_qr_image', $page_id));
    $upi_pay_url = 'upi://pay?' . http_build_query(array(
        'pa' => $upi_id,
        'pn' => get_bloginfo('name'),
        'am' => '500',
        'cu' => 'INR',
        'tn' => 'Registration Fee',
    ));
    if (empty($qr_image)) {
        $qr_image = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . rawurlencode($upi_pay_url);
    }
    $redirect_url = get_permalink($page_id) ?: football_registration_url();
    $message = '';

    if (isset($_GET['registration']) || isset($_GET['ack']) || isset($_GET['view_receipt'])) {
        $status = isset($_GET['registration']) ? sanitize_key(wp_unslash($_GET['registration'])) : 'success';
        $ack_param = isset($_GET['ack']) ? sanitize_text_field(wp_unslash($_GET['ack'])) : (isset($_GET['view_receipt']) ? sanitize_text_field(wp_unslash($_GET['view_receipt'])) : '');

        if ($status === 'success') {
            if ($ack_param !== '') {
                $message = football_render_student_receipt_card($ack_param);
            } else {
                $message = '<div class="registration-alert registration-alert--success"><p>' . esc_html__('Thank you. Your registration has been submitted successfully.', 'football') . '</p></div>';
            }
        } elseif ($status === 'error') {
            $message = '<div class="registration-alert registration-alert--error">' . esc_html__('Please check all required fields and try again.', 'football') . '</div>';
        }
    }

    ob_start();
    ?>
    <section id="registration-form" class="registration-section">
        <?php echo wp_kses_post($message); ?>

        <form class="student-registration-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('football_student_registration', 'football_registration_nonce'); ?>
            <input type="hidden" name="action" value="football_student_registration">
            <input type="hidden" name="football_registration_redirect" value="<?php echo esc_url($redirect_url); ?>">

            <div class="registration-grid">
                <label>
                    <span><?php esc_html_e("Student's Name", 'football'); ?> <strong>*</strong></span>
                    <input type="text" name="student_name" required>
                </label>

                <label>
                    <span><?php esc_html_e('Date of Birth', 'football'); ?> <strong>*</strong></span>
                    <input type="date" name="date_of_birth" required>
                </label>

                <label>
                    <span><?php esc_html_e("Guardian's Name", 'football'); ?> <strong>*</strong></span>
                    <input type="text" name="guardian_name" required>
                </label>

                <label>
                    <span><?php esc_html_e('Mobile No.', 'football'); ?> <strong>*</strong></span>
                    <input type="tel" name="mobile_no" inputmode="tel" required>
                </label>

                <label>
                    <span><?php esc_html_e('Select School', 'football'); ?></span>
                    <select name="school">
                        <?php football_render_select_options(football_registration_school_options(), __('Select School', 'football')); ?>
                    </select>
                </label>

                <label>
                    <span><?php esc_html_e('Email', 'football'); ?> <strong>*</strong></span>
                    <input type="email" name="email" required>
                </label>

                <label class="registration-field--wide">
                    <span><?php esc_html_e('Address', 'football'); ?> <strong>*</strong></span>
                    <textarea name="address" rows="4" required></textarea>
                </label>

                <label>
                    <span><?php esc_html_e('Age Group', 'football'); ?> <strong>*</strong></span>
                    <select name="age_group" required>
                        <?php football_render_select_options(football_registration_age_groups(), __('Select Age Group', 'football')); ?>
                    </select>
                </label>

                <label>
                    <span><?php esc_html_e('Nationality', 'football'); ?> <strong>*</strong></span>
                    <select name="nationality" required>
                        <?php football_render_select_options(football_registration_nationalities(), __('Select Nationality', 'football')); ?>
                    </select>
                </label>
            </div>

            <div class="registration-upload-grid">
                <?php foreach (football_registration_upload_fields() as $field_name => $field_label) : ?>
                    <label>
                        <span><?php echo esc_html($field_label); ?> <strong>*</strong></span>
                        <input type="file" name="<?php echo esc_attr($field_name); ?>" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="registration-payment">
                <div>
                    <span class="section-kicker"><?php esc_html_e('One Time Registration Fee Rs. 500/-', 'football'); ?> *</span>
                    <h2><?php esc_html_e('Complete payment before submitting', 'football'); ?></h2>
                    <p><?php esc_html_e('Pay via UPI / Google Pay / Paytm / PhonePe by scanning the QR code or using the UPI ID below.', 'football'); ?></p>
                    <p class="registration-payment__upi"><?php esc_html_e('UPI ID:', 'football'); ?> <strong><?php echo esc_html($upi_id); ?></strong></p>
                    <div class="mt-2">
                        <a href="<?php echo esc_url($upi_pay_url); ?>" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/><path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                            <?php esc_html_e('Pay Rs. 500 via UPI App', 'football'); ?>
                        </a>
                    </div>
                </div>

                <div class="registration-payment__qr">
                    <img src="<?php echo esc_url($qr_image); ?>" alt="<?php esc_attr_e('UPI QR Code for Rs 500 Payment', 'football'); ?>">
                    <small class="d-block mt-1 text-muted" style="font-size:0.75rem; font-weight:600;"><?php esc_html_e('Scan to Pay Rs. 500', 'football'); ?></small>
                </div>
            </div>

            <div class="registration-grid">
                <label class="registration-field--wide">
                    <span><?php esc_html_e('UPI Transaction ID / Reference No.', 'football'); ?> <strong>*</strong></span>
                    <input type="text" name="payment_reference" required>
                </label>
            </div>

            <div class="registration-terms">
                <h2><?php esc_html_e('Terms and Conditions', 'football'); ?></h2>
                <p><?php esc_html_e('By registering for and participating in our programs, you acknowledge and agree to the following:', 'football'); ?></p>

                <div class="registration-terms__grid">
                    <article>
                        <h3><?php esc_html_e('Advance Payment', 'football'); ?></h3>
                        <p><?php esc_html_e('All monthly fees must be paid in advance. Access to sessions will be granted only upon full payment.', 'football'); ?></p>
                    </article>

                    <article>
                        <h3><?php esc_html_e('Missed Sessions', 'football'); ?></h3>
                        <p><?php esc_html_e('No make-up classes, credits, or refunds will be provided for missed sessions, regardless of the reason.', 'football'); ?></p>
                    </article>

                    <article>
                        <h3><?php esc_html_e('Assumption of Risk', 'football'); ?></h3>
                        <p><?php esc_html_e('Parents/guardians confirm that the participant is physically fit and capable of participating in all sporting and fitness activities. Participation is at your own risk, and we accept no liability for any injury, including serious or fatal injuries, that may occur.', 'football'); ?></p>
                    </article>

                    <article>
                        <h3><?php esc_html_e('Health Declaration', 'football'); ?></h3>
                        <p><?php esc_html_e('Parents/guardians declare that the participant has no known physical or mental condition that would prevent safe participation in the activities offered.', 'football'); ?></p>
                    </article>
                </div>

                <p class="registration-terms__closing"><?php esc_html_e('By continuing with registration, you agree to the terms of this disclaimer.', 'football'); ?></p>
            </div>

            <label class="registration-consent">
                <input type="checkbox" name="terms_agreed" value="1" required>
                <span><?php esc_html_e('I agree to the Terms and Conditions', 'football'); ?></span>
            </label>

            <input class="registration-hp" type="text" name="registration_website" tabindex="-1" autocomplete="off">

            <button type="submit" class="btn btn-registration registration-submit">
                <?php esc_html_e('Submit', 'football'); ?>
            </button>
        </form>
    </section>
    <?php
    return ob_get_clean();
}

function football_registration_form_shortcode() {
    return football_render_registration_form();
}
add_shortcode('football_registration_form', 'football_registration_form_shortcode');

function football_registration_redirect_with_status($status, $extra_args = array()) {
    $redirect = isset($_POST['football_registration_redirect']) ? esc_url_raw(wp_unslash($_POST['football_registration_redirect'])) : football_registration_url();
    $redirect = remove_query_arg(array('registration', 'ack'), $redirect);
    $args = array_merge(array('registration' => $status), $extra_args);

    wp_safe_redirect(add_query_arg($args, $redirect) . '#registration-form');
    exit;
}

function football_generate_acknowledgement_number($post_id) {
    return sprintf('FDS-%s-%06d', current_time('Ymd'), (int) $post_id);
}

function football_get_acknowledgement_pdf_url($acknowledgement_no) {
    if ($acknowledgement_no === '') {
        return '';
    }

    $registrations = get_posts(
        array(
            'post_type'        => 'student_registration',
            'post_status'      => 'private',
            'posts_per_page'   => 1,
            'fields'           => 'ids',
            'meta_key'         => 'acknowledgement_no',
            'meta_value'       => $acknowledgement_no,
            'suppress_filters' => true,
        )
    );

    if (empty($registrations)) {
        return '';
    }

    return (string) get_post_meta((int) $registrations[0], 'acknowledgement_pdf_url', true);
}

function football_get_registration_by_ack($acknowledgement_no) {
    if (empty($acknowledgement_no)) return null;
    $registrations = get_posts(
        array(
            'post_type'        => 'student_registration',
            'post_status'      => 'private',
            'posts_per_page'   => 1,
            'meta_key'         => 'acknowledgement_no',
            'meta_value'       => $acknowledgement_no,
            'suppress_filters' => true,
        )
    );
    return !empty($registrations) ? $registrations[0] : null;
}

function football_render_student_receipt_card($acknowledgement_no) {
    $post = football_get_registration_by_ack($acknowledgement_no);
    if (!$post) {
        return '<div class="registration-alert registration-alert--error">' . esc_html__('Registration record not found.', 'football') . '</div>';
    }

    $post_id = $post->ID;
    $student_name      = get_post_meta($post_id, 'student_name', true);
    $date_of_birth     = get_post_meta($post_id, 'date_of_birth', true);
    $guardian_name     = get_post_meta($post_id, 'guardian_name', true);
    $mobile_no         = get_post_meta($post_id, 'mobile_no', true);
    $school            = get_post_meta($post_id, 'school', true);
    $address           = get_post_meta($post_id, 'address', true);
    $email             = get_post_meta($post_id, 'email', true);
    $age_group         = get_post_meta($post_id, 'age_group', true);
    $nationality       = get_post_meta($post_id, 'nationality', true);
    $payment_reference = get_post_meta($post_id, 'payment_reference', true);
    $registration_fee  = get_post_meta($post_id, 'registration_fee', true) ?: 'Rs. 500/-';

    $photo_id          = get_post_meta($post_id, 'passport_photo', true);
    $signature_id      = get_post_meta($post_id, 'guardian_signature', true);

    $passport_photo_url     = $photo_id ? wp_get_attachment_url((int)$photo_id) : '';
    $guardian_signature_url = $signature_id ? wp_get_attachment_url((int)$signature_id) : '';
    $pdf_url                = football_get_acknowledgement_pdf_url($acknowledgement_no);

    ob_start();
    ?>
    <div class="academy-receipt-card" id="printable-receipt">
        <div class="receipt-card__header">
            <div class="receipt-card__brand">
                <img src="<?php echo esc_url(content_url('/uploads/2026/08/logo.png')); ?>" alt="Football Ducks Sports Logo" class="receipt-logo-img">
                <div>
                    <h2><?php bloginfo('name'); ?></h2>
                    <p><?php esc_html_e('Official Student Registration Receipt & Admission Slip', 'football'); ?></p>
                </div>
            </div>
            <div class="receipt-card__status-badge">
                <span class="badge-status"><?php esc_html_e('PAID & REGISTERED', 'football'); ?></span>
                <small><?php printf(esc_html__('Fee: %s', 'football'), esc_html($registration_fee)); ?></small>
            </div>
        </div>

        <div class="receipt-card__meta">
            <div class="meta-item">
                <span class="meta-label"><?php esc_html_e('ACKNOWLEDGEMENT NO.', 'football'); ?></span>
                <strong class="meta-ack"><?php echo esc_html($acknowledgement_no); ?></strong>
            </div>
            <div class="meta-item">
                <span class="meta-label"><?php esc_html_e('REGISTRATION DATE', 'football'); ?></span>
                <span class="meta-val"><?php echo esc_html(get_the_date('d M Y, h:i A', $post_id)); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><?php esc_html_e('UPI / PAYMENT REF', 'football'); ?></span>
                <span class="meta-val"><?php echo esc_html($payment_reference); ?></span>
            </div>
        </div>

        <div class="receipt-card__body">
            <div class="receipt-card__photo-col">
                <div class="receipt-photo-frame">
                    <?php if ($passport_photo_url) : ?>
                        <img src="<?php echo esc_url($passport_photo_url); ?>" alt="<?php echo esc_attr($student_name); ?>" class="student-passport-img">
                    <?php else : ?>
                        <div class="student-photo-placeholder">
                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>
                            <span><?php esc_html_e('Photo Uploaded', 'football'); ?></span>
                        </div>
                    <?php endif; ?>
                    <span class="photo-caption"><?php esc_html_e('Student Passport Photo', 'football'); ?></span>
                </div>
            </div>

            <div class="receipt-card__details-col">
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e("Student's Name", 'football'); ?></span>
                        <strong class="d-val"><?php echo esc_html($student_name); ?></strong>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('Date of Birth', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($date_of_birth); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('Age Category', 'football'); ?></span>
                        <strong class="d-val highlight-val"><?php echo esc_html($age_group); ?></strong>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e("Guardian's Name", 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($guardian_name); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('Mobile No.', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($mobile_no); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('Email Address', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($email); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('School / Centre', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($school ?: __('Not specified', 'football')); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="d-label"><?php esc_html_e('Nationality', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($nationality); ?></span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="d-label"><?php esc_html_e('Address', 'football'); ?></span>
                        <span class="d-val"><?php echo esc_html($address); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="receipt-card__footer">
            <div class="signatures-row">
                <div class="sig-box">
                    <?php if ($guardian_signature_url) : ?>
                        <img src="<?php echo esc_url($guardian_signature_url); ?>" alt="Guardian Signature" class="sig-img">
                    <?php else : ?>
                        <div class="sig-line"></div>
                    <?php endif; ?>
                    <span><?php esc_html_e("Guardian's Signature", 'football'); ?></span>
                </div>
                <div class="sig-box text-end">
                    <div class="academy-seal-badge">
                        <strong>FDS ACADEMY</strong>
                        <small>VERIFIED & APPROVED</small>
                    </div>
                    <span><?php esc_html_e('Authorized Signatory', 'football'); ?></span>
                </div>
            </div>
            <p class="receipt-disclaimer"><?php esc_html_e('Official computer-generated receipt from Football Ducks Sports Academy. The student/guardian has accepted all academy terms, conditions, health declarations, and disclaimers online.', 'football'); ?></p>
        </div>

        <div class="receipt-card__actions no-print">
            <button type="button" class="btn btn-receipt-print" onclick="window.print();">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg>
                <?php esc_html_e('Print Receipt / Slip', 'football'); ?>
            </button>
            <?php if ($pdf_url) : ?>
                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener" class="btn btn-receipt-download">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                    <?php esc_html_e('Download PDF Receipt', 'football'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function football_registration_terms_for_acknowledgement() {
    return array(
        'Advance Payment'     => 'All monthly fees must be paid in advance. Access to sessions will be granted only upon full payment.',
        'Missed Sessions'     => 'No make-up classes, credits, or refunds will be provided for missed sessions, regardless of the reason.',
        'Assumption of Risk'  => 'Parents/guardians confirm that the participant is physically fit and capable of participating in all sporting and fitness activities. Participation is at your own risk, and we accept no liability for any injury, including serious or fatal injuries, that may occur.',
        'Health Declaration'  => 'Parents/guardians declare that the participant has no known physical or mental condition that would prevent safe participation in the activities offered.',
        'Disclaimer Accepted' => 'By continuing with registration, you agree to the terms of this disclaimer.',
    );
}

function football_pdf_clean_text($text) {
    $text = wp_strip_all_tags(html_entity_decode((string) $text, ENT_QUOTES, 'UTF-8'));
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim((string) $text);

    if (function_exists('iconv')) {
        $converted = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);

        if ($converted !== false) {
            $text = $converted;
        }
    }

    return $text;
}

function football_pdf_escape_text($text) {
    $text = football_pdf_clean_text($text);
    return str_replace(array('\\', '(', ')'), array('\\\\', '\\(', '\\)'), $text);
}

function football_pdf_wrap_lines($text, $max_width, $font_size) {
    $text = football_pdf_clean_text($text);
    $max_chars = max(18, (int) floor($max_width / max(4.8, $font_size * 0.52)));
    return explode("\n", wordwrap($text, $max_chars, "\n", true));
}

function football_get_image_jpeg_data($attachment_id_or_path, $target_w = 240, $target_h = 300, $bg_color = array(255, 255, 255)) {
    if (empty($attachment_id_or_path)) {
        return null;
    }

    $file_path = '';
    if (is_numeric($attachment_id_or_path)) {
        $file_path = get_attached_file((int) $attachment_id_or_path);
    } else {
        $file_path = (string) $attachment_id_or_path;
        if (strpos($file_path, 'http://') === 0 || strpos($file_path, 'https://') === 0) {
            $att_id = attachment_url_to_postid($file_path);
            if ($att_id) {
                $file_path = get_attached_file($att_id);
            } else {
                $uploads = wp_upload_dir();
                if (!empty($uploads['baseurl']) && strpos($file_path, $uploads['baseurl']) === 0) {
                    $file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $file_path);
                }
            }
        }
    }

    if (empty($file_path) || !file_exists($file_path)) {
        return null;
    }

    $image_info = @getimagesize($file_path);
    if (!$image_info) {
        return null;
    }

    $mime = $image_info[2];
    $src_img = null;

    if ($mime === IMAGETYPE_JPEG) {
        $src_img = @imagecreatefromjpeg($file_path);
    } elseif ($mime === IMAGETYPE_PNG) {
        $src_img = @imagecreatefrompng($file_path);
    } elseif (function_exists('imagecreatefromwebp') && $mime === IMAGETYPE_WEBP) {
        $src_img = @imagecreatefromwebp($file_path);
    }

    if (!$src_img) {
        return null;
    }

    $orig_w = imagesx($src_img);
    $orig_h = imagesy($src_img);

    $dst_img = imagecreatetruecolor($target_w, $target_h);
    $bg_r = isset($bg_color[0]) ? (int) $bg_color[0] : 255;
    $bg_g = isset($bg_color[1]) ? (int) $bg_color[1] : 255;
    $bg_b = isset($bg_color[2]) ? (int) $bg_color[2] : 255;
    $fill_color = imagecolorallocate($dst_img, $bg_r, $bg_g, $bg_b);
    imagefill($dst_img, 0, 0, $fill_color);

    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $target_w, $target_h, $orig_w, $orig_h);

    ob_start();
    imagejpeg($dst_img, null, 92);
    $jpeg_bytes = ob_get_clean();

    imagedestroy($src_img);
    imagedestroy($dst_img);

    return array(
        'data'   => $jpeg_bytes,
        'width'  => $target_w,
        'height' => $target_h,
    );
}

function football_build_acknowledgement_pdf($data, $acknowledgement_no) {
    $pages = array(array());
    $page_index = 0;
    $images = array();
    $left = 48;
    $right = 547;
    $width = $right - $left;

    $post_id = isset($data['post_id']) ? (int) $data['post_id'] : 0;
    $photo_id = $post_id ? get_post_meta($post_id, 'passport_photo', true) : 0;
    $signature_id = $post_id ? get_post_meta($post_id, 'guardian_signature', true) : 0;

    if (empty($photo_id) && !empty($data['passport_photo'])) {
        $photo_id = $data['passport_photo'];
    }
    if (empty($signature_id) && !empty($data['guardian_signature'])) {
        $signature_id = $data['guardian_signature'];
    }

    if ($photo_id) {
        $photo_jpeg = football_get_image_jpeg_data($photo_id, 240, 300, array(255, 255, 255));
        if ($photo_jpeg) {
            $images['ImPhoto'] = $photo_jpeg;
        }
    }

    if ($signature_id) {
        $sig_jpeg = football_get_image_jpeg_data($signature_id, 280, 80, array(255, 255, 255));
        if ($sig_jpeg) {
            $images['ImSig'] = $sig_jpeg;
        }
    }

    $logo_path = ABSPATH . 'wp-content/uploads/2026/08/logo.png';
    if (!file_exists($logo_path)) {
        $logo_path = ABSPATH . 'wp-content/uploads/2026/08/logo-white.png';
    }
    if (file_exists($logo_path)) {
        $logo_jpeg = football_get_image_jpeg_data($logo_path, 400, 195, array(255, 255, 255));
        if ($logo_jpeg) {
            $images['ImLogo'] = $logo_jpeg;
        }
    }

    $add_command = function ($command) use (&$pages, &$page_index) {
        $pages[$page_index][] = $command;
    };

    $fill_rect = function ($x, $rect_y, $rect_width, $rect_height, $color) use ($add_command) {
        $add_command(sprintf('q %s rg %.2F %.2F %.2F %.2F re f Q', $color, $x, $rect_y, $rect_width, $rect_height));
    };

    $stroke_rect = function ($x, $rect_y, $rect_width, $rect_height, $color = '0.82 0.88 0.84', $line_width = 1) use ($add_command) {
        $add_command(sprintf('q %.2F w %s RG %.2F %.2F %.2F %.2F re S Q', $line_width, $color, $x, $rect_y, $rect_width, $rect_height));
    };

    $line = function ($x1, $y1, $x2, $y2, $color = '0.82 0.88 0.84', $line_width = 1) use ($add_command) {
        $add_command(sprintf('q %.2F w %s RG %.2F %.2F m %.2F %.2F l S Q', $line_width, $color, $x1, $y1, $x2, $y2));
    };

    $text_at = function ($value, $x, $text_y, $size = 10, $font = 'F1', $color = '0 0 0') use ($add_command) {
        $add_command(sprintf('BT /%s %s Tf %s rg %.2F %.2F Td (%s) Tj ET', $font, $size, $color, $x, $text_y, football_pdf_escape_text($value)));
    };

    $wrapped_text_at = function ($value, $x, $start_y, $max_width, $size = 10, $font = 'F1', $line_height = 11.5, $color = '0 0 0') use ($text_at) {
        $current_y = $start_y;

        foreach (football_pdf_wrap_lines($value, $max_width, $size) as $text_line) {
            $text_at($text_line, $x, $current_y, $size, $font, $color);
            $current_y -= $line_height;
        }

        return $current_y;
    };

    $draw_page_shell = function ($page_label) use ($left, $right, $width, $fill_rect, $stroke_rect, $line, $text_at, $add_command, $images) {
        $fill_rect(0, 0, 595, 842, '0.98 0.96 0.97');
        $fill_rect($left, 748, $width, 58, '0.38 0.11 0.29');
        $fill_rect($left, 742, $width, 6, '1 0.92 0.72');
        $stroke_rect($left, 45, $width, 761, '0.90 0.80 0.85', 1.1);

        if (isset($images['ImLogo'])) {
            $fill_rect($left + 5, 753, 90, 48, '1 1 1');
            $stroke_rect($left + 5, 753, 90, 48, '1 0.92 0.72', 1.2);
            $add_command('q 82 0 0 40 57 757 cm /ImLogo Do Q');
            $text_at('Football Ducks Sports Academy', 150, 782, 14.5, 'F2', '1 1 1');
            $text_at('Official Registration Receipt & Student Admission Slip', 150, 764, 8.5, 'F1', '0.98 0.92 0.95');
        } else {
            $fill_rect(64, 762, 30, 30, '1 0.92 0.72');
            $text_at('FD', 70, 772, 11, 'F2', '0.38 0.11 0.29');
            $text_at('Football Ducks Sports Academy', 106, 782, 16, 'F2', '1 1 1');
            $text_at('Official Online Registration Acknowledgement', 106, 764, 9, 'F1', '0.98 0.92 0.95');
        }

        $text_at($page_label, 461, 773, 10, 'F2', '1 1 1');

        $line($left, 62, $right, 62, '0.90 0.80 0.85', 1);
        $text_at('Computer generated receipt. Valid for academy batches and training entry.', $left, 49, 8, 'F1', '0.42 0.29 0.36');
        $text_at('football.ducksports@gmail.com | +91 98214 40038', 337, 49, 8, 'F1', '0.42 0.29 0.36');
    };

    $section_heading = function ($title, $heading_y) use ($left, $fill_rect, $text_at) {
        $fill_rect($left, $heading_y - 4, 499, 21, '0.96 0.91 0.93');
        $fill_rect($left, $heading_y - 4, 4, 21, '0.38 0.11 0.29');
        $text_at($title, $left + 14, $heading_y + 3, 10, 'F2', '0.38 0.11 0.29');
    };

    $detail_row = function ($label, $value, $row_y, $row_height = 24, $full_width_val = 325) use ($left, $fill_rect, $stroke_rect, $text_at, $wrapped_text_at) {
        $value = (string) ($value !== '' ? $value : 'Not provided');
        $total_w = isset($full_width_val) && $full_width_val < 300 ? 368 : 499;
        $val_max_w = isset($full_width_val) && $full_width_val < 300 ? 200 : 325;
        $fill_rect($left, $row_y, 146, $row_height, '0.98 0.95 0.96');
        $stroke_rect($left, $row_y, $total_w, $row_height, '0.90 0.84 0.87', 0.6);
        $text_at($label, $left + 12, $row_y + $row_height - 16, 8.5, 'F2', '0.38 0.11 0.29');
        $wrapped_text_at($value, $left + 160, $row_y + $row_height - 15, $val_max_w, 8.8, 'F1', 10.5, '0.18 0.04 0.14');
    };

    $draw_page_shell('RECEIPT');

    // Acknowledgement & Fee Strip
    $fill_rect($left, 676, 499, 52, '1 1 1');
    $stroke_rect($left, 676, 499, 52, '0.90 0.80 0.85', 0.8);
    $text_at('Acknowledgement No.', $left + 16, 708, 8, 'F2', '0.42 0.29 0.36');
    $text_at($acknowledgement_no, $left + 16, 688, 15, 'F2', '0.38 0.11 0.29');
    $text_at('Submitted On', 236, 708, 8, 'F2', '0.42 0.29 0.36');
    $text_at(current_time('d M Y, h:i A'), 236, 690, 9, 'F2', '0.18 0.04 0.14');

    $fill_rect(370, 682, 85, 40, '0.38 0.11 0.29');
    $text_at('REG. FEE', 382, 706, 7.5, 'F2', '0.98 0.92 0.95');
    $text_at('Rs. 500/-', $left + 330, 690, 11.5, 'F2', '1 1 1');

    $fill_rect(460, 682, 80, 40, '1 0.92 0.72');
    $text_at('STATUS', 478, 706, 7.5, 'F2', '0.38 0.11 0.29');
    $text_at('VERIFIED', 467, 690, 10.5, 'F2', '0.38 0.11 0.29');

    $section_heading('Student Profile & Registration Details', 648);

    // Passport Photo Frame on Right
    $stroke_rect(424, 476, 123, 146, '0.38 0.11 0.29', 1.2);
    $fill_rect(424, 476, 123, 146, '1 1 1');

    if (isset($images['ImPhoto'])) {
        $add_command('q 117 0 0 140 427 479 cm /ImPhoto Do Q');
    } else {
        $fill_rect(427, 479, 117, 140, '0.96 0.91 0.93');
        $text_at('[ PASSPORT PHOTO ]', 432, 550, 7.5, 'F2', '0.38 0.11 0.29');
        $text_at('Uploaded Online', 440, 535, 7, 'F1', '0.42 0.29 0.36');
    }

    $fill_rect(424, 461, 123, 15, '0.38 0.11 0.29');
    $text_at('STUDENT PHOTO', 440, 465, 6.5, 'F2', '1 1 1');

    $rows = array(
        array("Student's Name", $data['student_name'] ?? '', 606, 24, 200),
        array('Date of Birth', $data['date_of_birth'] ?? '', 580, 24, 200),
        array("Guardian's Name", $data['guardian_name'] ?? '', 554, 24, 200),
        array('Mobile No.', $data['mobile_no'] ?? '', 528, 24, 200),
        array('Email', $data['email'] ?? '', 502, 24, 200),
        array('Age Category', $data['age_group'] ?? '', 476, 24, 200),
        array('Nationality', $data['nationality'] ?? '', 450, 24, 200),
        array('School / Centre', $data['school'] ?? '', 414, 34, 325),
        array('Residential Address', $data['address'] ?? '', 364, 48, 325),
        array('Payment Reference ID', $data['payment_reference'] ?? '', 336, 26, 325),
    );

    foreach ($rows as $row) {
        $detail_row($row[0], $row[1], $row[2], $row[3], $row[4]);
    }

    $section_heading('Terms Accepted & Academy Verification', 312);

    // Terms Summary Box
    $fill_rect($left, 218, 499, 82, '1 1 1');
    $stroke_rect($left, 218, 499, 82, '0.90 0.84 0.87', 0.8);
    $text_at('Online Terms & Health Declaration Summary', $left + 14, 284, 9, 'F2', '0.38 0.11 0.29');
    $wrapped_text_at('1. All monthly fees must be paid in advance prior to attending training sessions.', $left + 14, 270, 470, 7.8, 'F1', 9.5, '0.30 0.20 0.25');
    $wrapped_text_at('2. No make-up classes, refunds or fee roll-overs are provided for missed sessions.', $left + 14, 256, 470, 7.8, 'F1', 9.5, '0.30 0.20 0.25');
    $wrapped_text_at('3. Parent/guardian confirms the student is physically fit for athletic participation at their own risk.', $left + 14, 242, 470, 7.8, 'F1', 9.5, '0.30 0.20 0.25');
    $wrapped_text_at('4. Accepted electronically with online registration acknowledgement number ' . $acknowledgement_no . '.', $left + 14, 226, 470, 8, 'F2', 9.5, '0.38 0.11 0.29');

    // Signatures & Official Seal Box
    $fill_rect($left, 114, 499, 92, '0.96 0.91 0.93');
    $stroke_rect($left, 114, 499, 92, '0.90 0.80 0.85', 0.8);

    $text_at('Guardian Signature:', $left + 16, 188, 8.5, 'F2', '0.38 0.11 0.29');

    if (isset($images['ImSig'])) {
        $fill_rect($left + 16, 134, 140, 44, '1 1 1');
        $stroke_rect($left + 16, 134, 140, 44, '0.90 0.80 0.85', 0.6);
        $add_command('q 136 0 0 40 66 136 cm /ImSig Do Q');
        $text_at('Electronically Signed', $left + 16, 120, 7.5, 'F1', '0.42 0.29 0.36');
    } else {
        $text_at('Accepted Online', $left + 16, 160, 10.5, 'F2', '0.18 0.04 0.14');
        $text_at('Electronically Verified', $left + 16, 142, 7.5, 'F1', '0.42 0.29 0.36');
    }

    // Official Seal Badge on Right
    $fill_rect(380, 124, 152, 70, '1 1 1');
    $stroke_rect(380, 124, 152, 70, '0.38 0.11 0.29', 1.2);
    $fill_rect(384, 128, 144, 62, '0.96 0.91 0.93');
    $text_at('FOOTBALL DUCKS ACADEMY', 390, 172, 7.5, 'F2', '0.38 0.11 0.29');
    $text_at('OFFICIAL ADMISSION SEAL', 392, 156, 7, 'F2', '0.42 0.29 0.36');
    $text_at('VERIFIED & APPROVED', 394, 138, 8.5, 'F2', '0.38 0.11 0.29');

    return football_generate_pdf_document($pages, $images);
}

function football_generate_pdf_document($pages, $images = array()) {
    $objects = array();
    $kids = array();
    $object_number = 3;

    $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';

    $image_objects = array();
    foreach ($images as $img_name => $img_info) {
        $img_obj_num = $object_number++;
        $image_objects[$img_name] = $img_obj_num;
        $stream_data = $img_info['data'];
        $objects[$img_obj_num] = sprintf(
            "<< /Type /XObject /Subtype /Image /Width %d /Height %d /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length %d >>\nstream\n%s\nendstream",
            (int) $img_info['width'],
            (int) $img_info['height'],
            strlen($stream_data),
            $stream_data
        );
    }

    $xobject_res = '';
    if (!empty($image_objects)) {
        $xobject_entries = array();
        foreach ($image_objects as $img_name => $img_obj_num) {
            $xobject_entries[] = '/' . $img_name . ' ' . $img_obj_num . ' 0 R';
        }
        $xobject_res = ' /XObject << ' . implode(' ', $xobject_entries) . ' >>';
    }

    foreach ($pages as $page_commands) {
        $page_object = $object_number;
        $content_object = $object_number + 1;
        $kids[] = $page_object . ' 0 R';

        $content = implode("\n", $page_commands);
        $objects[$page_object] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> /F2 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> >>' . $xobject_res . ' >> /Contents ' . $content_object . ' 0 R >>';
        $objects[$content_object] = "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream";
        $object_number += 2;
    }

    $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $kids) . '] /Count ' . count($pages) . ' >>';
    ksort($objects);

    $pdf = "%PDF-1.4\n";
    $offsets = array(0);

    foreach ($objects as $number => $object) {
        $offsets[$number] = strlen($pdf);
        $pdf .= $number . " 0 obj\n" . $object . "\nendobj\n";
    }

    $xref_offset = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";

    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
    }

    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref_offset . "\n%%EOF";

    return $pdf;
}

function football_create_acknowledgement_pdf($post_id, $data, $acknowledgement_no) {
    $uploads = wp_upload_dir();

    if (!empty($uploads['error'])) {
        return array('path' => '', 'url' => '');
    }

    $directory = trailingslashit($uploads['basedir']) . 'student-acknowledgements';
    $url_base = trailingslashit($uploads['baseurl']) . 'student-acknowledgements';

    if (!wp_mkdir_p($directory)) {
        return array('path' => '', 'url' => '');
    }

    $filename = sanitize_file_name($acknowledgement_no . '.pdf');
    $path = trailingslashit($directory) . $filename;
    $url = trailingslashit($url_base) . $filename;
    $data['post_id'] = $post_id;
    $pdf = football_build_acknowledgement_pdf($data, $acknowledgement_no);

    if (file_put_contents($path, $pdf) === false) {
        return array('path' => '', 'url' => '');
    }

    update_post_meta($post_id, 'acknowledgement_pdf_path', $path);
    update_post_meta($post_id, 'acknowledgement_pdf_url', $url);

    return array('path' => $path, 'url' => $url);
}

function football_handle_student_registration() {
    if (!isset($_POST['football_registration_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['football_registration_nonce'])), 'football_student_registration')) {
        football_registration_redirect_with_status('error');
    }

    if (!empty($_POST['registration_website'])) {
        football_registration_redirect_with_status('success');
    }

    $data = array(
        'student_name'      => sanitize_text_field(wp_unslash($_POST['student_name'] ?? '')),
        'date_of_birth'     => sanitize_text_field(wp_unslash($_POST['date_of_birth'] ?? '')),
        'guardian_name'     => sanitize_text_field(wp_unslash($_POST['guardian_name'] ?? '')),
        'mobile_no'         => sanitize_text_field(wp_unslash($_POST['mobile_no'] ?? '')),
        'school'            => sanitize_text_field(wp_unslash($_POST['school'] ?? '')),
        'address'           => sanitize_textarea_field(wp_unslash($_POST['address'] ?? '')),
        'email'             => sanitize_email(wp_unslash($_POST['email'] ?? '')),
        'age_group'         => sanitize_text_field(wp_unslash($_POST['age_group'] ?? '')),
        'nationality'       => sanitize_text_field(wp_unslash($_POST['nationality'] ?? '')),
        'payment_reference' => sanitize_text_field(wp_unslash($_POST['payment_reference'] ?? '')),
    );

    $required_fields = array('student_name', 'date_of_birth', 'guardian_name', 'mobile_no', 'address', 'email', 'age_group', 'nationality', 'payment_reference');

    foreach ($required_fields as $field) {
        if ($data[$field] === '') {
            football_registration_redirect_with_status('error');
        }
    }

    if (!is_email($data['email']) || empty($_POST['terms_agreed'])) {
        football_registration_redirect_with_status('error');
    }

    $allowed_schools = football_registration_school_options();
    $allowed_age_groups = football_registration_age_groups();
    $allowed_nationalities = football_registration_nationalities();

    if (($data['school'] !== '' && !in_array($data['school'], $allowed_schools, true)) || !in_array($data['age_group'], $allowed_age_groups, true) || !in_array($data['nationality'], $allowed_nationalities, true)) {
        football_registration_redirect_with_status('error');
    }

    foreach (football_registration_upload_fields() as $field_name => $field_label) {
        if (empty($_FILES[$field_name]['name'])) {
            football_registration_redirect_with_status('error');
        }
    }

    $post_id = wp_insert_post(
        array(
            'post_type'   => 'student_registration',
            'post_status' => 'private',
            'post_title'  => sprintf('%s - %s', $data['student_name'], current_time('mysql')),
        ),
        true
    );

    if (is_wp_error($post_id)) {
        football_registration_redirect_with_status('error');
    }

    foreach ($data as $field => $value) {
        update_post_meta($post_id, $field, $value);
    }

    $acknowledgement_no = football_generate_acknowledgement_number($post_id);

    wp_update_post(
        array(
            'ID'         => $post_id,
            'post_title' => sprintf('%s - %s', $acknowledgement_no, $data['student_name']),
        )
    );

    update_post_meta($post_id, 'acknowledgement_no', $acknowledgement_no);
    update_post_meta($post_id, 'registration_fee', 'Rs. 500/-');
    update_post_meta($post_id, 'terms_agreed', 'Yes');

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    foreach (football_registration_upload_fields() as $field_name => $field_label) {
        $attachment_id = media_handle_upload($field_name, $post_id);

        if (is_wp_error($attachment_id)) {
            wp_delete_post($post_id, true);
            football_registration_redirect_with_status('error');
        }

        update_post_meta($post_id, $field_name, (int) $attachment_id);
    }

    $acknowledgement_pdf = football_create_acknowledgement_pdf($post_id, $data, $acknowledgement_no);
    $email_attachments = !empty($acknowledgement_pdf['path']) ? array($acknowledgement_pdf['path']) : array();

    $to = array_unique(array_filter(array(get_option('admin_email'), 'football.ducksports@gmail.com')));
    $subject = sprintf(__('New Football Registration - %s', 'football'), $acknowledgement_no);
    $body_lines = array(
        __('A new student registration has been submitted.', 'football'),
        '',
        sprintf('Acknowledgement No.: %s', $acknowledgement_no),
        sprintf("Student's Name: %s", $data['student_name']),
        sprintf('Date of Birth: %s', $data['date_of_birth']),
        sprintf("Guardian's Name: %s", $data['guardian_name']),
        sprintf('Mobile No.: %s', $data['mobile_no']),
        sprintf('School: %s', $data['school'] ?: __('Not selected', 'football')),
        sprintf('Address: %s', $data['address']),
        sprintf('Email: %s', $data['email']),
        sprintf('Age Group: %s', $data['age_group']),
        sprintf('Nationality: %s', $data['nationality']),
        sprintf('Payment Reference: %s', $data['payment_reference']),
        '',
        !empty($acknowledgement_pdf['url']) ? sprintf(__('PDF Acknowledgement: %s', 'football'), $acknowledgement_pdf['url']) : '',
        sprintf(__('View registration: %s', 'football'), admin_url('post.php?post=' . $post_id . '&action=edit')),
    );
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $data['email']);

    wp_mail($to, $subject, implode("\n", array_filter($body_lines)), $headers, $email_attachments);

    $student_subject = sprintf(__('Football Ducks Sports Registration Acknowledgement - %s', 'football'), $acknowledgement_no);
    $student_body_lines = array(
        sprintf(__('Dear %s,', 'football'), $data['student_name']),
        '',
        __('Thank you for registering with Football Ducks Sports Academy.', 'football'),
        sprintf(__('Your acknowledgement number is: %s', 'football'), $acknowledgement_no),
        '',
        __('Please save this number for future reference.', 'football'),
        '',
        sprintf(__('Student Name: %s', 'football'), $data['student_name']),
        sprintf(__('Guardian Name: %s', 'football'), $data['guardian_name']),
        sprintf(__('Mobile No.: %s', 'football'), $data['mobile_no']),
        sprintf(__('Age Group: %s', 'football'), $data['age_group']),
        sprintf(__('Payment Reference: %s', 'football'), $data['payment_reference']),
        '',
        !empty($acknowledgement_pdf['url']) ? sprintf(__('Download PDF Acknowledgement: %s', 'football'), $acknowledgement_pdf['url']) : '',
        '',
        __('Football Ducks Sports Academy', 'football'),
    );

    wp_mail($data['email'], $student_subject, implode("\n", array_filter($student_body_lines)), array('Content-Type: text/plain; charset=UTF-8'), $email_attachments);

    football_registration_redirect_with_status('success', array('ack' => $acknowledgement_no));
}
add_action('admin_post_football_student_registration', 'football_handle_student_registration');
add_action('admin_post_nopriv_football_student_registration', 'football_handle_student_registration');

function football_notice_board_meta_boxes() {
    add_meta_box(
        'football-notice-board-details',
        __('Notice Details', 'football'),
        'football_render_notice_board_meta_box',
        'notice_board',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'football_notice_board_meta_boxes');

function football_render_notice_board_meta_box($post) {
    $notice_label = (string) get_post_meta($post->ID, 'notice_board_label', true);
    $notice_description = (string) get_post_meta($post->ID, 'notice_board_description', true);

    wp_nonce_field('football_notice_board_details', 'football_notice_board_nonce');
    ?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><?php esc_html_e('How to add notices', 'football'); ?></th>
                <td>
                    <p class="description"><?php esc_html_e('Create one Notice Board post for each homepage update. The title is shown as the main notice text.', 'football'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="notice_board_label"><?php esc_html_e('Notice Label', 'football'); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        id="notice_board_label"
                        name="notice_board_label"
                        value="<?php echo esc_attr($notice_label); ?>"
                        class="regular-text"
                        placeholder="<?php esc_attr_e('Example: Admissions', 'football'); ?>">
                    <p class="description"><?php esc_html_e('Shown above the notice title. If empty, the publish date is shown.', 'football'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="notice_board_description"><?php esc_html_e('Notice Text', 'football'); ?></label>
                </th>
                <td>
                    <textarea
                        id="notice_board_description"
                        name="notice_board_description"
                        class="large-text"
                        rows="3"
                        placeholder="<?php esc_attr_e('Short supporting text for this notice.', 'football'); ?>"><?php echo esc_textarea($notice_description); ?></textarea>
                    <p class="description"><?php esc_html_e('Shown below the notice title. If empty, the excerpt or content will be used.', 'football'); ?></p>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

function football_save_notice_board_meta($post_id) {
    if (!isset($_POST['football_notice_board_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['football_notice_board_nonce'])), 'football_notice_board_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $notice_label = isset($_POST['notice_board_label']) ? sanitize_text_field(wp_unslash($_POST['notice_board_label'])) : '';
    $notice_description = isset($_POST['notice_board_description']) ? sanitize_textarea_field(wp_unslash($_POST['notice_board_description'])) : '';

    if ($notice_label !== '') {
        update_post_meta($post_id, 'notice_board_label', $notice_label);
    } else {
        delete_post_meta($post_id, 'notice_board_label');
    }

    if ($notice_description !== '') {
        update_post_meta($post_id, 'notice_board_description', $notice_description);
    } else {
        delete_post_meta($post_id, 'notice_board_description');
    }
}
add_action('save_post_notice_board', 'football_save_notice_board_meta');

function football_training_program_meta_boxes() {
    add_meta_box(
        'football-training-program-details',
        __('Program Details', 'football'),
        'football_render_training_program_meta_box',
        'training_program',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'football_training_program_meta_boxes');

function football_render_training_program_meta_box($post) {
    $program_label = (string) get_post_meta($post->ID, 'training_program_label', true);
    $program_description = (string) get_post_meta($post->ID, 'training_program_description', true);
    $program_featured = (bool) get_post_meta($post->ID, 'training_program_featured', true);

    wp_nonce_field('football_training_program_details', 'football_training_program_nonce');
    ?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><?php esc_html_e('How to add cards', 'football'); ?></th>
                <td>
                    <p class="description"><?php esc_html_e('Create one Training Program post for each homepage card. Use Add New Training Program to add the second and third cards.', 'football'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="training_program_label"><?php esc_html_e('Program Label', 'football'); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        id="training_program_label"
                        name="training_program_label"
                        value="<?php echo esc_attr($program_label); ?>"
                        class="regular-text"
                        placeholder="<?php esc_attr_e('Example: U-8 to U-11', 'football'); ?>">
                    <p class="description"><?php esc_html_e('Shown above the program title on the homepage card.', 'football'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="training_program_description"><?php esc_html_e('Program Text', 'football'); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        id="training_program_description"
                        name="training_program_description"
                        value="<?php echo esc_attr($program_description); ?>"
                        class="large-text"
                        placeholder="<?php esc_attr_e('First touch, passing habits, coordination, balance, and joy on the ball.', 'football'); ?>">
                    <p class="description"><?php esc_html_e('Shown as the description text on the homepage card.', 'football'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Featured Card', 'football'); ?></th>
                <td>
                    <label for="training_program_featured">
                        <input
                            type="checkbox"
                            id="training_program_featured"
                            name="training_program_featured"
                            value="1"
                            <?php checked($program_featured); ?>>
                        <?php esc_html_e('Use highlighted styling for this program.', 'football'); ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

function football_save_training_program_meta($post_id) {
    if (!isset($_POST['football_training_program_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['football_training_program_nonce'])), 'football_training_program_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $program_label = isset($_POST['training_program_label']) ? sanitize_text_field(wp_unslash($_POST['training_program_label'])) : '';
    $program_description = isset($_POST['training_program_description']) ? sanitize_text_field(wp_unslash($_POST['training_program_description'])) : '';

    if ($program_label !== '') {
        update_post_meta($post_id, 'training_program_label', $program_label);
    } else {
        delete_post_meta($post_id, 'training_program_label');
    }

    if ($program_description !== '') {
        update_post_meta($post_id, 'training_program_description', $program_description);
    } else {
        delete_post_meta($post_id, 'training_program_description');
    }

    if (!empty($_POST['training_program_featured'])) {
        update_post_meta($post_id, 'training_program_featured', '1');
    } else {
        delete_post_meta($post_id, 'training_program_featured');
    }
}
add_action('save_post_training_program', 'football_save_training_program_meta');

function football_student_registration_admin_columns($columns) {
    return array(
        'cb'                 => $columns['cb'],
        'registration_photo' => __('Photo', 'football'),
        'acknowledgement_no' => __('Ack No.', 'football'),
        'title'              => __("Student's Name", 'football'),
        'age_group'          => __('Age Group', 'football'),
        'guardian_info'      => __('Guardian & Mobile', 'football'),
        'payment_info'       => __('Payment Ref', 'football'),
        'pdf_receipt'        => __('PDF Receipt', 'football'),
        'date'               => __('Submitted Date', 'football'),
    );
}
add_filter('manage_student_registration_posts_columns', 'football_student_registration_admin_columns');

function football_student_registration_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'registration_photo':
            $photo_id = get_post_meta($post_id, 'passport_photo', true);
            $photo_url = $photo_id ? wp_get_attachment_image_url((int) $photo_id, 'thumbnail') : '';
            if ($photo_url) {
                echo '<img src="' . esc_url($photo_url) . '" style="width: 44px; height: 54px; object-fit: cover; border-radius: 4px; border: 1.5px solid #bd5579; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" alt="Student Photo">';
            } else {
                echo '<span style="color:#999; font-size: 11px;">No photo</span>';
            }
            break;
        case 'acknowledgement_no':
            $ack = get_post_meta($post_id, 'acknowledgement_no', true);
            echo '<strong style="color: #601d49; background: #faf4f6; padding: 4px 8px; border-radius: 4px; border: 1px solid #ea9d9d; font-family: monospace; font-size: 12px;">' . esc_html($ack ?: '—') . '</strong>';
            break;
        case 'age_group':
            echo '<span style="background:#601d49; color:#ffffff; padding:3px 8px; border-radius:12px; font-size:11px; font-weight:600;">' . esc_html(get_post_meta($post_id, 'age_group', true) ?: '—') . '</span>';
            break;
        case 'guardian_info':
            $g_name = get_post_meta($post_id, 'guardian_name', true);
            $mobile = get_post_meta($post_id, 'mobile_no', true);
            echo '<strong style="color:#2d0b22;">' . esc_html($g_name ?: '—') . '</strong><br>';
            if ($mobile) {
                echo '<a href="tel:' . esc_attr($mobile) . '" style="color:#bd5579; text-decoration:none; font-weight:500;">📞 ' . esc_html($mobile) . '</a>';
            }
            break;
        case 'payment_info':
            $pay_ref = get_post_meta($post_id, 'payment_reference', true);
            echo '<code style="font-size:11px; color:#601d49;">' . esc_html($pay_ref ?: '—') . '</code><br>';
            echo '<span style="background:#e6f4ea; color:#137333; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; display:inline-block; margin-top:2px;">VERIFIED</span>';
            break;
        case 'pdf_receipt':
            $pdf_url = get_post_meta($post_id, 'acknowledgement_pdf_url', true);
            $ack_no = get_post_meta($post_id, 'acknowledgement_no', true);
            if ($pdf_url) {
                echo '<a href="' . esc_url($pdf_url) . '" class="button button-small button-primary" target="_blank" style="background:#601d49; border-color:#601d49; margin-bottom:3px;">📄 Download PDF</a><br>';
            }
            if ($ack_no) {
                $front_url = add_query_arg('view_receipt', $ack_no, home_url('/'));
                echo '<a href="' . esc_url($front_url) . '" class="button button-small" target="_blank">👁️ View Slip</a>';
            }
            break;
    }
}
add_action('manage_student_registration_posts_custom_column', 'football_student_registration_admin_column_content', 10, 2);

function football_registration_meta_boxes() {
    add_meta_box(
        'football-registration-details',
        __('Student Registered Form & Receipt', 'football'),
        'football_render_registration_meta_box',
        'student_registration',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'football_registration_meta_boxes');

function football_render_registration_meta_box($post) {
    $fields = array(
        'acknowledgement_no' => __('Acknowledgement No.', 'football'),
        'student_name'      => __("Student's Name", 'football'),
        'date_of_birth'     => __('Date of Birth', 'football'),
        'guardian_name'     => __("Guardian's Name", 'football'),
        'mobile_no'         => __('Mobile No.', 'football'),
        'school'            => __('School / Centre', 'football'),
        'address'           => __('Residential Address', 'football'),
        'email'             => __('Email Address', 'football'),
        'age_group'         => __('Age Category', 'football'),
        'nationality'       => __('Nationality', 'football'),
        'registration_fee'  => __('Registration Fee', 'football'),
        'payment_reference' => __('Payment Reference ID', 'football'),
        'terms_agreed'      => __('Terms Agreed', 'football'),
    );

    $photo_id = (int) get_post_meta($post->ID, 'passport_photo', true);
    $photo_url = $photo_id ? wp_get_attachment_url($photo_id) : '';
    $sig_id = (int) get_post_meta($post->ID, 'guardian_signature', true);
    $sig_url = $sig_id ? wp_get_attachment_url($sig_id) : '';
    $pdf_url = (string) get_post_meta($post->ID, 'acknowledgement_pdf_url', true);
    $ack_no = (string) get_post_meta($post->ID, 'acknowledgement_no', true);

    $front_receipt_url = $ack_no ? add_query_arg('view_receipt', $ack_no, home_url('/')) : '';
    $logo_url = home_url('/wp-content/uploads/2026/08/logo.png');
    ?>
    <style>
        .fd-admin-receipt-card {
            background: #ffffff;
            border: 1px solid #ea9d9d;
            border-radius: 8px;
            overflow: hidden;
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
            box-shadow: 0 4px 12px rgba(96, 29, 73, 0.08);
            margin-bottom: 20px;
        }
        .fd-admin-header {
            background: linear-gradient(135deg, #601d49 0%, #441334 100%);
            color: #ffffff;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .fd-admin-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .fd-admin-logo-box {
            background: #ffffff;
            border: 1px solid #ffebb8;
            padding: 4px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }
        .fd-admin-logo-box img {
            height: 38px;
            width: auto;
        }
        .fd-admin-title h3 {
            margin: 0;
            color: #ffffff;
            font-size: 17px;
            font-weight: 700;
        }
        .fd-admin-title p {
            margin: 2px 0 0 0;
            color: #ffebb8;
            font-size: 11px;
        }
        .fd-admin-actions {
            display: flex;
            gap: 8px;
        }
        .fd-admin-btn {
            background: #ffebb8;
            color: #601d49;
            padding: 8px 14px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .fd-admin-btn:hover {
            background: #ffffff;
            color: #601d49;
        }
        .fd-admin-btn-secondary {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .fd-admin-btn-secondary:hover {
            background: #ffffff;
            color: #601d49;
        }
        .fd-admin-body {
            padding: 20px;
        }
        .fd-admin-grid {
            display: grid;
            grid-template-columns: 1fr 220px;
            gap: 20px;
        }
        @media (max-width: 782px) {
            .fd-admin-grid {
                grid-template-columns: 1fr;
            }
        }
        .fd-admin-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #f0e2e7;
            border-radius: 6px;
            overflow: hidden;
        }
        .fd-admin-table th {
            width: 32%;
            background: #faf4f6;
            color: #601d49;
            font-weight: 600;
            font-size: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid #f0e2e7;
            border-right: 1px solid #f0e2e7;
            text-align: left;
        }
        .fd-admin-table td {
            padding: 10px 14px;
            color: #2d0b22;
            font-size: 13px;
            border-bottom: 1px solid #f0e2e7;
        }
        .fd-admin-photo-card {
            border: 1.5px solid #bd5579;
            background: #faf4f6;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }
        .fd-admin-photo-card img {
            width: 100%;
            max-width: 180px;
            height: 220px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ea9d9d;
            background: #ffffff;

        }
        .fd-admin-photo-label {
            margin-top: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #601d49;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .fd-admin-sig-box {
            margin-top: 20px;
            border: 1px dashed #bd5579;
            background: #ffffff;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }
        .fd-admin-sig-box img {
            max-width: 180px;
            max-height: 70px;
            object-fit: contain;
        }
        .fd-admin-sig-label {
            font-size: 11px;
            color: #601d49;
            font-weight: 600;
            margin-top: 6px;
        }
        .fd-admin-docs {
            margin-top: 24px;
            border-top: 1px solid #f0e2e7;
            padding-top: 16px;
        }
        .fd-admin-docs h4 {
            margin: 0 0 12px 0;
            color: #601d49;
            font-size: 14px;
        }
        .fd-admin-docs-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .fd-admin-doc-chip {
            background: #faf4f6;
            border: 1px solid #ea9d9d;
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 12px;
            color: #601d49;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .fd-admin-doc-chip:hover {
            background: #601d49;
            color: #ffffff;
        }
    </style>

    <div class="fd-admin-receipt-card">
        <div class="fd-admin-header">
            <div class="fd-admin-brand">
                <div class="fd-admin-logo-box">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Football Ducks Logo">
                </div>
                <div class="fd-admin-title">
                    <h3>Football Ducks Sports Academy</h3>
                    <p>Official Registered Student Admission Slip & Profile Card</p>
                </div>
            </div>
            <div class="fd-admin-actions">
                <?php if ($pdf_url) : ?>
                    <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener" class="fd-admin-btn">
                        📄 Download PDF Receipt
                    </a>
                <?php endif; ?>
                <?php if ($front_receipt_url) : ?>
                    <a href="<?php echo esc_url($front_receipt_url); ?>" target="_blank" rel="noopener" class="fd-admin-btn fd-admin-btn-secondary">
                        🖨️ View / Print Slip
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="fd-admin-body">
            <div class="fd-admin-grid">
                <div>
                    <table class="fd-admin-table">
                        <tbody>
                            <?php foreach ($fields as $field => $label) : ?>
                                <tr>
                                    <th><?php echo esc_html($label); ?></th>
                                    <td>
                                        <?php
                                        $val = get_post_meta($post->ID, $field, true);
                                        if ($field === 'acknowledgement_no') {
                                            echo '<strong style="color:#601d49; font-family:monospace; font-size:14px; background:#faf4f6; padding:3px 8px; border-radius:4px; border:1px solid #ea9d9d;">' . esc_html($val) . '</strong>';
                                        } elseif ($field === 'payment_reference') {
                                            echo '<code style="font-size:13px; font-weight:600; color:#601d49;">' . esc_html($val) . '</code> <span style="background:#e6f4ea; color:#137333; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:6px;">VERIFIED</span>';
                                        } elseif ($field === 'email') {
                                            echo '<a href="mailto:' . esc_attr($val) . '" style="color:#bd5579; text-decoration:none;">' . esc_html($val) . '</a>';
                                        } elseif ($field === 'mobile_no') {
                                            echo '<a href="tel:' . esc_attr($val) . '" style="color:#bd5579; text-decoration:none; font-weight:600;">' . esc_html($val) . '</a>';
                                        } else {
                                            echo nl2br(esc_html($val !== '' ? $val : '—'));
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div>
                    <div class="fd-admin-photo-card">
                        <?php if ($photo_url) : ?>
                            <img src="<?php echo esc_url($photo_url); ?>" alt="Student Photo">
                        <?php else : ?>
                            <div style="height:220px; display:flex; align-items:center; justify-content:center; background:#ffffff; border:1px dashed #ea9d9d; border-radius:4px; color:#999; font-size:12px;">
                                [ Passport Photo Not Uploaded ]
                            </div>
                        <?php endif; ?>
                        <div class="fd-admin-photo-label">Student Passport Photo</div>
                    </div>

                    <div class="fd-admin-sig-box">
                        <?php if ($sig_url) : ?>
                            <img src="<?php echo esc_url($sig_url); ?>" alt="Guardian Signature">
                        <?php else : ?>
                            <span style="font-size:12px; color:#666;">[ Guardian Signature Uploaded ]</span>
                        <?php endif; ?>
                        <div class="fd-admin-sig-label">Guardian Electronically Signed</div>
                    </div>
                </div>
            </div>

            <div class="fd-admin-docs">
                <h4>📁 Submitted Documents & Files</h4>
                <div class="fd-admin-docs-grid">
                    <?php if ($pdf_url) : ?>
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="fd-admin-doc-chip">
                            📜 Official PDF Receipt (.pdf)
                        </a>
                    <?php endif; ?>

                    <?php foreach (football_registration_upload_fields() as $field => $label) : ?>
                        <?php
                        $att_id = (int) get_post_meta($post->ID, $field, true);
                        $att_url = $att_id ? wp_get_attachment_url($att_id) : '';
                        ?>
                        <?php if ($att_url) : ?>
                            <a href="<?php echo esc_url($att_url); ?>" target="_blank" class="fd-admin-doc-chip">
                                📎 <?php echo esc_html($label); ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function football_image_url($image_field, $fallback = '') {
    if (is_array($image_field) && !empty($image_field['url'])) {
        return $image_field['url'];
    }

    if (is_numeric($image_field)) {
        $image_url = wp_get_attachment_image_url((int) $image_field, 'large');
        return $image_url ?: $fallback;
    }

    if (is_string($image_field) && $image_field !== '') {
        return $image_field;
    }

    return $fallback;
}

function football_youtube_channel_id() {
    return 'UCu7Tukr3uUrr87FMG3sf1iA';
}

function football_youtube_channel_url() {
    return 'https://www.youtube.com/@DuckSportsFootballAcademy';
}

function football_youtube_uploads_playlist_id($channel_id = '') {
    $channel_id = $channel_id ?: football_youtube_channel_id();

    if (strpos($channel_id, 'UC') === 0) {
        return 'UU' . substr($channel_id, 2);
    }

    return $channel_id;
}

function football_youtube_uploads_embed_url($channel_id = '') {
    return add_query_arg(
        array(
            'list' => football_youtube_uploads_playlist_id($channel_id),
            'rel'  => '0',
        ),
        'https://www.youtube.com/embed/videoseries'
    );
}

function football_youtube_video_id($url) {
    if (!$url) {
        return '';
    }

    $parts = wp_parse_url($url);
    $video_id = '';
    $path = trim((string) ($parts['path'] ?? ''), '/');

    if (!empty($parts['host']) && strpos($parts['host'], 'youtu.be') !== false) {
        $video_id = strtok($path, '/');
    } elseif (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
        $video_id = $query['v'] ?? '';
    }

    if (!$video_id && $path) {
        $path_parts = explode('/', $path);

        if (in_array($path_parts[0], array('embed', 'live', 'shorts'), true) && !empty($path_parts[1])) {
            $video_id = $path_parts[1];
        }
    }

    return preg_replace('/[^A-Za-z0-9_-]/', '', (string) $video_id);
}

function football_youtube_embed_url($url) {
    $video_id = football_youtube_video_id($url);

    return $video_id ? 'https://www.youtube.com/embed/' . rawurlencode($video_id) : '';
}

class Bootstrap_NavWalker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="dropdown-menu">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));

        $output .= '<li class="nav-item ' . esc_attr($class_names) . '">';
        $output .= '<a class="nav-link" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}
