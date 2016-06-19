<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Requests\FormValidateRequest;
use DB;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIController;
use Paginator;

class AdminPatternController extends Controller
{
    protected $model;
    protected $colDisplay = ['*'];
    protected $orderBy =  [ 'id', 'DESC' ];
    protected $itemPerPage = 5;

	protected $formValidateRequest, $formRender, $lang, $theme;
    protected $alias = 'Admin\\';
    protected $formFeatureShowable = [
        'add', 'edit', 'delete', 'display', 'default'
    ];
    protected $defaultColSearch;
    protected $platform;

    function __construct( Request $request ){
        include_once(app_path() . '\Settings\lang\en-EN.php');
        $this->lang = unserialize(BACKEND_TEXT);
        $this->theme = 'BlackGray';
        $this->platform = ( explode( '/', $request->path() )[0] ) == 'api' ? 'api' : 'web';
        $this->formRender = $this->generateFormRenderArr();
    }

    public function index( Request $request ){
        $data[ 'search' ] = $request->get( 'search' );
        session( ['search' => $data[ 'search' ]] );

        $searchStr = $this->smartSearch( $data[ 'search' ] );

        $data[ 'list' ] = $this->model
                        ->select( $this->colDisplay )
                        ->orderBy( $this->orderBy[0], $this->orderBy[1] )
                        ->where( $searchStr[0], 'like', '%' . $searchStr[1] . '%' );
        $data [ 'all' ] = $data[ 'list' ]->get();
        if( $this->platform == 'api' ){
            return $data [ 'all' ];
        }
    	
        $data[ 'list' ] = $data[ 'list' ]->paginate($this->itemPerPage);
        $data[ 'showable' ] = $this->formFeatureShowable;
        $data[ 'alias' ] = $this->alias;
        $data[ 'textControl' ] = $this->lang['text_control'];
        if( $data[ 'list' ]->total() == 0 ){
            $data[ 'list' ] = [
                'no_record_message' =>  $this->lang[ 'info' ][ 'noRecord' ]
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
        $data[ 'start_index' ] = ( session( 'page' ) * $this->itemPerPage ) - $this->itemPerPage;
    	return view( 'themes.' . $this->theme . '.admin.show', $data );
    }

    public function create(  ){
        $this->checkSessionPage();
    	$data[ 'status' ] = 'create';
        $data[ 'page' ] = session( 'page' );
        $data[ 'alias' ] = $this->alias;
    	$data[ 'formRender' ] = $this->generateFormRenderArr();
        if( $this->platform == 'api' ){
            return $data[ 'formRender' ];
        }
    	return view( 'themes.' . $this->theme . '.admin.form', $data );
    }

    public function store( Request $request ){
        return $this->insertupdateData( $request );
    }

    public function update( Request $request, $id ){
        $id = (int)$id;
        return $this->insertupdateData( $request, $id );
    }

    public function edit( $idRecord ){
        
        $this->checkSessionPage();
        $id = (int) $idRecord;
        $data[ 'record' ] = $this->model->select( $this->colDisplay )->find( $id );
        if( is_null( $data[ 'record' ] ) ){
            if( $this->platform == 'api' ){
                return ['error' => $this->lang[ 'error' ][ 'recordNotFound' ]];
            }
            $this->messageLog( 'recordNotFound', 'error' );
            return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
        }

        if( $this->platform == 'api' ){
            return $data[ 'record' ];
        }
        $data[ 'alias' ] = $this->alias;
        $data[ 'page' ] = session( 'page' );
        $data[ 'status' ] = 'edit';
        $data[ 'formRender' ] = $this->generateFormRenderArr( true );
        return view( 'themes.' . $this->theme . '.admin.form', $data );
    }

    public function destroy( $id ){
        $id = (int)$id;
        $record = $this->model->find( $id );
        $record->delete();
        return redirect()->action( $this->alias . 'Controller@index' );
    }

    public function multidestroy( Request $request ){
        $arrId = explode( ',', $request->get( 'idRecord' ) );
        $this->checkSessionPage();
        $success = true;
        foreach ($arrId as $id) {
            $arrId[$index] = $id = (int)$id;
            $record = $this->model->find( $id );
            if( is_null( $record ) )
            {
                $success = false;
                $this->messageLog( 'recordNotFound', 'error' );
                break;
            }
            
        }   
        if( $success ){
            DB::beginTransaction();
            try{
                $record->destroy( $arrId );
                DB::commit();
                $this->messageLog( 'delete', 'success' );
            }catch( \Exception $e ){
                DB::rollback();
                $this->messageLog( 'delete', 'error' );
            }
        }
        
        return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ), 'search' => session( 'search' ) ] );
    }

    public function changedisplay( Request $request ){
        $arrId = explode( ',', $request->get( 'idRecord' ) );
        $this->checkSessionPage();
        DB::beginTransaction();
        $success = true;
        foreach ($arrId as $index => $id) {
            $id = (int)$id;
            $record = $this->model->find( $id );
            if( is_null( $record ) )
            {
                DB::rollback();
                $success = false;
                $this->messageLog( 'recordNotFound', 'error' );
                break;
            }else{
                try{
                    $record->where( 'id', '=', $id )->update( [ 'data_display' => !$record->data_display ] );
                }catch( \Exception $e ){
                    $this->messageLog( 'changeDisplay', 'error' );
                    DB::rollback();
                }
            }
            
        }   
        if( $success ){
            DB::commit();
            $this->messageLog( 'changeDisplay', 'success' );
        }
        
        return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ), 'search' => session( 'search' ) ] );
    }

    public function swapsort( $id1, $id2 ){
        $id1 = (int)$id1;
        $id2 = (int)$id2;
        $this->checkSessionPage();
        $sort1 = $this->model->select( 'data_sort' )->where( 'id', '=', $id1 )->first()->data_sort;
        $sort2 = $this->model->select( 'data_sort' )->where( 'id', '=', $id2 )->first()->data_sort;
        if( is_null( $sort1 ) || is_null( $sort2 ) ){
            $this->messageLog( 'recordNotFound', 'error' );
        }else{
            DB::beginTransaction();
            try{
                $this->model->where( 'id', '=', $id1 )->update([ 'data_sort' => (int)$sort2 ]);
                $this->model->where( 'id', '=', $id2 )->update([ 'data_sort' => (int)$sort1 ]);
                DB::commit();
                $this->messageLog( 'changeSort', 'success' );
            }catch( \Exception $e ){
                $this->messageLog( 'changeSort', 'error' );
                DB::rollback();
            }
        }
        return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ), 'search' => session( 'search' ) ] );
    }

    public function setdefault( $id ){
        $id = (int)$id;
        $record = $this->model->find( $id );
        if( is_null( $record ) ){
            $this->messageLog( 'recordNotFound', 'error' );
        }else{
            DB::beginTransaction();
            try{
                $this->model->where( 'data_default', '=', 1 )->update( [ 'data_default' => 0 ] );
                $this->model->where( 'id', '=', $id )->update( [ 'data_default' => 1 ] );
                DB::commit();
                $this->messageLog( 'setDefault', 'success' );
            }catch( \Exception $e ){
                $this->messageLog( 'setDefault', 'error' );
                DB::rollback();
            }
        }
        return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ), 'search' => session( 'search' ) ] );
    }

    public function generateFormRenderArr( $edit = false ){
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
        var_dump($this->formRender['data_default']);
        foreach ($this->formRender as $key => $value) {
            if ( $key != '#control' ){
                $rules[ $key ] = $value['validate'];
            }
        }

        $validator = Validator::make( $input, $rules, $this->lang['message'] );
        return $validator;

    }

    public function insertupdateData( $request, $id = null ){
        $this->checkSessionPage();

        $validator = $this->validateForm( $request->all() );
        $backPage = is_null( $id ) ? 'create' : 'edit';

        if ( $validator->fails() ){
            if( $this->platform == 'api' ){
                return ['success' => 'false'];
            }else{
                return redirect()->action( $this->alias . 'Controller@' . $backPage, [ $id ] )
                                ->withErrors( $validator )
                                ->withInput();
            }
        }else{
            if( in_array( 'data_default', $this->colDisplay) && $request->input( 'data_default' ) == 1 ){

                $this->model->where( 'data_default', '=', 1 )->update( [ 'data_default' => 0 ] );
            }

            
            $this->submitData( $request->all(), $id );
            

            if( $this->platform == 'api' ){
                return ['success' => 'true'];
            }else{
                return redirect()->action( $this->alias . 'Controller@index', [ 'page' => session( 'page' ) ] );
            }
        }
    }

    public function submitData( $input, $editId = null ){

        if ( !is_null( $editId ) ){
            $record = $this->model->find( $editId );
            if( !is_null( $record ) ){

                try{
                    $record->update( $input );
                }catch( \Exception $e ){
                    $this->messageLog( 'update', 'error' );
                    return false;
                }
                $this->messageLog( 'update', 'success' );
            }else{
                $this->messageLog( 'recordNotFound', 'error' );
                return false;
            }
        }else{

            try{
                $this->model->create( $input );
            }catch( \Exception $e ){
                $this->messageLog( 'insert', 'error' );
                return false;
            }
            $this->messageLog( 'insert', 'success' );
        }
        
        return true;
    }

    public function checkSessionPage(){
        if( is_null( session( 'page' ) ) ){
            session( [ 'page' => 1] );
        }
    }

    public function clearSession(){
        Session::flush();
    }

    public function messageLog( $key, $type ){
        $msg = [];

        switch ( $type ) {
            case 'success':
                $msg = [
                    'type' => $type,
                    'content' => $this->lang[ $type ][ $key ],
                    'icon' => 'ok-sign green',
                ];
                break;

            case 'error':
                $msg = [
                    'type' => 'danger',
                    'content' => $this->lang[ $type ][ $key ],
                    'icon' => 'remove-sign red',
                ];
                break;

            case 'warning':
                $msg = [
                    'type' => $type,
                    'content' => $this->lang[ $type ][ $key ],
                    'icon' => 'minus-sign yellow',
                ];
                break;
        }
        session( [ 'customMessage' => $msg ] );
    }

    public function smartSearch( $search ){
        $search = urldecode( $search );
        $arr_temp = explode( ':', $search );
        if( count( $arr_temp ) == 2 ){
            if( in_array( $arr_temp[0], $this->colDisplay ) ){
                return $arr_temp;
            }
        }
        
        $arr_temp[0] = $this->defaultColSearch;
        $arr_temp[1] = $search;

        return $arr_temp;
    }

}
