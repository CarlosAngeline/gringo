<?php

	// DEFINE THEME DIRECTORY
	define("THEME_DIR", get_template_directory_uri());
	
	/*--- REMOVE GENERATOR META TAG ---*/
	remove_action('wp_head', 'wp_generator');
	
	/*--- SUPPORT TO LANGUAGES ---*/
	
	load_theme_textdomain( 'atom', TEMPLATEPATH.'/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH."/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
	
	/*== ENQUEUE STYLES ==**/
	
	function enqueue_styles() {
		if(!is_admin()) :
			wp_register_style( 'Cabin-font', 'http://fonts.googleapis.com/css?family=Cabin:400,700', array(), '1', 'all' );
			wp_enqueue_style( 'Cabin-font' );
			
			wp_register_style( 'base-style', THEME_DIR . '/css/base.css', array(), '1', 'all' );
			wp_enqueue_style( 'base-style' );
			
			wp_register_style( 'skeleton-style', THEME_DIR . '/css/skeleton.css', array(), '1', 'all' );
			wp_enqueue_style( 'skeleton-style' );
			
			wp_register_style( 'layout-style', THEME_DIR . '/css/layout.css', array(), '1', 'all' );
			wp_enqueue_style( 'layout-style' );
			
			//wp_enqueue_style("main-style", THEME_DIR ."/style.css", false, "1.0", "all");
		endif;
	}
	add_action( 'init', 'enqueue_styles' );
	
	/*== ENQUEUE SCRIPTS ==**/
	
	function enqueue_scripts() {
		if(!is_admin()) :
			/** REGISTER js/jquery.js **/
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array(), null, false );
			wp_enqueue_script( 'jquery' );
			
			wp_register_script( 'html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array(), null, false );
			wp_enqueue_script( 'html5-shim' );
			
			//wp_enqueue_script( 'search-box', get_template_directory_uri() . '/js/init.js', array('jquery'), NULL );
		endif;
	}
	add_action( 'init', 'enqueue_scripts' );

	/*== ENABLE CUSTOM MENUS ==**/
	if ( function_exists( 'register_nav_menu' ) ) {
	
		register_nav_menu( 'main_menu', 'Main Menu' );

	}
	
	/*== SIDEBARS WIDGET AREAS ==**/
	
	register_sidebar( array(
		'id'          => 'right-sidebar',
		'name'        => 'Right Sidebar',
		'description' => 'Displayed at content\'s right on pages like: Blog, Single Post and Page with Sidebar.',
		'before_title'  => '<h3 class="widgettitle"><span>',
		'after_title'   => '</span></h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
	
	add_filter('widget_text', 'do_shortcode');
	
	/**== BLOG POSTS ==**/
	
	if (function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	}
	
	if ( function_exists( 'add_image_size' ) ) { 
		/* TEMPLATE - add_image_size( 'blog-size', 700, 290 );	*/
	}
	
	/**== BREADCRUMBS ==**/
	
	function the_breadcrumbs() {
 
		$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter = ''; // delimiter between crumbs
		$home = 'Home'; // text for the 'Home' link
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before = '<em class="active">'; // tag before the current crumb
		$after = '</em>'; // tag after the current crumb
		 
		global $post;
		$homeLink = get_bloginfo('url');
		 
		if (is_home() || is_front_page()) {
		 
			if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
		 
		} else {
		 
			echo '<p id="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		 
			if ( is_category() ) {
			  global $wp_query;
			  $cat_obj = $wp_query->get_queried_object();
			  $thisCat = $cat_obj->term_id;
			  $thisCat = get_category($thisCat);
			  $parentCat = get_category($thisCat->parent);
			  if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			  echo $before . __('Archive by category "', 'atom') . single_cat_title('', false) . '"' . $after;
		 
			} elseif ( is_day() ) {
			  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			  echo $before . get_the_time('d') . $after;
		 
			} elseif ( is_month() ) {
			  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			  echo $before . get_the_time('F') . $after;
		 
			} elseif ( is_year() ) {
			  echo $before . get_the_time('Y') . $after;
		 
			} elseif ( is_single() && !is_attachment() ) {
			  if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			  } else {
				$cat = get_the_category(); $cat = $cat[0];
				echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			  }
		 
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			  $post_type = get_post_type_object(get_post_type());
			  echo $before . $post_type->labels->singular_name . $after;
		 
			} elseif ( is_attachment() ) {
			  $parent = get_post($post->post_parent);
			  $cat = get_the_category($parent->ID); $cat = $cat[0];
			  echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			  if ($showCurrent == 1) echo $before . get_the_title() . $after;
		 
			} elseif ( is_page() && !$post->post_parent ) {
			  if ($showCurrent == 1) echo $before . get_the_title() . $after;
		 
			} elseif ( is_page() && $post->post_parent ) {
			  $parent_id  = $post->post_parent;
			  $breadcrumbs = array();
			  while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			  }
			  $breadcrumbs = array_reverse($breadcrumbs);
			  foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			  if ($showCurrent == 1) echo $before . get_the_title() . $after;
		 
			} elseif ( is_search() ) {
			  echo $before . __('Search results for "', 'atom') . get_search_query() . '"' . $after;
		 
			} elseif ( is_tag() ) {
			  echo $before .  __('Posts tagged "', 'atom') . single_tag_title('', false) . '"' . $after;
		 
			} elseif ( is_author() ) {
			   global $author;
			  $userdata = get_userdata($author);
			  echo $before .  __('Articles posted by ', 'atom') . $userdata->display_name . $after;
		 
			} elseif ( is_404() ) {
			  echo $before .  __('Error 404', 'atom') . $after;
			}

			echo '</p>';
		  }
	}
	
	/*== PAGINATION ==*/
	
	function nav_pagination($range = 2, $pages = '' )
	{  
		$showitems = ($range * 2)+1;  

		global $paged;
		if(empty($paged)) $paged = 1;

		if($pages == '')
		{
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages)
			{
				$pages = 1;
			}
		}   

		if(1 != $pages)
		{
			echo '<p class="pagination">';
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&lt;</a>";
			if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&gt;</a>";

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					 echo ($paged == $i)? "<a class='active'>".$i."</a>":"<a href='".get_pagenum_link($i)."'>".$i."</a>";
				}
			}

			if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			echo "</p>\n";
		}
	}
		
?>