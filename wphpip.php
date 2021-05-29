<?php
/*
Plugin Name:       WP H-Posts in Pages
Plugin URI:        https://web266.de/software/eigene-plugins/wp-h-posts-in-pages/
Description:       Beitr&auml;ge in Seiten einf&uuml;gen
Author:            Hans M. Herbrand
Author URI:        https://web266.de
Version:           1.0
Date:              2021-03-10
License:           GNU General Public License v2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/m266/wp-h-posts-in-pages/
Credits:           https://ostrich.de/wordpress-beitraege-auf-seite-anzeigen/
Hinweis:           Tag [posts] in der Start-Seite einfuegen
*/

// Externer Zugriff verhindern
defined('ABSPATH') || exit();

//////////////////////////////////////////////////////////////////////////////////////////
// Check GitHub Updater aktiv
// Anpassungen Plugin-Name und Funktions-Name vornehmen
if (!function_exists('is_plugin_inactive')) {
    require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
if (is_plugin_inactive('github-updater/github-updater.php')) {
// E-Mail an Admin senden, wenn inaktiv
register_activation_hook( __FILE__, 'wphpip_activate' ); // Funktions-Name anpassen
function wphpip_activate() { // Funktions-Name anpassen
$subject = 'Plugin "WP H-Posts in Pages"'; // Plugin-Name anpassen
$message = 'Bitte das Plugin "GitHub Updater" hier https://web266.de/tutorials/github/github-updater/ herunterladen, installieren und aktivieren, um weiterhin Updates zu erhalten!';
wp_mail(get_option("admin_email"), $subject, $message );
}
}

//////////////////////////////////////////////////////////////////////////////////////////
function shortcode_posts_function(){
    //Parameter für Posts
    $args = array(
        'category' => 'news', // Kategorie
        'numberposts' => 5  // Anzahl der Beiträge
    );
    //Posts holen
    $posts = get_posts($args);
    //Inhalte sammeln
    $content = '<div class="posts">';
    $content .= '<hr>
    <h1 class="page-title">Letzte &Auml;nderungen:</h1>';
    foreach ($posts as $post) {
        $content .= '<div class="post">';
        $content .= '<b><a href="'.get_permalink($post->ID).'"><div class="title">'.$post->post_title.'</div></b></a>';
        $content .= '<div class="post-date">'.mysql2date('d. F Y', $post->post_date).'</div>';
        $content .= '<div class="post-entry">'.wp_trim_words($post->post_content).'</div>';
        $content .= '<a href="'.get_permalink($post->ID).'"><div class="post-entry">'."Weiterlesen...".'<hr></div></a>';
        $content .= '</div>';
    }
    $content .= '</div>';
    //Inhalte übergeben
    return $content;
}
add_shortcode('posts', 'shortcode_posts_function');
?>