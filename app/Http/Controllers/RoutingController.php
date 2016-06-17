<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RoutingController extends Controller
{
    public function index( Request $request, $controller, $func = NULL ){
    	$controllerObj = new Admin\StudentsController;
    				
    	if( is_null( $func ) )
    	{
    		switch ( $request->method() ) {
    			case 'GET':
    				return $controllerObj->index();
    				break;
    			
    			case 'POST':
    				return $controllerObj->store();
    				break;

    			case 'PUT':
    				return $controllerObj->update();
    				break;

    			case 'DELETE':
    				return $controllerObj->destroy();
    				break;
    		}
    	}else{
    		
    	}
    	
    	echo 'Method: ' . $request->method();
    	echo 'Controller: ' . $controller;
    	echo 'Function: ' . $func;
    }
}
