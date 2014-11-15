<?php
/**
 * ImdbScraper controller
 * @author George Dimosthenous
 */

namespace app\commands;
 
use yii\console\Controller;
use app\models\Movies;
use app\models\Dates;
use app\models\DatesMovies;
 

class ImdbscraperController extends Controller {
	private $url = 'http://www.imdb.com/chart/?ref_=chttp_ql_1'; // imdb url displaying the charts
	private $limit = 10; // the number of movies to return 

	private function getUrl($url)
	{
		$page = file_get_contents($url);
		
		return $page;			
	}

	public function actionStorerecords()
	{
		$charts = $this->parsehtml();
		$today = date("Y-m-d"); 
		
		// if we haven't store todays charts. We store charts for each day
		if(Dates::find()->where(['date' => $today])->one() == NULL)
		{
			$date = new Dates();
			$date->date = $today;
			$date->save();
		
			foreach ($charts as $m) 
			{
				
				$movie = Movies::find()->where(['title' => $m['title']])->one();
				// if the movie does not exist in the "movies" table then save it
				if($movie == NULL)
				{	
					$movie = new Movies();
					$movie->title = $m['title'];
					$movie->save();
				}

				$date_movie = new DatesMovies();
				$date_movie->date_id = $date->id;
				$date_movie->movie_id = $movie->id;
				$date_movie->rank = $m['rank'];
				$date_movie->was = $m['was'];
				$date_movie->save();

			}
		}
	}

	private function parsehtml()
	{
		$html = $this->getUrl($this->url);
		$dom = new \DOMDocument();
		@$dom->loadHTML($html);
		// discard white space
		$dom->preserveWhiteSpace = false;
		
		// get the div which includes the movies
		$movies = $dom->getElementById("moviemeter");
		if(!$movies)
			return null;
		
		// get movies titles
		$titles = $movies->getElementsByTagName("p");
		// get the previous ranks
		$previous_ranks = $movies->getElementsByTagName("span");

		$charts = [];
		for($i=0; $i<$this->limit; $i++)
			$charts[$i] = ["title"=>trim($titles->item($i)->nodeValue), "rank"=> $i+1];
		
		$i = 0;
		foreach ($previous_ranks as $rank) {
			
			if( preg_match( '!\(([^\)]+)\)!', $rank->nodeValue, $match ) ){
    			$text = $match[1];
    			$charts[$i]["was"] = $text;
    			$i++;
    			if($i == $this->limit)
    				break;
			}
			
		}
		return $charts;
		
	}	
}

//$imdb = new imdbScraper();
//print_r($imdb->parseHtml());

	



