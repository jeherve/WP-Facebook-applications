<?php
/**
 * This template acts as template file for the werewp_fbapp custom post type
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<base target="_blank">
<title><?php wp_title(); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 

	// Start loop
	if ( have_posts() ) while ( have_posts() ) : the_post();

	// Call Facebook SDK
	include_once 'lib/facebook.php';

	// Define App ID and secret from custom fields
	$app_id = get_post_meta(get_the_id(), "appid", true);
	$app_secret = get_post_meta(get_the_id(), "appsecret", true);
	$facebook = new Facebook(array(
	'appId' => $app_id,
	'secret' => $app_secret,
	'cookie' => true
	));

	$signed_request = $facebook->getSignedRequest();

	// Get necessary values for fan differenciation
	$page_id = $signed_request["page"]["id"];
	$page_admin = $signed_request["page"]["admin"];
	$like_status = $signed_request["page"]["liked"];
	$country = $signed_request["user"]["country"];
	$locale = $signed_request["user"]["locale"];

?> 
<?php if ($like_status) : ?>
	
	<div class="container clearfix">
	
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

		<?php the_content(); ?>
		
		<?php if ( get_post_meta($post->ID, 'fbcomments', true) ) : ?>
			<fb:comments href="<?php the_permalink(); ?>" num_posts="<?php echo get_post_meta($post->ID, 'fbcomments', true) ?>" width="488"></fb:comments>			
		<?php endif; ?>
		
		</div>
	
	</div><!-- .container -->

<?php else : ?>

	<?php if ( has_post_thumbnail() ) : ?>
	
		<div class="photo clearfix">	
			<?php the_post_thumbnail( 'fb-nonfans' ); ?>	
		</div><!-- .photo -->
	
	<?php else : ?>
	
		<div class="container clearfix">	
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php the_content(); ?>
			</div>	
		</div><!-- .container -->
	
	<?php endif; ?>	

<?php endif; ?>	

<?php /* End loop */ endwhile; ?>

<div id="fb-root"></div>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '<?php echo $facebook->getAppId(); ?>',
				channelUrl : '<?php echo plugins_url( 'wp-facebook-applications/lib/channel.php' , __FILE__ ); ?>', // Channel File
				session    : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
				status     : true, // check login status
				cookie     : true, // enable cookies to allow the server to access the session
				xfbml      : true, // parse XFBML
				oauth      : true
			});
		
			// whenever the user logs in, we refresh the page
			FB.Event.subscribe('auth.login', function() {
				window.location.reload();
			});
			
			// Auto resize of the page
			FB.Canvas.setAutoResize();
		};
			
		// Do things that will sometimes call sizeChangeCallback()
		function sizeChangeCallback() {
			FB.Canvas.setAutoResize();
		}
		
		// Load SDK asynchronously
		(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));
	</script>

<?php wp_footer(); ?>
</body>
</html>