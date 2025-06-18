<?php
/*
Plugin Name: Law Firm Reviews
Description: Collect and display law firm reviews. Optimized for law firm marketing with MileMark.
Version: 1.0
Author: Example Author
*/

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Register custom post type for reviews
function lfr_register_review_post_type() {
    $labels = array(
        'name'               => 'Law Firm Reviews',
        'singular_name'      => 'Law Firm Review',
        'add_new'            => 'Add New Review',
        'add_new_item'       => 'Add New Law Firm Review',
        'edit_item'          => 'Edit Law Firm Review',
        'new_item'           => 'New Law Firm Review',
        'all_items'          => 'All Law Firm Reviews',
        'view_item'          => 'View Review',
        'search_items'       => 'Search Reviews',
        'not_found'          => 'No reviews found',
        'not_found_in_trash' => 'No reviews found in Trash',
        'menu_name'          => 'Law Firm Reviews'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'author' ),
        'rewrite'            => array( 'slug' => 'law-firm-review' ),
    );

    register_post_type( 'lawfirm_review', $args );
}
add_action( 'init', 'lfr_register_review_post_type' );

// Shortcode to display reviews
function lfr_reviews_shortcode() {
    $query = new WP_Query( array( 'post_type' => 'lawfirm_review', 'posts_per_page' => -1 ) );
    if ( ! $query->have_posts() ) {
        return '<p>No law firm reviews found.</p>';
    }

    $output = '<div class="lawfirm-reviews-list">';
    while ( $query->have_posts() ) {
        $query->the_post();
        $output .= '<div class="lawfirm-review">';
        $output .= '<h3>' . esc_html( get_the_title() ) . '</h3>';
        $output .= '<div>' . wp_kses_post( get_the_content() ) . '</div>';
        $output .= '</div>';
    }
    wp_reset_postdata();
    $output .= '</div>';

    return $output;
}
add_shortcode( 'lawfirm_reviews', 'lfr_reviews_shortcode' );

?>
