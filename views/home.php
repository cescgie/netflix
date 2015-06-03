<div class="row list-group products">
  <hr>
   <?php echo Message::show(); ?>
    <br>
     <?php
              if (!sizeof($data['new_releases'])) {
                 echo '<div class="alert alert-info">No Data.</div>';
              }
              else{
                echo 
                  '<!-- Table -->
                    <table class="table">
                      <tr>
                        <td width="60%">
                          <h3>New Releases</h3>
                          <p>Updated : '.$data['datum'].'</p>
                        </td>
                        <td width="40%"></td> 
                      </tr>
                      <tr>
                        <td>';
                    foreach ($data['new_releases'] as $news){
                      echo 
                        '<div class="panel panel-default">
                           <!-- Default panel contents -->
                           <div class="panel-heading"><h3>'.$news['movie_title'].'</h3></div>
                           <img src="'.$news['movie_image'].'.jpg"/>
                           <p>'.$news['movie_description'].'</p>
                           <p>Year : '.$news['movie_year'].'</p>
                           <p>Genres : '.$news['movie_genres'].'</p>
                         </div>';
                     }
                     echo
                       '</td>
                        <td></td>
                      </tr>
                    </table>';
                
              }
           ?>