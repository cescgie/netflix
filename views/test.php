<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script type="text/javascript">
      (function() {
          function async_load(script_url){
              var protocol = ('https:' == document.location.protocol ? 'https://' : 'http://');
              var s = document.createElement('script'); s.src = protocol + script_url;
              var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
          }
          bm_website_code = '8D8CF73E498B4DED';
          jQuery(document).ready(function(){async_load('asset.pagefair.com/measure.min.js')});
          jQuery(document).ready(function(){async_load('asset.pagefair.net/ads.min.js')});
      })();
  </script>
  
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