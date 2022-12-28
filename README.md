# Listen to this Article

Automatically adds a "Listen to this article" feature to all of your blog posts on desktop views.

## Installation

1. Download the plugin files and upload them to your WordPress site's `wp-content/plugins` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. The "Listen" and "Stop" buttons will automatically be added to the bottom of your blog posts.

Play and Stop icons provided by Font Awesome website (https://fontawesome.com/)

## Configuration

You can customize the plugin's behavior by modifying the `listen_to_this_article()` function in the `listen-to-this-article.php` file.

## Compatibility

This plugin has been tested and is compatible with the following browsers:

- Google Chrome (desktop)
- Mozilla Firefox (desktop)
- Microsoft Edge (desktop)

Should browser support improve for the Web Speech API on mobile devices in the future remove styling to enable for mobile devices. 

      <style>
        @media (max-width: 768px) {
          #listen-button, #stop-button {
            display: none;
          }
        }
      </style>

## Support

If you encounter any issues with this plugin, please file a bug report in the [issues](https://github.com/bferdi/listen-to-this-article/issues) section.

However this is not a supported project as its just something i created one afternoon so user support is appreciated.

## Credits

This plugin was created by [Ben Ferdinands](https://github.com/bferdi).

if you like this and want to keep me caffinated use the link below 

https://www.buymeacoffee.com/benferdinands
