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
                '<div class="panel panel-default">
                      <!-- Default panel contents -->';
                        foreach ($data['new_releases'] as $news){
                          echo '<div class="panel-heading"><h3>'.$news['movie_title'].'</h3></div>
                                <img src="'.$news['movie_image'].'.jpg"/>
                                <p>'.$news['movie_description'].'</p>
                                <p>Year : '.$news['movie_year'].'</p>
                                <p>Genres : '.$news['movie_genres'].'</p>';
                        }
                echo
                      '</div> <!-- panel-heading -->
                </div> <!-- panel panel-default -->';
                
              }
           ?>