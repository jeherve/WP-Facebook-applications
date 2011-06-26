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