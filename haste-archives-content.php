<?php
/**
 * Plugin Name: Haste Archives Content
 * Plugin URI: 
 * Description: A Plugins to create archives content insertion pages.
 * Version: 1.0
 * Author: Allyson Souza
 * Author URI: http://www.hastedesign.com.br
 * License: GPL2
 */
namespace haste_ac;

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

if ( ! class_exists( 'ArchivesContent' ) ) 
{
    class ArchivesContent {
        protected static $instance;
        private $post_types;
        private $author_ID;
        
        public function __construct() {
            //Get all the registered post types of the site
            add_action( 'init', array( &$this, 'set_the_post_types' ), 60 );

            //Call the post type Archives creation function
            add_action( 'init', array( &$this, 'create_post_type' ), 80 );

            //Create archives posts for each custom post type created
            add_action( 'init', array( &$this, 'create_posts' ), 100 );
            
            //Get current archive content
            add_filter( 'haste_archive_content', array( &$this, 'archive_content' ) );
            
            // includes
            $this->include_before_theme();
        }
        
        public static function init()
        {
            is_null( self::$instance ) AND self::$instance = new self;
            return self::$instance;
        }

        /**
         * Creates the Archive Content post type
         *
         * @return void
         */
        public function set_the_post_types() {
            $args = array(
               '_builtin' => false
            );

            $this->post_types = get_post_types( $args, 'objects' );

            unset($this->post_types['archives']);
        }

        /**
         * Creates the Archive Content post type
         *
         * @return void
         */
        public function create_post_type() {
            $labels = array(
                'name'               => 'Archives',
                'singular_name'      => 'Archive',
                'menu_name'          => 'Archives',
                'name_admin_bar'     => 'Archives',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Archive',
                'new_item'           => 'New Archive',
                'edit_item'          => 'Edit Archive',
                'view_item'          => 'View Archive',
                'all_items'          => 'All Archives',
                'search_items'       => 'Search Archives',
                'parent_item_colon'  => '',
                'not_found'          => 'No archive found.',
                'not_found_in_trash' => 'No archives found in trash.'
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'exclude_from_search'=> true,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_nav_menus'  => false,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => 60,
                'has_archive'        => false,
                'can_export'         => false,
                'menu_icon'          => 'dashicons-archive',
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
                'capabilities'       => array( 
                    'edit_post' => true,
                    'edit_posts' => 'edit_posts',
                    'edit_others_posts' => 'edit_other_posts',
                    'publish_posts' => 'publish_posts',
                    'read_post' => 'read_post',
                    'read_private_posts' => 'read_private_posts',
                    'delete_post' => true,
                    'create_posts' => false,
                ),
                'map_meta_cap' => true, //Set to false, if users are not allowed to edit/delete existing posts
            );

            register_post_type( 'archives', $args );
        }

        /**
        * Programmatically create Archives posts.
        *
        * @returns -1 if the post was never created, -2 if a post with the same title exists, or the ID
        *          of the post if successful.
        */
        public function create_posts() {

            foreach( $this->post_types as $post_type ) {
                // Setup the author, slug, and title for the post
                $author_ID = 1;
                $slug = $post_type->rewrite['slug'] . '-archive';
                $title = $post_type->label . ' Archive';

                $page = get_page_by_title( $title, 'OBJECT', 'archives' );             
                
                // If the page doesn't already exist, then create it
                if( empty( $page ) ) {
                    wp_insert_post(
                        array(
                            'comment_status'	=>	'closed',
                            'ping_status'		=>	'closed',
                            'post_author'		=>	$author_ID,
                            'post_name'		    =>	$slug,
                            'post_title'	    =>	$title,
                            'post_status'		=>	'publish',
                            'post_type'		    =>	'archives',
                            'wp_error'          =>  true
                        )
                    );
                }
            }
        }
        
        function include_before_theme() {
            include_once('core/api.php');
        }
        
        /**
         * Delete the Archives posts from database
         *
         * @return void
         */
        public static function on_uninstall() {
            $wpdb->query( 
                $wpdb->prepare( "DELETE FROM $wpdb->posts WHERE post_type = %s", 'archives' )
            );
        }
    }
}

register_uninstall_hook( __FILE__ , array( 'haste_ac\ArchivesContent', 'on_uninstall') );

add_action( 'plugins_loaded', array( 'haste_ac\ArchivesContent', 'init' ) );
?>