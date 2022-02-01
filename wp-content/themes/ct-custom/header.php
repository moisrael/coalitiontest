<?php

	/**
	 * The header for our theme
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package CT_Custom
	 */
	
    global $post;
    
    $post_type = get_post_type($post);
    $page = $post;
    $parent_page_ID = $page->post_parent;
	$front_page_ID = get_option('page_on_front');
    $posts_page_ID = get_option('page_for_posts');

?>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>
<body>
<div class="container">
        <!-- Header -->
        <div class="header-container top-fix">
            <!-- Top Header -->
            <div class="top-header white-links">
                <div class="centre-content flex-horizontal">
                    <p>Call us now! <a href="tel:385154112835" class="call-link"><?php echo get_option('phone_number'); ?></a></p>
                    <div class="user-access-links">
                    <?php if (is_user_logged_in()) {
                            if (current_user_can('delete_posts')) {?>
                        <a href="<?php echo get_dashboard_url(); ?>">Dashboard</a>
                        <?php } ?>
                        <a href="<?php echo wp_logout_url(); ?>">Log out</a>
                    <?php
                        } else {?>
                            <a href="<?php echo wp_login_url(); ?>">Login</a>
                            <a href="<?php echo wp_registration_url(); ?>">Sign up</a>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Main Header -->
            <div class="main-header">
                <div class="centre-content flex-horizontal">
                    <h1 class="logo">
                    <?php

                        $logo_image_src = get_option('website_logo');
                    
                    ?>
                        <a href="<?php echo get_home_url(); ?>">
                            <?php
                            
                            /* Use the custom logo the user uploads as the website logo */
                            if ($logo_image_src) {?>
                            <img src="<?php echo $logo_image_src; ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo"><?php
                            }
                            
                            /* Use the default website logo when no custom logo is selected/uploaded */
                            else {?>
                            <img src="<?php echo get_template_directory_uri() . '/img/ct-test-logo.png'; ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo"><?php
                            }?>
                        </a>
                    </h1>
                    <!-- Main menu -->
					<?php

						wp_nav_menu( array(
							'theme_location' => 'main-menu',
							'container_class' => 'navigation-menu inline-menu',
							'container' => 'nav'
						) );
					
					?>
                    <!-- Mobile menu button -->
                    <div class="menu-toggle-container">
                        <button class="menu-toggle"><span class="lines"></span></button>
                    </div>
                    <!-- Mobile nenu -->
                    <div class="mobile-menu">
                        <div class="centre-content">
                            <nav class="mobile-navigation-menu">
                                <!-- Content loads via JavaScript -->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<?php

			if (!is_front_page() && !is_home()) {
		?>
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <ul class="centre-content flex-horizontal">
                <?php if ($post_type == 'page') {?>
                <li><a href="<?php echo get_permalink($front_page_ID); ?>"><?php echo get_the_title($front_page_ID); ?></a></li>
                <?php } ?>
                <?php if ($post_type == 'post') {?>
                <li><a href="<?php echo get_permalink($posts_page_ID); ?>"><?php echo get_the_title($posts_page_ID); ?></a></li>
                <?php } ?>
                <?php if ($parent_page_ID != $front_page_ID && $parent_page_ID != 0) {?>
                <li><a href="<?php echo get_permalink($parent_page_ID); ?>"><?php echo get_the_title($parent_page_ID); ?></a></li>
                <?php } ?>
                <li class="current"><?php echo get_the_title(); ?></li>
            </ul>
        </div>
		<?php
			}
		?>