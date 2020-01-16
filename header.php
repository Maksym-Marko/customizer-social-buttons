<?php

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<header id="masthead" class="site-header" role="banner">

			<!-- social buttons -->
			<?php if( get_theme_mod( 'mx_social_buttons_setting' ) ) : ?>
				<div class="mx-social-buttons-header">

					<?php 

						$social_buttons_array = maybe_unserialize( get_theme_mod( 'mx_social_buttons_setting' ) );

						foreach ($social_buttons_array as $key => $value) { ?>

							<a href="<?php echo $value['url'] ?>"><i class="icon-<?php echo $value['icon'] ?>" data-icon="<?php echo $value['icon'] ?>"></i></a>
							

						<?php } ?>

				</div>
			<?php endif; ?>

		</header><!-- .site-header -->

		<div id="content" class="site-content">
