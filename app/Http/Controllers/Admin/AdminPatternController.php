<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Requests\FormValidateRequest;
use DB;
use Session;
use App\Http\Controllers\Controller;

class AdminPatternController extends Controller
{
	protected $model, $formValidateRequest, $formRender, $lang, $theme;
    protected $alias = 'Admin\\';
    protected $colDisplay = ['*'];
    protected $orderBy =  [ 'id', 'DESC' ];
    protected $itemPerPage = 5;
    protected $formFeatureShowable = [
        'add', 'edit', 'delete', 'display'
    ];

    function __construct(){
        include_once(app_path() . '\Settings\lang\en-EN.php');
        $this->lang = unserialize(APPTEXT);
        $this->theme = 'BlackGray';
    }

    public function index(  ){

    	$data[ 'list' ] = $this->model
                                ->select( $this->colDisplay )
                                ->orderBy( $this->orderBy[0], $this->orderBy[1] )
                                ->paginate($this->itemPerPage);
        $data[ 'showable' ] = $this->formFeatureShowable;
        $data[ 'alias' ] = $this->alias;
        $data[ 'textControl' ] = $this->lang['text_control'];
        if( $data[ 'list' ]->total() == 0 ){
            $data[ 'list' ] = [
                'no_record_message' =>  $this->lang[ 'info' ][ 'no_record' ]
            ];
            $data[ 'showable' ] = [ 'add' ];
            return view( 'themes.' . $this->theme . '.admin.show', $data );
        }
        $lastPage = $data[ 'list' ]->lastPage();
        session( [ 'page' => $data[ 'list' ]->currentPage() ] );
        if( session( 'page' ) > $lastPage )
        {
            return redirect()->action( $this->alias . 'Controller@index', [ 'page' => $lastPage ] );
        }

        
    	return view( 'themes.' . $this->theme . '.admin.show', $data );
    }

    public function create(){
        $this->checkSessionPage();
    	$data[ 'status' ] = 'create';
        $data[ 'page' ] = session( 'page' );
        $data[ 'alias' ] = $this->alias;
    	$data[ 'formRender' ] = $this->genarateFormRenderArr();
    	return view( 'themes.' . $this->theme . '.admin.form', $data );
    }

    public function store( Request $request ){
        $this->checkSessionPage();
        $validator = $this->validateForm( $request->all() );
    	if ( $validator->fails() ){
            return redirect()->action( $this->alias . 'Controller@create' )
                            ->withErrors( $validator )
                            ->withInput();
        }else{
            $this->submitData( $request->all() );
            return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
        }
    }

    public function edit( $idRecord ){
        $this->checkSessionPage();
        $id = (int) $idRecord;
        $data[ 'record' ] = $this->model->find( $id );
        if( is_null( $data[ 'record' ] ) ){
            session( [ 'custom_error' => [ $this->lang[ 'error' ][ 'not_found_record' ] ] ] );
            return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
        }
        $data[ 'alias' ] = $this->alias;
        $data[ 'page' ] = session( 'page' );
        $data[ 'status' ] = 'edit';
        $data[ 'formRender' ] = $this->genarateFormRenderArr( true );
        return view( 'themes.' . $this->theme . '.admin.form', $data );
    }

    public function update( Request $request, $id ){
        $validator = $this->validateForm( $request->all() );
        if ( $validator->fails() ){
            return redirect()->action( $this->alias . 'Controller@edit', $id )
                            ->withErrors( $validator )
                            ->withInput();
        }else{
            $this->submitData( $request->all(), $id );
            return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
        }
    }

    public function destroy( $id ){
        $record = $this->model->find( $id );
        $record->delete();
        return redirect()->action( $this->alias . 'Controller@index' );
    }

    public function genarateFormRenderArr( $edit = false ){
        $textControl = $this->lang['text_control'];
        $arr = [
            'title' => '',
            'type' => 'textbox',
            'validate' => '',
            'default_value' => null,
            'placeholder' => '',
        ];

        $arr_control = [
            'submit' => ($edit) ? $textControl[ 'update_button' ] : $textControl[ 'add_button' ],
            'reset' => $textControl[ 'cancel_button' ],
            'back' => $textControl[ 'back_button' ]
        ];

        $formRender = $this->formRender;
        foreach ($formRender as $key => $value) {
            if( $key != '#control' ){
                $formRender[$key] = array_merge( $arr, $value );
                if ( $formRender[$key]['title'] == ''){
                    $formRender[$key]['title'] = ucfirst( $key );
                }

                if ( $formRender[$key]['placeholder'] == ''){
                    $formRender[$key]['placeholder'] = 'Please enter ' . ucfirst( $key );
                }
            }
        }
        $formRender['#control'] = $arr_control;

        if ( $edit ){
             $formRender[$key]['submit'] = $textControl[ 'update_button' ];
        }

        return $formRender;
    }

    public function validateForm( $input ){
        $rules = [];

        foreach ($this->formRender as $key => $value) {
            if ( $key != '#control' ){
                $rules[ $key ] = $value['validate'];
            }
        }

        $validator = Validator::make( $input, $rules, $this->lang['message'] );
        return $validator;

    }

    public function submitData( $input, $editId = -1 ){
        try{
            if ( $editId != -1 ){
                $record = $this->model->find( $editId );
                $record->update( $input );
            }else{
                $this->model->create( $input );
            }
        }catch( \Exception $e ){
            return false;
        }
        return true;
    }

    public function multidestroy( Request $request ){
        $arrId = explode( ',', $request->get( 'idRecord' ) );
        $this->checkSessionPage();
        DB::beginTransaction();
        $success = true;
        foreach ($arrId as $id) {
            
            $record = $this->model->find( $id );
            if( is_null( $record ) )
            {
                DB::rollback();
                $success = false;
                session( [ 'custom_error' => [ $this->lang[ 'error' ][ 'not_found_record' ] ] ] );
                break;
            }else{
                $record->delete();
            }
            
        }   
        if( $success ){
            DB::commit();
        }
        
        return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
    }

    public function checkSessionPage(){
        if( is_null( session( 'page' ) ) ){
            session( [ 'page' => 1] );
        }
    }

    public function clearSession(){
        Session::flush();
    }

}
