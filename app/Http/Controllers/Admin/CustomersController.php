<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customers;


class CustomersController extends AdminPatternController
{
    function __construct( Request $request ){
		$this->model = new Customers;
		$this->alias .= 'Customers';
		$this->orderBy = [ 'data_sort', 'ASC' ];
		$this->colDisplay = [ 'id', 'name', 'age', 'data_display', 'data_default', 'data_sort' ];
		$this->defaultColSearch = 'name';
		$this->formRender = [
			'name' => [
				'title' => 'Customer\'s Name',
				'validate' => 'required|min:6',
				'placeholder' => 'Enter Customer\'s Name',
			],
			'age' => [
				'title' => 'Customer\'s Age',
				'type' => 'number',
				'validate' => 'required',
				'placeholder' => 'Enter Customer\'s Age',
			],
			'data_display' => [
				'title' => 'Customer\'s Display',
				'type' => 'radio',
				'default_value' => [ 1 => 'Show', 0 => 'Hide' ],
				'validate' => 'required',
				'placeholder' => 'Enter Customer\'s Display',
			],
			'data_default' => [
				'title' => 'Customer\'s Default',
				'type' => 'checkbox',
				
				
				'placeholder' => 'Enter Customer\'s Default',
			],
			'data_sort' => [
				'title' => 'Customer\'s Sort',
				'type' => 'hidden',
				'default_value' => 1,
				'validate' => 'required',
				'placeholder' => 'Enter Customer\'s Sort',
			],

		];
		parent::__construct( $request );
	}
}
