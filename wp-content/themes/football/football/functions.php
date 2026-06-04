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
    $upi_id = football_get_field('registration_upi_id', $page_id, 'football.ducksports@gmail.com');
    $qr_image = football_image_url(football_get_field('registration_qr_image', $page_id));
    $redirect_url = get_permalink($page_id) ?: football_registration_url();
    $message = '';

    if (isset($_GET['registration'])) {
        $status = sanitize_key(wp_unslash($_GET['registration']));

        if ($status === 'success') {
            $acknowledgement_no = isset($_GET['ack']) ? sanitize_text_field(wp_unslash($_GET['ack'])) : '';
            $success_message = '<p>' . esc_html__('Thank you. Your registration has been submitted successfully.', 'football') . '</p>';

            if ($acknowledgement_no !== '') {
                $pdf_url = football_get_acknowledgement_pdf_url($acknowledgement_no);
                $success_message .= '<div class="registration-acknowledgement">';
                $success_message .= '<span>' . esc_html__('Acknowledgement No.', 'football') . '</span>';
                $success_message .= '<strong>' . esc_html($acknowledgement_no) . '</strong>';
                $success_message .= '<small>' . esc_html__('Please save this number for future reference.', 'football') . '</small>';

                if ($pdf_url) {
                    $success_message .= '<a class="registration-pdf-link" href="' . esc_url($pdf_url) . '" target="_blank" rel="noopener">' . esc_html__('Download PDF Acknowledgement', 'football') . '</a>';
                }

                $success_message .= '</div>';
            }

            $message = '<div class="registration-alert registration-alert--success">' . $success_message . '</div>';
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
                    <p><?php esc_html_e('Pay via UPI / Google Pay / Paytm / PhonePe by above ID.', 'football'); ?></p>
                    <p class="registration-payment__upi"><?php esc_html_e('UPI ID:', 'football'); ?> <strong><?php echo esc_html($upi_id); ?></strong></p>
                </div>

                <div class="registration-payment__qr">
                    <?php if ($qr_image) : ?>
                        <img src="<?php echo esc_url($qr_image); ?>" alt="<?php esc_attr_e('QR Code for Payment', 'football'); ?>">
                    <?php else : ?>
                        <span><?php esc_html_e('QR Code for Payment', 'football'); ?></span>
                    <?php endif; ?>
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

function football_build_acknowledgement_pdf($data, $acknowledgement_no) {
    $pages = array(array());
    $page_index = 0;
    $y = 0;
    $left = 48;
    $right = 547;
    $width = $right - $left;

    $add_command = function ($command) use (&$pages, &$page_index) {
        $pages[$page_index][] = $command;
    };

    $new_page = function () use (&$pages, &$page_index) {
        $page_index++;
        $pages[$page_index] = array();
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

    $wrapped_text_at = function ($value, $x, $start_y, $max_width, $size = 10, $font = 'F1', $line_height = 13, $color = '0 0 0') use ($text_at) {
        $current_y = $start_y;

        foreach (football_pdf_wrap_lines($value, $max_width, $size) as $text_line) {
            $text_at($text_line, $x, $current_y, $size, $font, $color);
            $current_y -= $line_height;
        }

        return $current_y;
    };

    $draw_page_shell = function ($page_label) use ($left, $right, $width, $fill_rect, $stroke_rect, $line, $text_at) {
        $fill_rect(0, 0, 595, 842, '0.96 0.98 0.96');
        $fill_rect($left, 748, $width, 58, '0.03 0.29 0.18');
        $fill_rect($left, 742, $width, 6, '0.72 0.87 0.25');
        $stroke_rect($left, 50, $width, 756, '0.78 0.85 0.79', 1.1);

        $fill_rect(66, 764, 28, 28, '0.72 0.87 0.25');
        $text_at('FD', 72, 773, 11, 'F2', '0.03 0.29 0.18');
        $text_at('Football Ducks Sports Academy', 106, 782, 16, 'F2', '1 1 1');
        $text_at('Official Online Registration Acknowledgement', 106, 764, 9, 'F1', '0.86 0.93 0.89');
        $text_at($page_label, 461, 773, 10, 'F2', '1 1 1');

        $line($left, 84, $right, 84, '0.82 0.88 0.84', 1);
        $text_at('Computer generated acknowledgement. Please retain this PDF for future reference.', $left, 66, 8, 'F1', '0.36 0.43 0.39');
        $text_at('football.ducksports@gmail.com | +91 98214 40038', 337, 66, 8, 'F1', '0.36 0.43 0.39');
    };

    $section_heading = function ($title, $heading_y) use ($left, $fill_rect, $text_at) {
        $fill_rect($left, $heading_y - 4, 499, 24, '0.90 0.95 0.91');
        $fill_rect($left, $heading_y - 4, 4, 24, '0.05 0.42 0.25');
        $text_at($title, $left + 14, $heading_y + 3, 11, 'F2', '0.04 0.25 0.16');
    };

    $detail_row = function ($label, $value, $row_y, $row_height = 31) use ($left, $fill_rect, $stroke_rect, $text_at, $wrapped_text_at) {
        $value = (string) ($value !== '' ? $value : 'Not provided');
        $fill_rect($left, $row_y, 146, $row_height, '0.97 0.99 0.97');
        $stroke_rect($left, $row_y, 499, $row_height, '0.85 0.90 0.86', 0.6);
        $text_at($label, $left + 12, $row_y + $row_height - 18, 8.5, 'F2', '0.20 0.28 0.24');
        $wrapped_text_at($value, $left + 160, $row_y + $row_height - 17, 325, 9.2, 'F1', 11, '0.07 0.13 0.10');
    };

    $draw_page_shell('RECEIPT');

    $fill_rect($left, 664, 499, 58, '1 1 1');
    $stroke_rect($left, 664, 499, 58, '0.78 0.85 0.79', 0.8);
    $text_at('Acknowledgement No.', $left + 18, 700, 8.5, 'F2', '0.32 0.42 0.36');
    $text_at($acknowledgement_no, $left + 18, 680, 18, 'F2', '0.05 0.42 0.25');
    $text_at('Submitted On', 342, 700, 8.5, 'F2', '0.32 0.42 0.36');
    $text_at(current_time('d M Y, h:i A'), 342, 681, 10, 'F2', '0.07 0.13 0.10');

    $fill_rect($left, 604, 238, 42, '0.05 0.42 0.25');
    $text_at('REGISTRATION FEE', $left + 18, 629, 8, 'F2', '0.86 0.93 0.89');
    $text_at('Rs. 500/-', $left + 18, 612, 15, 'F2', '1 1 1');

    $fill_rect(309, 604, 238, 42, '0.72 0.87 0.25');
    $text_at('TERMS STATUS', 327, 629, 8, 'F2', '0.04 0.25 0.16');
    $text_at('Accepted Online', 327, 612, 15, 'F2', '0.04 0.25 0.16');

    $section_heading('Student Details', 568);

    $rows = array(
        array("Student's Name", $data['student_name'] ?? '', 523, 32),
        array('Date of Birth', $data['date_of_birth'] ?? '', 491, 32),
        array("Guardian's Name", $data['guardian_name'] ?? '', 459, 32),
        array('Mobile No.', $data['mobile_no'] ?? '', 427, 32),
        array('Email', $data['email'] ?? '', 395, 32),
        array('Age Group', $data['age_group'] ?? '', 363, 32),
        array('Nationality', $data['nationality'] ?? '', 331, 32),
        array('School / Centre', $data['school'] ?? '', 287, 44),
        array('Address', $data['address'] ?? '', 231, 56),
        array('Payment Reference', $data['payment_reference'] ?? '', 199, 32),
    );

    foreach ($rows as $row) {
        $detail_row($row[0], $row[1], $row[2], $row[3]);
    }

    $fill_rect($left, 124, 499, 52, '1 1 1');
    $stroke_rect($left, 124, 499, 52, '0.78 0.85 0.79', 0.8);
    $text_at('Declaration', $left + 16, 156, 10, 'F2', '0.04 0.25 0.16');
    $wrapped_text_at('The parent/guardian has completed online registration and accepted the academy terms, conditions, health declaration, and participation-risk disclaimer.', $left + 16, 140, 464, 8.7, 'F1', 11, '0.20 0.28 0.24');

    $new_page();
    $draw_page_shell('TERMS');
    $section_heading('Terms and Conditions Accepted', 700);
    $wrapped_text_at('By registering for and participating in Football Ducks Sports Academy programs, the parent/guardian acknowledged and agreed to the following terms during online registration.', $left, 666, $width, 9.5, 'F1', 13, '0.20 0.28 0.24');

    $term_y = 612;
    foreach (football_registration_terms_for_acknowledgement() as $heading => $body) {
        $fill_rect($left, $term_y - 8, 499, 74, '1 1 1');
        $stroke_rect($left, $term_y - 8, 499, 74, '0.84 0.89 0.85', 0.7);
        $fill_rect($left, $term_y - 8, 4, 74, '0.05 0.42 0.25');
        $text_at($heading, $left + 16, $term_y + 44, 10, 'F2', '0.04 0.25 0.16');
        $wrapped_text_at($body, $left + 16, $term_y + 27, 462, 8.5, 'F1', 11, '0.20 0.28 0.24');
        $term_y -= 86;
    }

    $fill_rect($left, 96, 499, 52, '0.90 0.95 0.91');
    $stroke_rect($left, 96, 499, 52, '0.78 0.85 0.79', 0.8);
    $text_at('Acceptance Confirmation', $left + 16, 128, 10, 'F2', '0.04 0.25 0.16');
    $wrapped_text_at('Acceptance recorded electronically with acknowledgement number ' . $acknowledgement_no . '. This receipt is valid without a physical signature.', $left + 16, 112, 464, 8.7, 'F1', 11, '0.20 0.28 0.24');

    return football_generate_pdf_document($pages);
}

function football_generate_pdf_document($pages) {
    $objects = array();
    $kids = array();
    $object_number = 3;

    $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';

    foreach ($pages as $page_commands) {
        $page_object = $object_number;
        $content_object = $object_number + 1;
        $kids[] = $page_object . ' 0 R';

        $content = implode("\n", $page_commands);
        $objects[$page_object] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> /F2 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> >> >> /Contents ' . $content_object . ' 0 R >>';
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

function football_registration_meta_boxes() {
    add_meta_box(
        'football-registration-details',
        __('Registration Details', 'football'),
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
        'school'            => __('School', 'football'),
        'address'           => __('Address', 'football'),
        'email'             => __('Email', 'football'),
        'age_group'         => __('Age Group', 'football'),
        'nationality'       => __('Nationality', 'football'),
        'registration_fee'  => __('Registration Fee', 'football'),
        'payment_reference' => __('Payment Reference', 'football'),
        'terms_agreed'      => __('Terms Agreed', 'football'),
    );
    ?>
    <table class="widefat striped">
        <tbody>
            <?php foreach ($fields as $field => $label) : ?>
                <tr>
                    <th scope="row"><?php echo esc_html($label); ?></th>
                    <td><?php echo nl2br(esc_html(get_post_meta($post->ID, $field, true))); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php
            $acknowledgement_pdf_url = (string) get_post_meta($post->ID, 'acknowledgement_pdf_url', true);
            ?>
            <tr>
                <th scope="row"><?php esc_html_e('PDF Acknowledgement', 'football'); ?></th>
                <td>
                    <?php if ($acknowledgement_pdf_url) : ?>
                        <a href="<?php echo esc_url($acknowledgement_pdf_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Download PDF', 'football'); ?></a>
                    <?php endif; ?>
                </td>
            </tr>

            <?php foreach (football_registration_upload_fields() as $field => $label) : ?>
                <?php
                $attachment_id = (int) get_post_meta($post->ID, $field, true);
                $attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
                ?>
                <tr>
                    <th scope="row"><?php echo esc_html($label); ?></th>
                    <td>
                        <?php if ($attachment_url) : ?>
                            <a href="<?php echo esc_url($attachment_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('View file', 'football'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
