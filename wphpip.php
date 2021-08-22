<?php
/*
Plugin Name:       WP H-Posts in Pages
Plugin URI:        https://herbrand.org/wordpress/eigene-plugins/wp-h-posts-in-pages/
Description:       Beitr&auml;ge in Seiten einf&uuml;gen
Author:            Hans M. Herbrand
Author URI:        https://herbrand.org
Version:           1.1.2
Date:              2021-08-22
License:           GNU General Public License v2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/m266/wp-h-posts-in-pages
Credits:           https://ostrich.de/wordpress-beitraege-auf-seite-anzeigen/
Hinweis:           Tag [posts] in der Start-Seite einfuegen
*/

// Externer Zugriff verhindern
defined('ABSPATH') || exit();

//////////////////////////////////////////////////////////////////////////////////////////

// Erinnerung an Git Updater
register_activation_hook( __FILE__, 'wphpip_activate' ); // Funktions-Name anpassen
function wphpip_activate() { // Funktions-Name anpassen
$subject = 'Plugin "WP H-Posts in Pages"'; // Plugin-Name anpassen
$message = 'Falls nicht vorhanden:
Bitte das Plugin "Git Updater" hier https://herbrand.org/tutorials/github/git-updater/ herunterladen, 
installieren und aktivieren, um weiterhin Updates zu erhalten!';
wp_mail(get_option("admin_email"), $subject, $message );
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
    <h3 class="page-title">Letzte &Auml;nderungen:</h3>';
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