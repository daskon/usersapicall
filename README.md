# Get User Information from JSONPlaceholder API

### Usefulness of this WordPress Plugin

##### This WP plugin request user information from JSONPlaceholder API and disply the respond in WP front-end page. Simply you can use the shortcode to display the result any page, post or widget you want. 

##### Plugin tested on WordPress Version 5.8 and PHP version: 7.4.1

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

###### Plugin output 

###### First Look of the front-end
![alt text](https://github.com/daskon/usersapicall/blob/master/screen/screen01.JPG?raw=true)

###### Second Look of the front-end after click on the text link
![alt text](https://github.com/daskon/usersapicall/blob/master/screen/screen02.JPG?raw=true)

###### After closing the pop-up model window, next user information will appear on the table without reloading the page. ( asynchronous AJAX call made to the API )
![alt text](https://github.com/daskon/usersapicall/blob/master/screen/screen03.JPG?raw=true)

