=== Featured Image Warning ===
Contributors: satoru2727
Tags: featured image, thumbnail, warning, editor, reminder
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Warns editors when a post is missing a featured image, in both the Classic Editor and Block Editor.

== Description ==

**Featured Image Warning** displays a warning notice in the WordPress post editor whenever a featured image (thumbnail) has not been set.

This helps content editors remember to add a featured image before publishing, reducing the chance of posts going live without one.

= Features =

* Works with the **Block Editor (Gutenberg)**: shows a warning in the pre-publish panel and in the post status sidebar.
* Works with the **Classic Editor**: shows an admin notice at the top of the edit screen.
* Automatically skips post types that do not support featured images.
* Lightweight — no settings page, no database queries beyond standard WordPress functions.

= Supported languages =

* English
* Japanese (日本語)

== Installation ==

1. Upload the `featured-image-warning` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress Plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. That's it! Open any post or page that supports featured images and edit it — you'll see a warning if no featured image is set.

== Frequently Asked Questions ==

= Does this work with custom post types? =

Yes. The plugin automatically detects whether a post type supports featured images (`thumbnail`) and only shows the warning for those post types.

= Can I disable the warning for specific post types? =

Not through a settings UI currently. You can use the `fiw_supported_post_types` filter (coming in a future release) or simply remove the support via `remove_post_type_support()`.

= Will this prevent publishing without a featured image? =

No. The warning is informational only and does not block publishing.

== Screenshots ==

1. Warning displayed in the Block Editor pre-publish panel.
2. Warning displayed in the Block Editor sidebar (post status area).
3. Warning displayed in the Classic Editor.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.
