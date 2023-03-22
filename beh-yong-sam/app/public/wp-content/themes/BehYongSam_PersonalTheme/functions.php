<?php 

function personal_theme() {
    wp_enqueue_style('bootstrap1', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');
    wp_enqueue_style('BehYongSamThemes', get_stylesheet_uri());
    wp_enqueue_script('jssc', 'https://code.jquery.com/jquery-3.6.0.min.js');
}

add_action('wp_enqueue_scripts', 'personal_theme');