<?php

class Welcome extends Controller {

   public function __construct() {
      parent::__construct();
   }

   public function index() {
      $data['title'] = 'Home';

      $this->_view->render('header', $data);

      $this->connect();
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
	      	  //echo '<pre>';
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
	          //echo '</pre>';
	          //title
	          $preg_title=preg_match_all('/<h1 id="page_title">(.*)<\/h1>/iU', $str, $title);
	          if($preg_title==TRUE){
	          	echo '<h1>'.$title[1][0].'</h1>';
	          }
	          $preg_datum=preg_match_all('/<h3>(.*)<\/h3>/iU', $str, $datum);
	          if($preg_datum==TRUE){
	          	echo '<h3>'.$datum[1][0].'</h3>';
	          }
	          //content
	          $preg_div=preg_match_all('/<div class="content">(.*?)<\/div>/s', $str, $parts);
	          if($preg_div==TRUE){
	          	//echo '<p>'.$parts[1][1].'</p>';
	          	//echo '<p>'.$parts[1][2].'</p>';
	          }
	          $preg_description=preg_match_all('/<p>(.*?)<\/p>/s', $str, $description);
	          if($preg_description==TRUE){
	          	//echo '<p>1.'.$description[1][3].'</p>';
	          	//echo '<p>2.'.$description[1][4].'</p>';
	          }	          
	          $preg_genres=preg_match_all('/<p class="genres">(.*?)<\/p>/s', $str, $genres);
	          if($preg_genres==TRUE){
	           //echo '<p>1.'.$genres[1][0].'</p>';
	           //echo '<p>2.'.$genres[1][1].'</p>';
	          }
	          $preg_movie_year=preg_match_all('/<span class="year">(.*?)<\/span>/s', $str, $movie_year);
	          if($preg_movie_year==TRUE){
	           //echo '<p>1.'.$movie_year[1][0].'</p>';
	           //echo '<p>2.'.$movie_year[1][1].'</p>';
	          }
	          $preg_movie_title=preg_match_all('/<h4><a.*?>(.*?)<\/a><\/h4>/iU', $str, $movie_title);
	          if($preg_movie_title==TRUE){
	          	//echo '<p>'.$movie_title[1][0].'</p>';
	          	//echo '<p>'.$movie_title[1][3].'</p>';
	          }
	          //This first step grabs the contents of the div.
				//preg_match_all('#(?<=<div class="watchonnetflix_sm">).*?(?=</div>)#is', $url, $x);
				//echo '<p>url '.$x[0][0].'</p>';

				//And here, we grab all of the links.
				//preg_match_all('#href="(.*?)"#is', $x[0], $x);
				//echo '<p>url '.$x[1][0].'</p>';

	          $preg_movie_url_content=preg_match_all('/<div class="watchonnetflix_sm">(.*?)<\/div>/is', $str, $movie_url_content);
	          if($preg_movie_url_content==TRUE){
	          	//echo '<p>'.$movie_url[1][0].'</p>';
	         	$preg_movie_url2=preg_match_all('/href="(.*?)"/is', $movie_url_content[1][1], $movie_url);
	          	echo '<a href="'.$movie_url[1][0].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	//echo '<p>'.$parts[1][2].'</p>';
	          }
	          $preg_img=preg_match_all('/(?<!_)src=\"(.*?)(.jpg)"/', $str, $image);
	          if($preg_img==TRUE){
	          	echo '<br><br>';
	          	echo '<h4>1.'.$movie_title[1][0].'</h4>';
	          	echo '<img src="'.$image[1][0].'.jpg"/>';
	          	echo '<p>'.$description[1][3].'</p>';
	          	echo '<p>Year : '.$movie_year[1][0].'</p>';
	          	echo '<p>Genre : '.$genres[1][0].'</p>';
	            echo '<a href="'.$movie_url[1][0].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	//echo '<a href="'.$image[1][0].'.jpg"><p>1.'.$image[1][0].'.jpg</p></a>';
	          	echo '<br><br>';
	          	echo '<h4>2.'.$movie_title[1][1].'</h4>';
	          	echo '<img src="'.$image[1][1].'.jpg"/>';
	          	echo '<p>'.$description[1][4].'</p>';
	          	echo '<p>Year : '.$movie_year[1][1].'</p>';
	          	echo '<p>Genre : '.$genres[1][1].'</p>';
	          	echo '<a href="'.$movie_url[1][1].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>3.'.$movie_title[1][2].'</h4>';
	          	echo '<img src="'.$image[1][2].'.jpg"/>';
	          	echo '<p>'.$description[1][5].'</p>';
	          	echo '<p>Year : '.$movie_year[1][2].'</p>';
	          	echo '<p>Genre : '.$genres[1][2].'</p>';
	            echo '<a href="'.$movie_url[1][2].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>4.'.$movie_title[1][3].'</h4>';
	          	echo '<img src="'.$image[1][3].'.jpg"/>';
	          	echo '<p>'.$description[1][6].'</p>';
	          	echo '<p>Year : '.$movie_year[1][3].'</p>';
	          	echo '<p>Genre : '.$genres[1][3].'</p>';
	         	echo '<a href="'.$movie_url[1][3].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>5.'.$movie_title[1][4].'</h4>';
	          	echo '<img src="'.$image[1][4].'.jpg"/>';
	          	echo '<p>'.$description[1][7].'</p>';
	          	echo '<p>Year : '.$movie_year[1][4].'</p>';
	          	echo '<p>Genre : '.$genres[1][4].'</p>';
	          	echo '<a href="'.$movie_url[1][4].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>6.'.$movie_title[1][5].'</h4>';
	          	echo '<img src="'.$image[1][5].'.jpg"/>';
	          	echo '<p>'.$description[1][8].'</p>';
	          	echo '<p>Year : '.$movie_year[1][5].'</p>';
	          	echo '<p>Genre : '.$genres[1][5].'</p>';
	          	echo '<a href="'.$movie_url[1][5].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>7.'.$movie_title[1][6].'</h4>';
	          	echo '<img src="'.$image[1][6].'.jpg"/>';
	          	echo '<p>'.$description[1][9].'</p>';
	          	echo '<p>Year : '.$movie_year[1][6].'</p>';
	          	echo '<p>Genre : '.$genres[1][6].'</p>';
	          	echo '<a href="'.$movie_url[1][6].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>8.'.$movie_title[1][7].'</h4>';
	          	echo '<img src="'.$image[1][7].'.jpg"/>';
	          	echo '<p>'.$description[1][10].'</p>';
	          	echo '<p>Year : '.$movie_year[1][7].'</p>';
	          	echo '<p>Genre : '.$genres[1][7].'</p>';
	          	echo '<a href="'.$movie_url[1][6].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>9.'.$movie_title[1][8].'</h4>';
	          	echo '<img src="'.$image[1][8].'.jpg"/>';
	          	echo '<p>'.$description[1][11].'</p>';
	          	echo '<p>Year : '.$movie_year[1][8].'</p>';
	          	echo '<p>Genre : '.$genres[1][8].'</p>';
	          	echo '<a href="'.$movie_url[1][8].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>10.'.$movie_title[1][9].'</h4>';
	          	echo '<img src="'.$image[1][9].'.jpg"/>';
	          	echo '<p>'.$description[1][12].'</p>';
	          	echo '<p>Year : '.$movie_year[1][9].'</p>';
	          	echo '<p>Genre : '.$genres[1][9].'</p>';
	          	echo '<a href="'.$movie_url[1][9].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>11.'.$movie_title[1][10].'</h4>';
	          	echo '<img src="'.$image[1][10].'.jpg"/>';
	          	echo '<p>'.$description[1][13].'</p>';
	          	echo '<p>Year : '.$movie_year[1][10].'</p>';
	          	echo '<p>Genres : '.$genres[1][10].'</p>';
	          	echo '<a href="'.$movie_url[1][10].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>12.'.$movie_title[1][11].'</h4>';
	          	echo '<img src="'.$image[1][11].'.jpg"/>';
	          	echo '<p>'.$description[1][14].'</p>';
	          	echo '<p>Year : '.$movie_year[1][11].'</p>';
	          	echo '<p>Genres : '.$genres[1][11].'</p>';
	          	echo '<a href="'.$movie_url[1][11].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>13.'.$movie_title[1][12].'</h4>';
	          	echo '<img src="'.$image[1][12].'.jpg"/>';
	          	echo '<p>'.$description[1][15].'</p>';
	          	echo '<p>Year : '.$movie_year[1][12].'</p>';
	          	echo '<p>Genres : '.$genres[1][12].'</p>';
	          	echo '<a href="'.$movie_url[1][12].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>14.'.$movie_title[1][13].'</h4>';
	          	echo '<img src="'.$image[1][13].'.jpg"/>';
	          	echo '<p>'.$description[1][16].'</p>';
	          	echo '<p>Year : '.$movie_year[1][13].'</p>';
	          	echo '<p>Genres : '.$genres[1][13].'</p>';
	          	echo '<a href="'.$movie_url[1][13].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	echo '<br><br>';
	          	echo '<h4>15.'.$movie_title[1][14].'</h4>';
	          	echo '<img src="'.$image[1][14].'.jpg"/>';
	          	echo '<p>'.$description[1][17].'</p>';
	          	echo '<p>Year : '.$movie_year[1][14].'</p>';
	          	echo '<p>Genres : '.$genres[1][14].'</p>';
	          	echo '<a href="'.$movie_url[1][14].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          }
	      }
	   }

}