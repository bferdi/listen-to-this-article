<?php
/*
Plugin Name: Listen to this Article
Description: Automatically adds a "Listen to this article" feature to all of your blog posts on desktop devices.
Version: 1.0
Author: Ben Ferdinands
*/

// Enqueue Font Awesome library
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', plugin_dir_url(__FILE__) . 'fontawesome/css/all.min.css');
  }
  add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Register the "disable" custom field
register_meta('post', 'disable', array(
  'show_in_rest' => true,
  'single' => true,
  'type' => 'string',
));


// Add the meta box
function listen_to_this_article_meta_box() {
  add_meta_box(
    'listen-to-this-article-meta-box', // ID of the meta box
    'Listen to this article', // Title of the meta box
    'listen_to_this_article_meta_box_callback', // Callback function
    'post', // Post type
    'side', // Context
    'default' // Priority
  );
}
add_action('add_meta_boxes', 'listen_to_this_article_meta_box');

// Display the "disable" custom field in the post editor
function listen_to_this_article_meta_box_callback($post) {
  $value = get_post_meta($post->ID, 'disable', true);
  ?>
  <p>
    <label for="disable">
      <input type="checkbox" name="disable" id="disable" value="1" <?php checked($value, 1); ?>>
      Disable "Listen to this article" feature for this post
    </label>
  </p>
  <?php
}
add_action('add_meta_boxes', 'listen_to_this_article_meta_box');

// Save the value of the "disable" custom field when the post is saved
function listen_to_this_article_save_meta_box($post_id) {
  if (array_key_exists('disable', $_POST)) {
    update_post_meta(
      $post_id,
      'disable',
      $_POST['disable']
    );
  } else {
    delete_post_meta($post_id, 'disable');
  }
}
add_action('save_post', 'listen_to_this_article_save_meta_box');

// Check if the "disable" custom field is set
function listen_to_this_article_check_disabled($content) {
  $disable = get_post_meta(get_the_ID(), 'disable', true);
  if (!empty($disable)) {
    // "Listen to this article" feature is disabled for this post
    return $content;
  }
	
// Save the value of the "disable" custom field when the post is saved

add_action('save_post', 'listen_to_this_article_save_meta_box');
  // "Listen to this article" feature is not disabled for this post
  return listen_to_this_article($content);
}
add_filter('the_content', 'listen_to_this_article_check_disabled');
  
  function listen_to_this_article($content) {
	    // Check if the "disable" custom field is set
  $disable = get_post_meta(get_the_ID(), 'disable', true);
  if (!empty($disable)) {
    // "Listen to this article" feature is disabled for this post
    return $content;
  }
    if (!isset($speechSynthesis)) {
      // TTS is supported
      $listen_button = '<button id="listen-button"><i class="fas fa-play"></i></button>';
      $stop_button = '<button id="stop-button"><i class="fas fa-stop"></i></button>';
    $listen_script = '
	      <style>
        @media (max-width: 768px) {
          #listen-button, #stop-button {
            display: none;
          }
        }
      </style>
      <script>
        speechSynthesis.onvoiceschanged = function() {
          // TTS is supported
       document.getElementById("listen-button").addEventListener("click", function() {
            var content = document.querySelector(".entry-content").textContent;
            var msg = new SpeechSynthesisUtterance();
            msg.text = content;
            window.speechSynthesis.speak(msg);
          });
          document.getElementById("stop-button").addEventListener("click", function() {
            window.speechSynthesis.cancel();
          });
        };
      </script>
    ';

    $content .= $listen_button . $stop_button . $listen_script;
  } else {
    // TTS is not supported
    $error_message = '<p>Sorry, your browser does not support the text-to-speech feature.</p>';
    $content .= $error_message;
  }

  return $content;
}

	

