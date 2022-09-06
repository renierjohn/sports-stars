<?php 

namespace App;

use App\Controllers\PlayerController;

class Route{

	const ASSETS_PATH = '/static';
	
	public static function get($request){
 		$id   =	count($_REQUEST) > 0 ? $request->query('id') : null;
		$uri  = $request->getUri();
 		$controller = new PlayerController();

		if(str_contains($uri,self::ASSETS_PATH)){
			$filename = $request->getFileName();
			if(file_exists($filename)){
          return file_get_contents($filename);
      }
		}

		$path = $request->getPath(); 
	
		if(str_contains($uri,'/api/players/')){
			$type = str_replace('/api/players/','', $path);
			if($type == 'nba'){
				$type = 'nba.players';
			}
			
			header("Content-type: application/json");
			return $controller->setType($type)->setID($id)->API();;
		}


		if($path == '/allblacks'){
			 return $controller->setType('allblacks')->setID($id)->show();
		}

		if($path == '/nba'){
			 return $controller->setType('nba.players')->setID($id)->show();
		}

			 return $controller->notFound();

	}
}