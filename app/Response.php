<?php

namespace App;

use App\Request;
use App\Route;
use App\Controllers\PlayerController;
use App\Models\ContractsBase;

use App\Cache;

/**
 * Handles an incoming request, provides access to querystring variables
 */
class Response
{

    protected $request;

    protected $baseDir;

    public function __construct(Request $request){
      $this->request = $request;
    }

    public function send()
    {

      header("Cache-Control: public, max-age=60");
      return Route::get($this->request);
    }

  
}
