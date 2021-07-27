<?php declare(strict_types=1); // -*- coding: utf-8 -*-

namespace Netlinkler\UsersApi;

class FetchApi
{    
    /**
     * fetch Mandatory Data of the user
     *
     * @return string
     */
    public function fetchMandatoryData()
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
     * fetch Additional Data of the user
     *
     * @return string
     */
    public function fetchAdditionalData()
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