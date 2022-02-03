<?php if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Plugin Name: Generation Blog feed
 * Description: Shortcode for displaying blog feed
 * Version: 0.1.0
 * Author: Oscar Lundberg
 * Text Domain: generation-blog-feed
 * Domain Path: /languages
 */

if ( !class_exists( 'generation_blog_feed_shortcode_plugin' ) ) {
    class generation_blog_feed_shortcode_plugin {

        public function __construct() {
            add_action('init', array($this, 'shortcode_init'));
        }

        public function shortcode_init() {
            add_shortcode('generation_blog_feed', array($this, 'generation_blog_feed_shortcode_handler'));
        }

        public function generation_blog_feed_shortcode_handler( $atts = array() ) {
            [
                'category_id' => $category_id,
                'posts_per_page' => $posts_per_page,
                'offset'=>$offset
            ] = $atts;
            return "$category_id, $posts_per_page, $offset";
        }
    }    

    if ( !isset( $instance_of_generation_blog_feed_shortcode_plugin ) ) {
        $instance_of_generation_blog_feed_shortcode_plugin = new generation_blog_feed_shortcode_plugin;
    }
}