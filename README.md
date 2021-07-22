# Get User Information from JSONPlaceholder API

### Usefulness of this WordPress Plugin

##### This WP plugin request user information from JSONPlaceholder API and disply the respond in WP front-end page. Simply you can use the shortcode to display the result any page, post or widget you want. 

### Instructions for the installation

###### If install the plugin using composer please add below command to your composer.json

    "repositories": [
        { 
          "type": "vcs",
          "url": "git@github.com:daskon/usersapicall.git
        }
     ]
     
###### And then run the composer command below 

    composer require daskon/usersapicall
     
###### If install the plugin using regular wordpress admin dashboard plugin installation section, download the zip file of this plugin and upload it into your wordpress installation. After that, you can add the below shortcode into post, page or widget in the wordpress.

    [users_info]
