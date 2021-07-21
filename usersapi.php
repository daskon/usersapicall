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

       //aditional scripts
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

        // wp_localize_script( 'wpse_handle', 'userObj', array(
        //     'id' => 4,
        // ) );
   }

   public function users_table() {

        ?>
        <script> 
            jQuery(document).ready(function($) {
            var uid;
            if(uid == null) uid = 1;

             fetch(`https://jsonplaceholder.typicode.com/users/${uid}`)
                    .then((response) => response.json())
                    .then( json => {
                        $('#result').append(
                            '<table><tbody>'+
                            '<th>ID</th>'+
                            '<th>NAME</th>'+
                            '<th>USERNAME</th>'+
                            '<tr>'+
                            '<td>'+ json.id +'</td>'+
                            '<td><a href="#find" class="show-data" data-user_id="'+ json.id +'">'+ json.name +'</a></td>'+
                            '<td><a href="#find" class="show-data" data-user_id="'+ json.id +'">'+ json.username +'</a></td>'+
                            '</tr>'+
                            '</tbody></table>'
                        );
                    })

                    $( '#result' ).on('click','.show-data',function(event) {
                        var id = $(this).data('user_id');
                        uid = ++id;
                        if(uid > 10) uid = 1;
                        fetch(`https://jsonplaceholder.typicode.com/users/${uid}`)
                            .then((response) => response.json())
                            .then( json => {
                                $('#result').empty().append();
                                $('#result').append(
                                    '<table><tbody>'+
                                    '<th>ID</th>'+
                                    '<th>NAME</th>'+
                                    '<th>USERNAME</th>'+
                                    '<tr>'+
                                    '<td>'+ json.id +'</td>'+
                                    '<td><a href="#find" class="show-data" data-user_id="'+ json.id +'">'+ json.name +'</a></td>'+
                                    '<td><a href="#find" class="show-data" data-user_id="'+ json.id +'">'+ json.username +'</a></td>'+
                                    '</tr>'+
                                    '</tbody></table>'
                                );
                            })
                    });
                    
            });
        </script>

       <?php
        $html = '';
        $html .= '<div id="result"></div>';
        $html .= '<div id="myModal" class="modal">
                    <div class="modal-content">
                    <span class="close">&times;</span>
                     <h4>Contact Informations</h4>
                     <p id="email"></p>
                     <p id="phone"></p>
                     <p id="website"></p>
                  </div>
                  </div>';
         
        return $html;
    }

    public function load_scripts()
    { ?>
        <script>
            jQuery(document).ready(function($) {

                $( '#result' ).on('click','.show-data',function(event) {
                    
                    var modal = document.getElementById("myModal");
                    var span = document.getElementsByClassName("close")[0];
                    var id = $(this).data('user_id');

                    modal.style.display = "block";
                    span.onclick = function() {
                        modal.style.display = "none";
                    }
                    
                    fetch(`https://jsonplaceholder.typicode.com/users/${id}`)
                    .then((response) => response.json())
                    .then( json => {
                            const email = json.email;
                            const phone = json.phone;
                            const website = json.website;
                            document.getElementById("email").innerHTML = email;
                            document.getElementById("phone").innerHTML = phone;
                            document.getElementById("website").innerHTML = website;
                    })
                })
            });
        </script>
    <?php }

}

new Usersapi;