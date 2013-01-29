<?php
	get_header(); // get the header.php file	
?>

	<div id="header-wrapper">	
		<header class="container">
			<div id="logo-area">
				<a href="<?php echo home_url("/"); ?>"><img src="<?php echo THEME_DIR; ?>/images/logo.png" alt="Logo" /></a>
			</div> <!-- #logo-area -->
			
			<div id="image-logo">
				<img src="<?php echo THEME_DIR; ?>/images/image-logo.png" />
			</div><!--image-logo-->
			
			<div class="social-icons">	
				<ul>
					<li><a href="#" class="facebook"><img src="<?php echo THEME_DIR; ?>/images/facebook_icon.png" /></a></li>
					<li><a href="#" class="twitter"><img src="<?php echo THEME_DIR; ?>/images/twitter_icon.png" /></a></li>
					<li><a href="#" class="pass"><img src="<?php echo THEME_DIR; ?>/images/icon_icon.png" /></a></li>
					<li><a href="#" class="skype"><img src="<?php echo THEME_DIR; ?>/images/skype_icon.png" /></a></li>
					<li><a href="#" class="youtube"><img src="<?php echo THEME_DIR; ?>/images/youtube_icon.png" /></a></li>
					
				</ul>
			</div>	<!-- social icons -->
			<div class="clear clearboth"></div>
		</header><!--header-->
		
		<div id="nav-wrapper">
			<nav class="container">
				<ul>
					<li><a href="#">HOME</a></li>
					<li><a href="#">ABOUT</a></li>
					<li><a href="#">WORK</a></li>
					<li><a href="#">BLOG</a></li>
					<li><a href="#">PRICE</a></li>
					<li><a href="#">CONTACT</a></li>
				</ul>
			</nav> <!-- nav -->
		</div><!-- nav-wrapper -->
	</div><!--#header-wrapper-->
	
	<div id="main-wrapper">
		<div id="main" class="container">
			<div class="content content-left">
				content left
			</div><!--content content left-->
			
			<div class="sidebar sidebar-right">
				sidebar right
			</div><!--sidebar sidebar right-->
			<div class="clear clearboth"></div>
		</div><!--main-->
	</div><!--main-wrapper-->
<?php
	get_footer(); // get the footer.php file	
?>