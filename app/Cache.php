<?php 

namespace App;

class Cache{


	const MAX_AGE = 120; // in sec

	protected $data;

	protected $cache_path;
	
	public function __construct(){
		$this->cache_path = dirname(__DIR__).'/cache/';
	}
	public function setRoute($route){
		$this->route = $route;
		return $this;
	}

	public function setData($data){
		$this->data = $data;
		return $this;
	}

	public function getValidCachedData(){
			$cache_data = $this->getCachedData();
			if(empty($cache_data)){
				return false;
			}

			if(!$this->isExpired($cache_data)){
				 	return $cache_data['data'];
			}
			return false;
	}

	public function store(){
		$cache_data = file_get_contents($this->cache_path.$this->getCurentDate());
		if(empty($cache_data)){
				$cache_data[] = $this->getModelCachedData();
	  		file_put_contents($this->cache_path.$this->getCurentDate(),json_encode($cache_data));
				return true;
		}

		$cache_index_data = $this->getCachedData();
		if($cache_index_data == false){
			$cache_data = json_decode($cache_data,TRUE);
			$cache_data[] = $this->getModelCachedData();
			file_put_contents($this->cache_path.$this->getCurentDate(),json_encode($cache_data));
			return true;
		}

		if($this->isExpired($cache_index_data)){
			 $cache_data = json_decode($cache_data,TRUE);
			 $col 	 = array_column($cache_data,'route');
			 $index  = array_search($this->route, $col);
			 $cache_data[$index] = $this->getModelCachedData();
			 file_put_contents($this->cache_path.$this->getCurentDate(),json_encode($cache_data));
		}
	}

	protected function getCachedData(){
			$cache_data = file_get_contents($this->cache_path.$this->getCurentDate());
			if(empty($cache_data)){
				return false;
			}
			$cache_data = json_decode($cache_data,TRUE);
			$col 	      = array_column($cache_data,'route');
			$index      = array_search($this->route, $col);

			if($index === false){
				return false;
			}
			return $cache_data[$index];
	}

	protected function getCurentDate(){
		return date("Y-m-d");
	}

	protected function isExpired($cache_data){
			$current_time = time();
			if(($current_time - $cache_data['expiration']) > self::MAX_AGE ){
				return true; // expired
			}
			return false;
	}
	
	protected function getModelCachedData(){
		return [
			'route'      => $this->route,
			'data'       => $this->data,
			'expiration' => time()
		];
	}
}