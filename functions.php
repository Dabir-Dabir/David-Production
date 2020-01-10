<?php

function language_switcher(){
    $languages = icl_get_languages('skip_missing=1');
    if(1 < count($languages)){
        foreach($languages as $l){
            if(!$l['active']) $langs[] = '<a href="'.$l['url'].'" class="link languages__lang">'.$l['native_name'].'</a>';
        }
        echo join('<span class="languages__split"></span>', $langs);
    }
}

add_theme_support( 'custom-logo' );

add_action('after_setup_theme', function(){
    register_nav_menus( array(
        'categories_menu' => 'Categories menu',
        'about_menu' => 'About menu'
    ) );
});

class My_Walker_Nav_Menu extends Walker_Nav_Menu {

    public $menu_class;

    function set_menu_class($menu_class) {
        $this->menu_class = $menu_class;
    }

    
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }


        // создаем HTML код элемента меню
        $output .= '<li class="' . $this->menu_class . '-menu__item">';


        $link_class = 'link ' . $this->menu_class . '-menu__link';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = ( $item->current ) ? $link_class . ' navigation--selected' : $link_class;

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

/*
* Creating a function to create our CPT
*/

function custom_post_type($names, $name, $label) {

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( $names, 'Post Type General Name', 'David Production' ),
        'singular_name'       => _x( $name, 'Post Type Singular Name', 'David Production' ),
        'menu_name'           => __( $names, 'David Production' ),
        'parent_item_colon'   => __( 'Parent  ' . $name, 'David Production' ),
        'all_items'           => __( 'All  ' . $names, 'David Production' ),
        'view_item'           => __( 'View  ' . $name, 'David Production' ),
        'add_new_item'        => __( 'Add New ' . $name, 'David Production' ),
        'add_new'             => __( 'Add New', 'David Production' ),
        'edit_item'           => __( 'Edit ' . $name, 'David Production' ),
        'update_item'         => __( 'Update ' . $name, 'David Production' ),
        'search_items'        => __( 'Search ' . $name, 'David Production' ),
        'not_found'           => __( 'Not Found', 'David Production' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'David Production' ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label'               => __( $label, 'David Production' ),
        'description'         => __( $name, 'David Production' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'thumbnail' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-video-alt2',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type
    register_post_type( $label, $args );

}

add_action( 'init', function() {return custom_post_type('Weddings', 'Wedding', 'weddings'); }, 0 );
add_action( 'init', function() {return custom_post_type('Commercials', 'Commercial', 'commercials'); }, 0 );
add_action( 'init', function() {return custom_post_type('Personals', 'Personal', 'personals'); }, 0 );


add_theme_support( 'post-thumbnails' );

// Video meta-box

function add_video_meta_box() {
    $post_types = array ( 'weddings', 'commercials', 'personals' );
    foreach ($post_types as $post_type) {
        add_meta_box(
            'portfolio_vido',
            'Video',
            'portfolio_video_html',
            $post_type,
            'normal'
        );
    }
}
add_action('add_meta_boxes', 'add_video_meta_box');

function  portfolio_video_html( $post ) {
    echo '<label for="vimeo-id">Type Vimeo video ID ( <i>https://vimeo.com/</i><b>[[ID]]</b> )</label> ';
    echo '<input type="number" id="vimeo-id" name="vimeo-id" min="0" value="';
    echo esc_attr( get_post_meta( get_the_ID(), 'vimeo-id', true ) );
    echo '">';
}

function hcf_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    update_post_meta( $post_id, 'vimeo-id', sanitize_text_field( $_POST['vimeo-id'] ) );
}
add_action( 'save_post', 'hcf_save_meta_box' );

// .Video metabox

function meta_data_meta_box() {
    add_meta_box(
        'meta_data',
        'Meta Data',
        'meta_keys_field',
        'page',
        'normal'
    );
}
add_action('add_meta_boxes', 'meta_data_meta_box');

function meta_keys_field( $post ) {

    echo '<label for="meta-keys">Page Meta Keys (#hashtags) [ Type with comma \',\' ]</label> ';
    echo '<textarea type="text" id="meta-keys" name="meta-keys">';
    echo esc_attr( get_post_meta( get_the_ID(), 'meta-keys', true ) );
    echo '</textarea><br>';

    echo '<label for="meta-description">Page Meta Description (From 120 to 158 characters)</label> ';
    echo '<textarea type="text" id="meta-description" name="meta-description">';
    echo esc_attr( get_post_meta( get_the_ID(), 'meta-description', true ) );
    echo '</textarea><br><br>';

    echo '<label for="facebook-title">Facebook share title</label> ';
    echo '<textarea type="text" id="facebook-title" name="facebook-title">';
    echo esc_attr( get_post_meta( get_the_ID(), 'facebook-title', true ) );
    echo '</textarea><br>';

    echo '<label for="facebook-description">Facebook share description</label> ';
    echo '<textarea type="text" id="facebook-description" name="facebook-description">';
    echo esc_attr( get_post_meta( get_the_ID(), 'facebook-description', true ) );
    echo '</textarea>';

}

function meta_fields_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    update_post_meta( $post_id, 'meta-keys', sanitize_text_field( $_POST['meta-keys'] ) );
    update_post_meta( $post_id, 'meta-description', sanitize_text_field( $_POST['meta-description'] ) );
    update_post_meta( $post_id, 'facebook-title', sanitize_text_field( $_POST['facebook-title'] ) );
    update_post_meta( $post_id, 'facebook-description', sanitize_text_field( $_POST['facebook-description'] ) );
}
add_action( 'save_post', 'meta_fields_meta_box' );



