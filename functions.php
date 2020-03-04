<?php
// Wordpress Breadcrumb Function
// This code add into your theme function file.


function dv_breadcrumb() {
  $sep = "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
  if ( !is_front_page() ) {
  // Start the breadcrumb with a link to your homepage
  echo '<div class="breadcrumb">';
  echo '<a href="';
  echo get_option('home');
  echo '">';
  bloginfo('name');
  echo '</a>' . $sep;

  if( is_category() || is_single() ) {
   $terms = get_the_terms( get_the_ID(), 'category' );
   $cats_breadcrumbs = array();
   $bread_items = array();
   foreach ( (array) $terms as $key => $term ) {
     if ( !empty( $term ) ) {
       $term_parent = array();
       $parent = get_term_by('id', $term->term_id, 'category');
       // climb up the hierarchy until we reach a term with parent = '0'
       $term_parent[] = $parent;

       if ( isset( $parent->parent ) ) {
         while ( $parent->parent != '0' ) {
           $parent = get_term_by('id', $parent->parent, 'category');
           $term_parent[] = $parent;
         }
         $term_parent = array_reverse( $term_parent );
         foreach ( (array) $term_parent as $k => $trm ) {
           if ( !isset($cats_breadcrumbs[$key] ) || !is_array( $cats_breadcrumbs[$key] ) ) {
             $cats_breadcrumbs[$key] = array();
           }
           if ( !in_array( $trm->slug, $bread_items ) ) {
              $term_link = get_term_link( $trm, 'category');
              $cats_breadcrumbs[$k][$key] = '<a href="'  .$term_link . '">' . ( $trm->name ) . '</a>' . $sep;
              $bread_items[] = $trm->slug;
           }
         }
       }
     }
   }
   foreach ($cats_breadcrumbs as $cat) {
       echo implode(' ', $cat);
   }
   if ( is_single() ) {
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
   the_title();
  } elseif ( is_page() ) {
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
