<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class APIController
{
	
    protected $model, $colDisplay, $orderBy, $itemPerPage;

    public function __construct( $config ){
        $this->model        =  $config['model'];
        $this->colDisplay   =  $config['colDisplay'];
        $this->orderBy      =  $config['orderBy'];
    }

    public function index( $search = '', $page = 1 ){

        $data = $this->model
                    ->select( $this->colDisplay )
                    ->orderBy( $this->orderBy[0], $this->orderBy[1] )
                    ->get();
        return $data;
    }

    public function create(){

    }

    public function store(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }

    public function multidestroy(){

    }
}
