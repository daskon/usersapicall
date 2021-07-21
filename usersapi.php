<?php
/**
 * Plugin name: Users API
 * Plugin URI: https://netlinkler.com
 * Description: Get information from external APIs in WordPress
 * Author: Asela Daskon
 * Author URI: https://netlinkler.com
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: users-api
 */

 //if the plugin access directly from the URL
 defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

class Usersapi {
  
   public function __construct()
   {
       add_action('init', array($this, 'create_custom_post_type'));
       
       //add assets 
       add_action('wp_enqueue_scripts', array($this, 'load_assets'));

       //shortcode
       add_shortcode('users_info', array($this, 'users_table'));

       add_action('wp_footer', array($this, 'load_scripts'));
   }

   public function create_custom_post_type()
   {
       $args = array(
           'public' => true,
           'supports' => array('title'),
           'exclude_from_search' => true,
           'public_queryable' => false,
           'capability' => 'manage_options',
           'labels' => array(
               'name' => 'List of Users'
           )
       );

       register_post_type('users_api', $args);
   }

   public function load_assets()
   {
        wp_enqueue_style( 
            'user-list', 
            plugin_dir_url( __FILE__ ) . 'css/style.css', 
            array(), 
            1,
            'all'
        );

        wp_enqueue_script( 
             'user-list', 
             plugin_dir_url( __FILE__ ) . 'js/user-ajaxcall.js', 
             array( 'jquery' ), 
             1,
             true
        );
   }

   public function users_table() {

        //external API
        $url = 'https://jsonplaceholder.typicode.com/users';
        $args = array (
            'method' => 'GET'
        );

        $response = wp_remote_get($url, $args);

        if( is_wp_error($response)) {
            $error = $response->get_error_message();
            return "Something Not Right: $error";
        }
        
        $result = json_decode(wp_remote_retrieve_body($response));

        $html = '';
        $html .= '<table><tbody>';
        $html .= '<th>ID</th>';
        $html .= '<th>NAME</th>';
        $html .= '<th>USERNAME</th>';

        foreach($result as $items){
            $html .= '<tr>';
            $html .= '<td>'.$items->id.'</td>';
            $html .= '<td><a href="#find" class="show-data" data-user_id="' . $items->id . '">'.$items->name.'</a></td>';
            $html .= '<td><a href="#find" class="show-data" data-user_id="' . $items->id . '">'.$items->username.'</a></td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div id="myModal" class="modal">
                    <div class="modal-content">
                    <span class="close">&times;</span>
                    <p class="info"></p>
                  </div>
                  </div>';

        return $html;
    }

    public function load_scripts()
    { ?>
        <script>
            jQuery(document).ready(function($) {

                $( '.show-data' ).click(function(event) {

                    var modal = document.getElementById("myModal");
                    var span = document.getElementsByClassName("close")[0];
                    var id = $(this).data('user_id');

                    modal.style.display = "block";
                    span.onclick = function() {
                        modal.style.display = "none";
                    }
                    
                    fetch(`https://jsonplaceholder.typicode.com/users/${id}`)
                    .then((response) => response.json())
                    .then((json) => console.log(json.email));

                })
            });
        </script>
    <?php }

}

new Usersapi;