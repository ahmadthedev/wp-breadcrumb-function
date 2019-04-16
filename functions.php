<?php
// Wordpress Breadcrumb Function
// This code add into your theme function file.

// Updated form of https://gist.github.com/tinotriste/5387124

function dv_breadcrumb() {
	$sep = "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
  if ( !is_front_page() ) { // Check if it is not home page
		// Start the breadcrumb with a link to your homepage
    echo '<div class="breadcrumb">';
    echo '<a href="';
    echo get_option('home');
    echo '">';
    bloginfo('name');
    echo '</a>' . $sep;

		if( is_category() || is_single() ) {
			the_category(' / ');
			if ( is_single() ) {
				echo $sep;
				the_title();
			}
		} elseif ( is_archive() || is_single() ) {
        if ( is_day() ) {
            printf( __( '%s', 'text_domain' ), get_the_date() );
        } elseif ( is_month() ) {
            printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
        } elseif ( is_year() ) {
            printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
        } elseif ( is_author() ){
						printf( __( '%s', 'text_domain' ), get_the_author() );
				} else {
            _e( 'Blog Archives', 'text_domain' );
        }
    } elseif ( is_single() ) {
        echo $sep;
        the_title();
    } elseif ( is_page() ) {
				echo $sep;
				echo the_title();
		} elseif ( is_search() ) {
				echo $sep . "Search Results for ";
				echo '"<em>';
				echo the_search_query();
				echo '</em>"';
		} elseif ( is_404() ) {
				echo "404 Page Not Found";
		} elseif ( is_home() ) {
      global $post;
      $page_for_posts_id = get_option('page_for_posts');
      if ( $page_for_posts_id ) {
        $post = get_page($page_for_posts_id);
        setup_postdata($post);
        the_title();
        rewind_posts();
      }
    }

    echo '</div>';
	}
}
