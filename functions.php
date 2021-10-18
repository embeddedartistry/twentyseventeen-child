<?php

function child_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function twentyseventeen_entry_footer() {

	/* translators: Used between list items, there is a space after the comma. */
	$separate_meta = __( ', ', 'twentyseventeen' );

	$post_type = get_post_type();

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	if($post_type === 'glossary')
	{
		$categories_list = get_the_term_list(0, 'glossary-categories', '', $separate_meta);
		$tags_list = get_the_term_list(0, 'glossary-tags', '', $separate_meta);
	}

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( twentyseventeen_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

		if ( 'post' === $post_type ||
			 'fieldatlas' === $post_type ||
			 'newsletters' === $post_type ||
			 'glossary' === $post_type ||
			 'course' === $post_type
		   ) {
			if ( ( $categories_list && twentyseventeen_categorized_blog() ) || $tags_list ) {
				echo '<span class="cat-tags-links">';

				// Make sure there's more than one category before displaying.
				if ( $categories_list && twentyseventeen_categorized_blog() ) {
					echo '<span class="cat-links">' . twentyseventeen_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'twentyseventeen' ) . '</span>' . $categories_list . '</span>';
				}

				if ( $tags_list && ! is_wp_error( $tags_list ) ) {
					echo '<span class="tags-links">' . twentyseventeen_get_svg( array( 'icon' => 'hashtag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'twentyseventeen' ) . '</span>' . $tags_list . '</span>';
				}

				echo '</span>';
			}
		}

		twentyseventeen_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}

?>
