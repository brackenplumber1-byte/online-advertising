<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-site-verification" content="WUjHFBj1QZanei3efkghEAEJoZJN8n3u_BPlOw7ikpU" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part('template-parts/topbar'); ?>
<?php get_template_part('template-parts/nav'); ?>
