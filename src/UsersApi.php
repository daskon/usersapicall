<?php declare(strict_types=1); // -*- coding: utf-8 -*-

namespace Netlinkler\UsersApi;

/**
 * Class UsersApi
 *
 * @package Netlinkler\UsersApi
 */
final class UsersApi 
{
     
   /**
    * UsersApi constructor
    *
    * @return void
    */
   public function __construct()
   {
       add_action('init', array($this, 'createCustomPostType'));
       
       //add assets 
       add_action('wp_enqueue_scripts', array($this, 'loadAssets'));

       //shortcode
       add_shortcode('users_info', array($this, 'usersTable'));

       //aditional scripts
       add_action('wp_footer', array($this, 'loadScripts'));
   }
   
   /**
    * create custom admin menu item for the plugin
    *
    * @return void
    */
   public function createCustomPostType()
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

       register_post_type('usersApi', $args);
   }
   
   /**
    * load stylings for model pop-up
    *
    * @return void
    */
   public function loadAssets()
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
            array('jquery'), 
            1,
            false
        );
   }
   
   /**
    * front-end HTML table
    *
    * @return void
    */
    public function usersTable() 
    {
        ?>
        <script> 
        jQuery(document).ready(function($) {
            var uid;
            if(uid == null) uid = 1;

            function fetchApi()
            {
                    /**when page load make the api request first time */
                    fetch(`https://jsonplaceholder.typicode.com/users/${uid}`)
                        .then( function(response){
                            if(!response.ok)
                            {
                                throw new Error(response.statusText);
                            }
                            return response;
                        })
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
            }

        fetchApi();
            
                /**when user click one of the link API call to the next record 
                and display in front-end **/

                $( '#result' ).on('click','.show-data',function(event) {
                    var id = $(this).data('user_id');
                    uid = ++id;
                    if(uid > 10) uid = 1;

                    $('#result').empty().append();
                    fetchApi(uid);
                });
                    
        });
        </script>

       <?php
        //model window html tags
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
    
    /**
     * pass users extra info to the pop-up model
     *
     * @return void
     */
    public function loadScripts()
    { 
        ?>
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
                    .then(function(response) {
                        if(!response.ok)
                        {
                            throw new Error(response.statusText);
                        }
                        return response;
                     })
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
    <?php 
    }
}

new UsersApi;
