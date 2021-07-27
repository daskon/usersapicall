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
     * @var FetchApi
     */
    private $api;

   /**
    * UsersApi constructor
    *
    * @return void
    */
   public function __construct($api)
   {
       $this->api = $api;

       add_action('init', array($this, 'createCustomPostType'));
       
       //include assets css, js
       add_action('wp_enqueue_scripts', array($this, 'loadAssets'));

       //shortcode
       add_shortcode('users_info', array($this, 'usersTable'));

       //open model window with additional user data
       add_action('wp_footer', array($this, 'popupModel'));
   }
   

   /**
    * create custom admin menu item for the plugin
    *
    * @return array
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
    * display user mandatory data in the table
    *
    * @return void
    */
    public function usersTable() 
    {
        echo $this->api->fetchMandatoryData();
    }
    
    /**
     * display users extra info in a pop-up model
     *
     * @return void
     */
    public function popupModel()
    { 
        echo $this->api->fetchAdditionalData();
    }
}

new UsersApi(new FetchApi);