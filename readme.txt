=== WP-Facebook applications ===
Contributors: hd-J
Donate link: http://jeremy.tagada.hu
Tags: facebook, application, campaign, tab, custom post type, custom fields
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 0.3

Create custom tabs for your Facebook pages, hosted on your WordPress blog.

== Description ==

WP-Facebook applications adds a new menu to your WordPress admin panel, and allows you to create new pages to use as iFrame app tabs on your Facebook pages. When creating an application, you define a default landing tab that users will see if they are not fans of your Facebook page, and then you create content that will appear once they are fans. Optionally, you can add a Facebook comments box at the bottom of the content.

Thus you can integrate text, pictures, videos, comment forms, hidden for people who are not fans of your page yet.

Thus plugin allows you to create as many tabs as you wish through WordPress.

For more information, visit: 
* [Page officielle - FR](http://jeremy.tagada.hu/extension-wp-facebook-applications/ "Extension : WP Facebook Applications") 

This plugin is a work in progress. Do not hesitate to send me your remarks, suggestions and ideas for the future version of this plugin.

Please note that this plugin uses the [Facebook PHP SDK](https://github.com/facebook/php-sdk "Facebook PHP SDK")

== Installation ==

1. Upload the complete folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. A new menu now appears in your admin panel, above the 'comments' section. You can add and manage your Facebook tabs from there

= How to create my first Facebook tab? =

1. Go to the *Add new* menu of your Applications menu.
2. [Create a new Facebook application on Facebook](http://www.facebook.com/developers/createapp.php "Create new application")
3. Now that the application is created, you have received an application ID and an application secret. Paste these 2 values into the dedicated fields of your WordPress application page.
4. If you want a Facebook Comments box at the bottom of your content, simply specify how many comments do you want the box to show by default.
5. Enter content that will appear when the user is fan in the content area.
6. Upload the image to see when the user is not a fan, and set this image as *featured image*.
7. Publish this page, note down the URL and change your Facebook application settings to point to that URL.
8. You're done, enjoy!

== Screenshots ==

1. Applications menu in your WordPress install
2. Create new application

== Frequently Asked Questions ==

= How to avoid the scrollbars that show up when I view my tab on Facebook? =

One of the images you have added to your page is too large to fit in the page. All the elements you include in your content should not be larger than 488 pixels.

= When viewing my application tab on Facebook, I get a blank page, or a message telling me to switch to a HTTPS connection =

The only way to solve the issue is to buy an SSL certificate for your domain, and once set, fill in the secure URL for your tab in the applications settings.

== Changelog ==

= 0.3 =
* Added fixed embed width
* Edit Panel meta box now provides walk-through the application's creation

= 0.2 =
* Move files to trunk root to get the plugin to work, beginner's mistake

= 0.1 =
* Initial release

