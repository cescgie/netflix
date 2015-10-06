<?php

class Home extends Controller {

   public function __construct() {
      parent::__construct();
   }

   public function index() {
      $data['title'] = 'Home';
      $data['new_releases'] = $this->_model->all();
      $data['datum'] = date("F j,Y, g:i a");

      $this->connect();
      $this->_view->render('header', $data);
      $this->_view->render('home', $data);
      $this->_view->render('footer');
   }
   public function get_web_page( $url )
   {
        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
	}
	public function connect()
  	{
	      //Read a web page and check for errors:
	      $url = "http://ger.whatsnewonnetflix.com/";

	      $result = $this->get_web_page( $url );

	      if ( $result['errno'] != 0 )
	          Message::set("error: bad url | timeout | redirect loop ...");

	      if ( $result['http_code'] != 200 )
	          Message::set("error: no page | no permissions | no service ");

	      $page = $result['content'];

	      if($result==TRUE){
	          //explode
	          $str = $page;
	          //title
	          $preg_title=preg_match_all('/<h1 id="page_title">(.*)<\/h1>/iU', $str, $title);
	          if($preg_title==TRUE){
	          	//echo '<h1>'.$title[1][0].'</h1>';
	          }
	          $preg_datum=preg_match_all('/<h3>(.*)<\/h3>/iU', $str, $datum);
	          if($preg_datum==TRUE){
	          	//echo '<h3>'.$datum[1][0].'</h3>';
	          }
	          $preg_movie_title=preg_match_all('/<h4><a.*?>(.*?)<\/a><\/h4>/iU', $str, $movie_title);
	          $preg_img=preg_match_all('/(?<!_)src=\"(.*?)(.jpg)"/', $str, $image);
			      $preg_description=preg_match_all('/<p>(.*?)<\/p>/s', $str, $description);
	          $preg_movie_year=preg_match_all('/<span class="year">(.*?)<\/span>/s', $str, $movie_year);
	          $preg_genres=preg_match_all('/<p class="genres">(.*?)<\/p>/s', $str, $genres);
	          //check all preg match
	          if($preg_movie_title==TRUE&&$preg_img==TRUE&&$preg_description==TRUE&&$preg_movie_year==TRUE&&$preg_genres==TRUE){
	          	for ($i=count($movie_title[1]); $i >0; $i--) {
                //echo $description[1][$i+3];
	          		//serialize content
	          		$data['movie_title'] = $movie_title[1][$i-1];
  			        $data['movie_image'] = $image[1][$i];
  			        $data['movie_description'] = $description[1][$i+3];
  			        $data['movie_genres'] = $genres[1][$i-1];
  			        $data['movie_year'] = $movie_year[1][$i-1];
  			        //check if title already exists
  	          	$datac= $movie_title[1][$i-1];
    				    $how['numrows'] = $this->_model->check($datac);
    				    foreach ($how['numrows'] as $sum){
    				    	//if the title exists, no action
    				    	if($sum['num_rows'] > 0)
    					    {
    					    	//No Action
    					    }else{
    					    	//insert to DB
    			          		$this->_model->insert($data);
    					    }
  				      } // end of foreach ($how['numrows'] as $sum){
	       		 } // end of for ($i=count($movie_title[1]); $i >0; $i--) {
	        } // end of check all preg match
		} // end of if($result==TRUE){
	}

}
