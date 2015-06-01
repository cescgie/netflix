<?php

class Welcome extends Controller {

   public function __construct() {
      parent::__construct();
   }

   public function index() {
      $data['title'] = 'Home';
      $this->connect();

      $this->_view->render('header', $data);
      //$this->_view->render('welcome', $data);
      //$this->_view->render('test', $data);
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
	      	  echo '<pre>';
	          $str = $page;
	          $preg=preg_match_all('#<a.*?>(.*?)<\/a>#', $str, $parts);
	          if($preg==TRUE){
	          	//print_r ( $parts[1]);
	          	/*print_r ( $parts[1][27]);
	          	print_r ( $parts[1][30]);
	          	print_r ( $parts[1][33]);
	          	print_r ( $parts[1][37]);
	          	print_r ( $parts[1][40]);
	          	print_r ( $parts[1][43]);
	          	print_r ( $parts[1][46]);
	          	print_r ( $parts[1][49]);
	          	print_r ( $parts[1][52]);
	          	print_r ( $parts[1][55]);
	          	print_r ( $parts[1][58]);
	          	print_r ( $parts[1][61]);
	          	print_r ( $parts[1][68]);
	          	print_r ( $parts[1][71]);
	          	print_r ( $parts[1][74]);*/ 	
	          }      
	          echo '</pre>';
	          /*$preg_title=preg_match_all('#<h1 id="page_title">(.*?)<\/h1>#', $str, $parts);
	          if($preg==TRUE){
	          	print_r ( $parts[1][0]);
	          }*/
	          $preg_div=preg_match_all('/<div class="cover">[^<]*(<a.*?>\<img\s.+\><\/a>[^<]*)+[^<]*<\/div>/si', $str, $parts);
	          if($preg==TRUE){
	          	print_r ( $parts[1][0]);
	          }
	          	/*$re = '/(alt|href|src)=("[^"]*")/'; 

				preg_match_all($re, $str, $matches);
				print_r($matches);	*/	
	      }
	   }

}