add_filter( 'wpcf7_autop_or_not', '__return_false' );


add_filter('the_content', 'changeBookingForm', 100);

function changeBookingForm($content) {
    if( !is_page('prices') ) return $content;
    global $sitepress;
    $current_language = $sitepress->get_current_language();
    $mail_from = "booking@david-production.com";

    if ($current_language == 'ka') {
        $find = array('/Date[*][:]/', '/Plan[*][:]/', '/Price[:]/',
            '/Name[*][:]/', '/Phone[*][:]/', '/E-mail[:]/',
            '/Comment[:]/', '/Send/',
            '/<input type="text" name="email1" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"/',
            '/<input type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="price1" id="price1" class="input-xlarge"/',
            '/<input type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="e-mail1" id="e-mail1" class="input-xlarge"/',
            '/id="comment1"/'
        );

        $replace = array('თარიღი', 'ტარიფი', 'ფასი',
            'სახელი *', 'ტელეფონი *', 'ელ-ფოსტა',
            'კომენტარი', 'დაჯავშნა',
            '<input type="text" disabled autocomplete="off" value="'.$mail_from.'" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"',
            '<input disabled type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="price1" id="price1" class="input-xlarge"',
            '<input placeholder="ირაკლი სილაგაძე" type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="+995 555 555 555" type="tel" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="iraklisilagadze49@example.com" type="email" name="e-mail1" id="e-mail1" class="input-xlarge"',
            'id="comment1" placeholder="აქ შეგიძლიათ თქვენს ჯავშანს დაურთოთ კომენტარი"'
        );


        $content = preg_replace($find, $replace, $content);

    } elseif ($current_language == 'ru') {
        $find = array('/Date[*][:]/', '/Plan[*][:]/', '/Price[:]/',
            '/Name[*][:]/', '/Phone[*][:]/', '/E-mail[:]/',
            '/Comment[:]/', '/Send/',
            '/<input type="text" name="email1" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"/',
            '/<input type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="price1" id="price1" class="input-xlarge"/',
            '/<input type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="e-mail1" id="e-mail1" class="input-xlarge"/',
            '/id="comment1"/'
        );

        $replace = array('Дата', 'План', 'Цена',
            'Имя *', 'Телефон *', 'Эл-почта',
            'Коментарий', 'Заказать',
            '<input type="text" disabled autocomplete="off" value="'.$mail_from.'" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"',
            '<input disabled type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="price1" id="price1" class="input-xlarge"',
            '<input placeholder="Иван Иванов" type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="+7 (000) 00-00-00" type="tel" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="ivanivanov49@example.com" type="email" name="e-mail1" id="e-mail1" class="input-xlarge"',
            'id="comment1" placeholder="Здесь можете к вашему заказу добавить комментарий."'
        );


        $content = preg_replace($find, $replace, $content);

    } elseif ($current_language == 'en') {
        $find = array('/Date[*][:]/', '/Plan[*][:]/', '/Price[:]/',
            '/Name[*][:]/', '/Phone[*][:]/', '/E-mail[:]/',
            '/Comment[:]/', '/Send/',
            '/<input type="text" name="email1" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"/',
            '/<input type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="price1" id="price1" class="input-xlarge"/',
            '/<input type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"/',
            '/<input type="text" name="e-mail1" id="e-mail1" class="input-xlarge"/',
            '/id="comment1"/'
        );

        $replace = array('Date', 'Plan', 'Price',
            'Name *', 'Phone *', 'E-mail',
            'Comment', 'Book',
            '<input type="text" disabled autocomplete="off" value="'.$mail_from.'" id="email1" class="input-xlarge wpdev-validates-as-email wpdev-validates-as-required wpdev-validates-as-required"',
            '<input disabled type="text" name="date1" id="date1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="plan1" id="plan1" class="input-xlarge wpdev-validates-as-required"',
            '<input disabled type="text" name="price1" id="price1" class="input-xlarge"',
            '<input placeholder="John Smith" type="text" name="name1" id="name1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="+0 90 444 44444" type="tel" name="phone1" id="phone1" class="input-xlarge wpdev-validates-as-required"',
            '<input placeholder="jonsmith@example.com" type="email" name="e-mail1" id="e-mail1" class="input-xlarge"',
            'id="comment1" placeholder="Here you can add a comment to your booking."'
        );


        $content = preg_replace($find, $replace, $content);

    }

    return $content;
}

remove_filter ('the_content', 'wpautop');