<?php

class Home extends Controller {

   public function __construct() {
      parent::__construct();
   }

   public function index() {
      $data['title'] = 'Home';
      $data['new_releases'] = $this->_model->all();
      $datac= 'Benji the Hunted';
      $how = $this->_model->check($datac);
      if($how = 1)
      {
      	Message::set($how.'_1');
      }else{
      	Message::set($how.'_0');
      }

      $this->_view->render('header', $data);

      $this->connect();
      //$this->_view->render('welcome', $data);
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
	          $needle = "FIND ME"; 
	          $preg_div2=preg_match_all('/<div class="content">(.*?)<\/div>/s', $str, $description2);
	          if($preg_div2==TRUE){
	          	//echo '<p>1.'.$description[1][3].'</p>';
	          	//echo '<p>2.'.$description[1][4].'</p>';
	          	for($i = 1; $i < count($description2[1]); $i++){
	          		if (preg_match_all("/<p>(.*?)<\/p>/sim", $description2[1][$i],$var)) {
			          	//echo $var[1][$i][0];
			          	//echo $var[$i][1][0];
			          	//echo $var.$i.[1][0];
			            //echo $description2[1][$i];
			        }
	          	}
	          }
	          //echo $description2[1][0];	       
	          $preg_genres=preg_match_all('/<p class="genres">(.*?)<\/p>/s', $str, $genres);
	          if($preg_genres==TRUE){
	           //echo '<p>1.'.$genres[1][15].'</p>';
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
	         	/*$preg_movie_url2=preg_match_all('/href="(.*?)"/is', $movie_url_content[1][1], $movie_url1);
	          	echo '<a href="'.$movie_url1[1][0].'" target="_blank"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	         	$preg_movie_url2=preg_match_all('/href="(.*?)"/is', $movie_url_content[1][2], $movie_url2);
	          	echo '<a href="'.$movie_url2[1][0].'" target="_blank"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	         	$preg_movie_url2=preg_match_all('/href="(.*?)"/is', $movie_url_content[1][3], $movie_url3);
	          	echo '<a href="'.$movie_url3[1][0].'" target="_blank"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	         	*/
	          }
	          $preg_img=preg_match_all('/(?<!_)src=\"(.*?)(.jpg)"/', $str, $image);
	          if($preg_img==TRUE){
	          	for ($i=0; $i < count($movie_title[1]); $i++) { 
	          		# code...
	          		$data['movie_title'] = $movie_title[1][$i];
	          		$data['movie_image'] = $image[1][$i];
	          		$data['movie_description'] = $description[1][$i+3];
	          		$data['movie_genres'] = $genres[1][$i];
	          		$data['movie_year'] = $movie_year[1][$i];
	          		//$this->_model->insert($data);
	          		//echo $data['movie_year'];
	          	}/*
	          	echo '<br><br>';
	          	echo '<h4>1.'.$movie_title[1][0].'</h4>';
	          	echo '<img src="'.$image[1][0].'.jpg"/>';
	          	echo '<p>'.$description[1][3].'</p>';
	          	echo '<p>Year : '.$movie_year[1][0].'</p>';
	          	echo '<p>Genre : '.$genres[1][0].'</p>';
	          	//echo '<a href="'.$movie_url[1][0].'"><img src="http://ger.whatsnewonnetflix.com/assets/watch-on-netflix-sm-bf43e0c64985c1127adf6b16acdb590c.png"/></a>';
	          	//echo '<a href="'.$image[1][0].'.jpg"><p>1.'.$image[1][0].'.jpg</p></a>';
	          	echo '<br><br>';
	          	echo '<h4>2.'.$movie_title[1][1].'</h4>';
	          	echo '<img src="'.$image[1][1].'.jpg"/>';
	          	echo '<p>'.$description[1][4].'</p>';
	          	echo '<p>Year : '.$movie_year[1][1].'</p>';
	          	echo '<p>Genre : '.$genres[1][1].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>3.'.$movie_title[1][2].'</h4>';
	          	echo '<img src="'.$image[1][2].'.jpg"/>';
	          	echo '<p>'.$description[1][5].'</p>';
	          	echo '<p>Year : '.$movie_year[1][2].'</p>';
	          	echo '<p>Genre : '.$genres[1][2].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>4.'.$movie_title[1][3].'</h4>';
	          	echo '<img src="'.$image[1][3].'.jpg"/>';
	          	echo '<p>'.$description[1][6].'</p>';
	          	echo '<p>Year : '.$movie_year[1][3].'</p>';
	          	echo '<p>Genre : '.$genres[1][3].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>5.'.$movie_title[1][4].'</h4>';
	          	echo '<img src="'.$image[1][4].'.jpg"/>';
	          	echo '<p>'.$description[1][7].'</p>';
	          	echo '<p>Year : '.$movie_year[1][4].'</p>';
	          	echo '<p>Genre : '.$genres[1][4].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>6.'.$movie_title[1][5].'</h4>';
	          	echo '<img src="'.$image[1][5].'.jpg"/>';
	          	echo '<p>'.$description[1][8].'</p>';
	          	echo '<p>Year : '.$movie_year[1][5].'</p>';
	          	echo '<p>Genre : '.$genres[1][5].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>7.'.$movie_title[1][6].'</h4>';
	          	echo '<img src="'.$image[1][6].'.jpg"/>';
	          	echo '<p>'.$description[1][9].'</p>';
	          	echo '<p>Year : '.$movie_year[1][6].'</p>';
	          	echo '<p>Genre : '.$genres[1][6].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>8.'.$movie_title[1][7].'</h4>';
	          	echo '<img src="'.$image[1][7].'.jpg"/>';
	          	echo '<p>'.$description[1][10].'</p>';
	          	echo '<p>Year : '.$movie_year[1][7].'</p>';
	          	echo '<p>Genre : '.$genres[1][7].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>9.'.$movie_title[1][8].'</h4>';
	          	echo '<img src="'.$image[1][8].'.jpg"/>';
	          	echo '<p>'.$description[1][11].'</p>';
	          	echo '<p>Year : '.$movie_year[1][8].'</p>';
	          	echo '<p>Genre : '.$genres[1][8].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>10.'.$movie_title[1][9].'</h4>';
	          	echo '<img src="'.$image[1][9].'.jpg"/>';
	          	echo '<p>'.$description[1][12].'</p>';
	          	echo '<p>Year : '.$movie_year[1][9].'</p>';
	          	echo '<p>Genre : '.$genres[1][9].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>11.'.$movie_title[1][10].'</h4>';
	          	echo '<img src="'.$image[1][10].'.jpg"/>';
	          	echo '<p>'.$description[1][13].'</p>';
	          	echo '<p>Year : '.$movie_year[1][10].'</p>';
	          	echo '<p>Genres : '.$genres[1][10].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>12.'.$movie_title[1][11].'</h4>';
	          	echo '<img src="'.$image[1][11].'.jpg"/>';
	          	echo '<p>'.$description[1][14].'</p>';
	          	echo '<p>Year : '.$movie_year[1][11].'</p>';
	          	echo '<p>Genres : '.$genres[1][11].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>13.'.$movie_title[1][12].'</h4>';
	          	echo '<img src="'.$image[1][12].'.jpg"/>';
	          	echo '<p>'.$description[1][15].'</p>';
	          	echo '<p>Year : '.$movie_year[1][12].'</p>';
	          	echo '<p>Genres : '.$genres[1][12].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>14.'.$movie_title[1][13].'</h4>';
	          	echo '<img src="'.$image[1][13].'.jpg"/>';
	          	echo '<p>'.$description[1][16].'</p>';
	          	echo '<p>Year : '.$movie_year[1][13].'</p>';
	          	echo '<p>Genres : '.$genres[1][13].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>15.'.$movie_title[1][14].'</h4>';
	          	echo '<img src="'.$image[1][14].'.jpg"/>';
	          	echo '<p>'.$description[1][17].'</p>';
	          	echo '<p>Year : '.$movie_year[1][14].'</p>';
	          	echo '<p>Genres : '.$genres[1][14].'</p>';
	          	echo '<br><br>';
	          	echo '<h4>16.'.$movie_title[1][15].'</h4>';
	          	echo '<img src="'.$image[1][15].'.jpg"/>';
	          	echo '<p>'.$description[1][18].'</p>';
	          	echo '<p>Year : '.$movie_year[1][15].'</p>';
	          	echo '<p>Genres : '.$genres[1][15].'</p>';*/
	          }
	      }
	   }

}