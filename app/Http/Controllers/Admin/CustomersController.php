<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customers;

class CustomersController extends AdminPatternController
{
    function __construct(){
		parent::__construct();
		$this->model = new Customers;
		$this->alias .= 'Customers';
		$this->orderBy = [ 'data_sort', 'DESC' ];
		$this->colDisplay = [ 'id', 'name', 'age', 'data_display as display', 'data_default as default' ];
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
				'default_value' => $this->lang[ 'text_control' ][ 'display_radio' ],
				'validate' => 'required',
				'placeholder' => 'Enter Customer\'s Display',
			],
			'data_default' => [
				'title' => 'Customer\'s Default',
				'type' => 'radio',
				'default_value' => $this->lang[ 'text_control' ][ 'default_radio' ],
				'validate' => 'required',
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
	}
}
