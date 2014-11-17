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
		
		// get the div with id="moviemeter" which includes the movies
		$movies = $dom->getElementById("moviemeter");
		if(!$movies)
			return null;
		
		$charts = [];
		foreach ($movies->getElementsByTagName("div") as $div) 
		{
			$array = explode("#", $div->nodeValue);
					
			if(is_array($array) && count($array) == 2)
			{
				// get rank
				$rank = trim(substr($array[1], 0, 3));
		
				//get was
				if( preg_match( '!\(([^\)]+)\)!', $array[1], $match ) )
	    			$was = $match[1];
	    		
				$charts[$rank] = ["title"=>trim($array[0]), "was"=>$was, "rank"=>$rank];
			}
		}
		foreach ($charts as $key => $value) 
			$temp[$key] = $value["rank"];
		
		// sort by rank
		array_multisort($temp, SORT_ASC, $charts);

		// return the top <limit>
		return array_slice($charts, 0, $this->limit);	
	}	
}