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
  
  function listen_to_this_article($content) {
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

add_filter('the_content', 'listen_to_this_article');
