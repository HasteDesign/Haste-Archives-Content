<?php
/**
 * Return the post {object} related to the current post type archive in the archives post_type
 *
 * @return object or null
 */
function haste_archive_content() 
{
    $content = null;

    if ( is_post_type_archive() )
	{
        $type = get_query_var( 'post_type' );
        $data = get_post_type_object( $type );
        $slug = $data->rewrite['slug'];

        if( !empty( $slug ) )
		{
            $args = array(
                        'post_type'         => 'archives',
                        'name'              => $slug . '-archive',
                        'posts_per_page'    => 1
            );
            
            $content = get_posts( $args );
			return $content[0];
        }
    }
    return null;
}

/**
 * Return the post {object} of the archive post of the given post type slug passed as parameter
 *
 * @return object or null
 */
function get_haste_archive_content( $post_type )
{
	echo $post_type;
	
    $content = null;

    if ( post_type_exists( $post_type ) )
	{
		$args = array(
					'post_type'         => 'archives',
					'name'              => $post_type . '-archive',
					'posts_per_page'    => 1
		);
		
		$content = get_posts( $args );
		return $content[0];
    }
    return null;
}
?>