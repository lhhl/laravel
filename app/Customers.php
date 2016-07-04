<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customers extends Model
{
    protected $fillable = [ 'name', 'age', 'data_display', 'data_default', 'data_sort', 'image_name' ];
    public function setDataSortAttribute( $sort ){
    	if( !isset( $this->attributes['id'] ) ){	
	    		$this->attributes['data_sort'] = $this->max( 'data_sort' ) + 1;	
	    }
	}

}
