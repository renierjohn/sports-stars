<?php

namespace App\Controllers;

use App\Http\Http;
use Tightenco\Collect\Support\Collection;
use App\Models\ContractsBase;
use App\Cache;

class PlayerController
{

    protected $type;

    protected $id;

    public function setType($type){
        $this->type = $type;
        return $this;
    }

    public function setID($id){
        $this->id = $id;
        return $this;
    }
    
    public function notFound(){
        return view('404',[]);
    }

    public function API(){
        $id   = $this->id ?? 1;
        $data = $this->getData($id); // REAL API
        // $data          = $this->mockPlayer($this->type);
        $contractsBase = new ContractsBase($this->type,$data);
        $player     = $contractsBase->model();
        $data       = $this->getAll($player);
        return $data;
    }
    /**
     * Show a player profile
     * 
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $id = $this->id ?? 1;
        // $data   = $this->mockPlayer($this->type);
        $data   = $this->getData($id); // REAL API
        $contractsBase = new ContractsBase($this->type,$data);

        $player    = $contractsBase->model();
        $view_data = collect([]);
        
        $view_data->put('id', $player->getID());

        $view_data->put('full_name', $player->getFullName());

        $view_data->put('last_name', $player->getLastName());

        $view_data->put('first_name',$player->getFirstName());

        $view_data->put('image', $player->getImage());

        $view_data->put('featured', $player->feature());

        $view_data->put('bio', $player->getBio());

        $view_data->put('number', $player->getPlayerNumber());

        $view_data->put('bannerTitle',$player->getBannerTitle());
        
        $view_data->put('bannerImage',$player->getBannerImage());

        $view_data->put('tabs',$player->getTabs());

        $view_data->put('type',$this->type);

        $view_data->put('cache',$this->getAll($player));

        // return view('mock',[]);        
        return view('player', $view_data);
    }

    protected function getAll(&$player){
        $data = [
            'full_name'  => $player->getFullName(),
            'first_name' => $player->getFirstName(),
            'last_name'  => $player->getLastName(),
            'image'      => $player->getImage(),
            'number'     => $player->getPlayerNumber(),
            'bio'        => $player->getBio(),
            'featured'   => $player->feature(),
        ];
        return json_encode($data);
    }

    /**
     * Retrieve player data from the API
     *
     * @param int $id
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function getData(int $id): Collection
    {
        // Cache
        $baseEndpoint = 'https://www.zeald.com/developer-tests-api/x_endpoint/'.$this->type;
        
        $cache = new Cache();
        $res   = $cache->setRoute($baseEndpoint.'?id='.$id)->getValidCachedData();
        $json  = $res;

        if(empty($res)){
            $json = Http::get("$baseEndpoint/id/$id", [
                'API_KEY' => env('API_KEY'),
            ])->json();

            $cache->setData($json)->store();
        }

        return collect(array_shift($json));
    }
}
