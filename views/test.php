<div class="row list-group products">
  <hr>
   <?php echo Message::show(); ?>
    <br>
     <?php
              if (!sizeof($data['connect'])) {
                 echo '<div class="alert alert-info">No Data.</div>';
              }
              else{
                echo
                '<div class="panel panel-default">
                      <!-- Default panel contents -->
                       <div class="panel-heading">CF</div>';
                        foreach ($data['connect'] as $conn){
                          echo '<p>Output : '.$conn['url'].'</p>';
                        }
                echo
                      '</div> <!-- panel-heading -->
                </div> <!-- panel panel-default -->';
                
              }
           ?>