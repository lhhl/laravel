<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Students;

class StudentsController extends AdminPatternController
{
	function __construct( Request $request){
		$this->model = new Students;
		parent::__construct( $request );
		$this->alias .= 'Students';
		$this->orderBy = [ 'age', 'ASC' ];
		$this->formRender = [
			'name' => [
				'title' => 'Student\'s Name',
				'validate' => 'required|min:6',
				'placeholder' => 'Enter Student\'s Name',
			],
			'age' => [
				'title' => 'Student\'s Age',
				'type' => 'number',
				'validate' => 'required',
				'placeholder' => 'Enter Student\'s Age',
			],
			'rate' => [
				'title' => 'Student\'s Rate',
				'type' => 'textbox',
				'validate' => 'required',
				'placeholder' => 'Enter Student\'s Rate',
			],
			

		];
	}
}
