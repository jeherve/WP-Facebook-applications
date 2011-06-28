<?php
/**
 * This template acts as template file for the werewp_fbapp custom post type
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" <?php language_attributes(); ?> >
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
    <script>
		window.fbAsyncInit = function() {
        	FB.init({
          		appId   : '<?php echo $facebook->getAppId(); ?>',
          		session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          		status  : true, // check login status
          		cookie  : true, // enable cookies to allow the server to access the session
          		xfbml   : true // parse XFBML
        	});

        	// whenever the user logs in, we refresh the page
        	FB.Event.subscribe('auth.login', function() {
          		window.location.reload();
       		});
       
       		// Auto resize of the page
        	FB.Canvas.setAutoResize();
      	};
      
		function sizeChangeCallback() {
			FB.Canvas.setAutoResize();
	  	}
	  
	  	// fb.ui features
	  	function streamPublish() {
			FB.ui({ 
				method: 'stream.publish',
				messagePrompt: 'Do you want to share this page to your Facebook Wall?',
				userMessage: 'Check these amazing JS SDK tutorials',
				message: ' ',
				name: 'my great web site',
				caption: 'web design',
				description: ( ' The quick brown fox ' + ' jumps over the lazy dog. ' + ' English-language pangram ' ),
				link: 'http://www.my url',
				picture: 'http://www.my image url',
				actions: [{ 
					name: 'visit now', 
					link: 'http://www.my url'
				}],
				user_message_prompt: 'Share'
			},
			function(response) {
				if (response && response.post_id) {
					//alert('thanks for sharing');
				} else {
					//alert('Post was not published.');
				}
			}
			);
		}

      	(function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      	}());
    </script>    

<?php wp_footer(); ?>
</body>
</html>