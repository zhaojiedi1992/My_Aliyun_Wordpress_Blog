<?php
/*
Plugin Name: Easy Thumbnail Switcher
Plugin URI: http://themestones.net
Author: Sohan Zaman (Theme Stones)
Author URI: http://themestones.net
Description: Adds a new column in all posts screen, from where you will be able to set or change or remove featured image of every post.
Version: 1.0.2
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html
*/

class TS_Easy_Thumbnail_Switcher {
    
    public $add_new_str;
    public $change_str;
    public $remove_str;
    public $upload_title;
    public $upload_add;
    public $confirm_str;
    
    /**
     * TS_Easy_Thumbnail_Switcher::__construct()
     *
     * The main constructor function
     * @since 1.0
     */
    public function __construct() {
    
        $this->add_new_str = __( 'Add new', 'ts_ets' );
        $this->change_str = __( 'Change', 'ts_ets' );
        $this->remove_str = __( 'Remove', 'ts_ets' );
        $this->upload_title = __( 'Upload featured image', 'ts_ets' );
        $this->upload_add = __( 'Use selected', 'ts_ets' );
        $this->confirm_str = __( 'Are you sure?', 'ts_ets' );
        
        add_filter( 'manage_posts_columns', array( $this, 'add_column' ) );
        add_action( 'manage_posts_custom_column', array( $this, 'thumb_column' ), 10, 2 );
        add_action( 'admin_footer', array( $this, 'add_nonce' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
        
        add_action( 'wp_ajax_ts_ets_update', array( $this, 'update' ) );
        add_action( 'wp_ajax_ts_ets_remove', array( $this, 'remove' ) );
        
        add_image_size( 'ts-ets-thumb', 75, 75, array( 'center', 'center' ) );

        require_once( dirname(__FILE__) . '/class-ts-admin-notice.php' );

        $href = admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=super-blog-pack&amp;TB_iframe=true&amp' );

        if( !function_exists('wp_get_current_user') ) {
            require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        if( current_user_can( 'install_plugins' ) || current_user_can( 'activate_plugins' ) ) {
            new TS_Admin_Notice( array(
                'id' => 'super-blog-pack',
                'notice' => '<strong>Power up your website</strong>! You can now show Post likes, Post views counter, Related posts, Post reviews with 5 star rating system and much more with a few clicks.<br><a href="' . esc_url( $href ) . '" class="thickbox open-plugin-details-modal" target="_blank">Try now for free!</a> or <a href="https://goo.gl/Ywr7L9" target="_blank">Get more details about this plugin.</a>',
                'type' => 'success',
                'dissmiss' => 'cookie',
            ) );
        }
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::add_nonce()
     *
     * Used to add a nonce for security checks
     * @since 1.0
     */
    public function add_nonce() {
        
        global $pagenow;
        
        if( $pagenow !== 'edit.php' ) {
            return;
        }
        
        wp_nonce_field( 'ts_ets_nonce', 'ts_ets_nonce' );
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::scripts()
     *
     * Enqueue scripts
     * @since 1.0
     */
    public function scripts( $pagenow ) {
        
        if( $pagenow !== 'edit.php' ) {
            return;
        }
        
        wp_enqueue_media();
        
        wp_enqueue_style( 'ts-ets-css', plugins_url( '\css\styles.css', __FILE__ ) );
        
        wp_enqueue_script( 'ts-ets-js', plugins_url( '\js\script.js', __FILE__ ), array( 'jquery', 'media-upload', 'thickbox' ), '1.0', true );
        
        wp_localize_script( 'ts-ets-js', 'ets_strings', array(
            'upload_title' => $this->upload_title,
            'upload_add' => $this->upload_add,
            'confirm' => $this->confirm_str,
        ) );
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::thumb_column()
     *
     * @param       Columns
     *
     * The action which is added to the post row actions
     * @since 1.0
     */
    public function add_column( $columns ) {
        
        $columns['ts-ets-option'] = __( 'Thumbnail', 'ts_ets' );
        return $columns;
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::thumb_column()
     *
     * @param       Column
     * @param       Post ID
     *
     * The column display
     * @since 1.0
     */
    public function thumb_column( $column, $id ) {
        
        switch( $column ) {
            case 'ts-ets-option':
                
                if( has_post_thumbnail() ) {
                    the_post_thumbnail( 'ts-ets-thumb' );
                    echo '<br>';
                    echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->change_str );
                    echo sprintf( ' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr( $id ), $this->remove_str );
                } else {
                    echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->add_new_str );
                }
                
                break;
        }
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::update()
     *
     * AJAX Callback for updating post thumbnail
     * @since 1.0
     */
    public function update() {
        
        // Check if all required data are set or not
        if( !isset( $_POST['nonce'] ) || !isset( $_POST['post_id'] ) || !isset( $_POST['thumb_id'] ) ) {
            wp_die();
        }
        
        // Verify nonce
        if( !wp_verify_nonce( $_POST['nonce'], 'ts_ets_nonce' ) ) {
            wp_die();
        }
        
        $id = $_POST['post_id'];
        $thumb_id = $_POST['thumb_id'];
        
        set_post_thumbnail( $id, $thumb_id );
        
        echo wp_get_attachment_image( $thumb_id, 'ts-ets-thumb' );
        echo '<br>';
        echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->change_str );
        echo sprintf( ' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr( $id ), $this->remove_str );
        
        wp_die();
        
    }
    
    /**
     * TS_Easy_Thumbnail_Switcher::remove()
     *
     * AJAX Callback for removing post thumbnail
     * @since 1.0
     */
    public function remove() {
        
        // Check if all required data are set or not
        if( !isset( $_POST['nonce'] ) || !isset( $_POST['post_id'] ) ) {
            wp_die();
        }
        
        // Verify nonce
        if( !wp_verify_nonce( $_POST['nonce'], 'ts_ets_nonce' ) ) {
            wp_die();
        }
        
        $id = $_POST['post_id'];
        
        delete_post_thumbnail( $id );
        
        echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->add_new_str );
        
        wp_die();
        
    }
    
}

new TS_Easy_Thumbnail_Switcher();