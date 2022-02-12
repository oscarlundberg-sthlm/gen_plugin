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
            add_action('init', array($this, 'enqueue_style'));
        }

        public function enqueue_style() {
            wp_enqueue_style('generation_blog_feed_style', plugin_dir_url( __FILE__ ) . '/style.css');
        }

        public function shortcode_init() {
            add_shortcode('generation_blog_feed', array($this, 'generation_blog_feed_shortcode_handler')); // "callable"
        }

        public function display( $query ) {
            if ( $query->have_posts() ) {
                ob_start();

                ?>
                <div class="blog-feed-container">
                    <div class="blog-feed-listing">
                    <?php
                        while( $query->have_posts() ) {
                            //build post
                            $query->the_post(); ?>
                            <div class="blog-feed-single-post">
                                <h2><?php echo wp_kses_post(get_the_title()) ?></h2>
                                <?php echo wp_kses_post(get_the_content()) ?>
                            </div>
                            <?php
                        }
                    ?>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
            return ob_get_clean();
        }

        public function generation_blog_feed_shortcode_handler( $atts = array() ) {

            $atts = array_map('intval', $atts);

            [
                'category_id' => $category_id,
                'posts_per_page' => $posts_per_page,
                'offset'=>$offset
            ] = $atts;

            $query = new WP_Query( array( 
                'category_id' =>  $category_id,
                'posts_per_page' =>  $posts_per_page,
                'offset' => $offset,
            ) );

            echo '<script>console.log(' . json_encode($query) . ')</script>';

            $generatedContent = $this->display( $query );

            return $generatedContent;
        }
    }    

    if ( !isset( $instance_of_generation_blog_feed_shortcode_plugin ) ) {
        $instance_of_generation_blog_feed_shortcode_plugin = new generation_blog_feed_shortcode_plugin;
    }
}