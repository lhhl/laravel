<div id="customModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Uploader</h4>
      </div>
      <div class="modal-body">
      <!-- Modal begin body-->
            {!! Form::open( ['route' => 'customers.upload', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',  "enctype" => "multipart/form-data", 'id' => 'fileupload'] ) !!}
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input class="file" type="file" name="image">
                    </span>
                    <button type="button" disabled="disabled" name="btnUpload" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>

            {!! Form::close() !!}
            <p align="center" style="margin-top: 10px;"><img id="output"></p>
            
            <div class="progress" style="margin-top: 10px; opacity: 0;">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
              aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-text">vfdsvdfv</div>
                </div>
            </div>
            

            <div class="alert alert-danger" name="messagePanel" style="display:none; clear: both">
                <p><strong><span class="errorUploader"></span></strong></p>
            </div>
        <!-- Modal end body-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>