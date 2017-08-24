@extends ('layouts.layout')
	@section('content')

<div id="media-library">
<h1>Upload Files</h1>
		<div class="col-md-12 toolbar">
			
			<div class="toolbar-btn-group">
				<form id="uploadFile" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
					 <input type="file" id="adUploadFile" class="filestyle" name="file" data-input="false" data-btnClass="btn-primary"/>	
				</form>
			
				<button class="btn btn-primary" data-toggle="modal" data-target="#createFolder" data-title="Create folder">
					Create Folder
				</button>
			</div>
			
			
				<div class="alert alert-danger alert-white rounded fail" style="display:none;">
					<button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
					<strong></strong> 
				</div>
			
			
		</div>
	  
		</div>
		
		<div class="col-md-11 breadcrumbs">
			<span curent-dir="0">sops</span>
		</div>
		
		<div class="col-md-12 listing">
			<ul class="files-list">
				@foreach($files as $file)
				
					@if($file['type']=='file')
						@php $typeOfFile = 'file'; @endphp
					@else
						@php $typeOfFile = 'folder';@endphp
					@endif

					<li data-type="{{$typeOfFile}}" data-index="{{$file['id']}}" class="dir-item">
					<div>
						<span><i class="fa fa-{{$typeOfFile}}-o" aria-hidden="true"></i></span>
						<span class="file-name">{{$file['name']}}</span>
					</div>
					<span class="file-tools">
						<button class="btn btn-xs no-bg" type="button" data-form="{{$file['id']}}" data-title="Rename {{$file['name']}}" data-message="Rename {{$file['name']}} ?"><a class = "formRename" href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></button>
						{{ Form::open(array(
						'url' => 'editmedia',
						'method' => 'post',
						'style' => 'display:none',
						'id' => '#edit-form-' . $file['id']))}}{{Form::text('id', $file['id'])}}{{ Form::close() }}
						 <button class="btn btn-xs no-bg" type="button" data-form="{{$file['id']}}" data-title="Delete {{$file['name']}}" data-message="Are you sure you want to delete {{$file['name']}} ?"><a class = "formConfirm" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></button>
					</span>
						{{ Form::open(array(
						'url' => 'deletemedia',
						'method' => 'post',
						'style' => 'display:none',
						'id' => '#delete-form-' . $file['id']))}}{{Form::text('id', $file['id'])}}{{ Form::close() }}
					</li>	
					
				@endforeach
			</ul>
		</div>

	
		<div class="col-md-6">
			  @include('layouts.errors')
			  @include('layouts.success')
		</div>
	</div>
		
<div class="modal fade" id="formConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="frm_title">Delete</h4>
      </div>
      <div class="modal-body" id="frm_body"></div>
      <div class="modal-footer">
        <button style='margin-left:10px;' type="button" class="btn btn-primary col-sm-2 pull-right" id="frm_submit">Yes</button>
        <button type="button" class="btn btn-danger col-sm-2 pull-right" data-dismiss="modal" id="frm_cancel">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="formRename" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="frm_title">Rename</h4>
      </div>
      <div class="modal-body" id="frm_body">
	  <form role="form" id="formRename">
		<div class="form-group">
		{{ csrf_field() }}
			<label for="folderName">Folder Name</label>
			<input type="text" class="form-control" id="folderName" name="folderName"/>
		</div>
		
	  </div>
	  	<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="renameDirSubmit">Rename</button>
			</div>		
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="createFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="frm_title">Create folder</h4>
      </div>
      <div class="modal-body" id="frm_body">
	  <form role="form" id="createDir">
		<div class="form-group">
		{{ csrf_field() }}
			<label for="folderName">Folder Name</label>
			<input type="text" class="form-control" id="folderName" name="folderName"/>
			  <div class="modal-footer">
			  <button type="submit" class="btn btn-primary">Create</button>
      </div>	
		</div>             
      </form>
	  </div>
	
    </div>
  </div>
</div>

@endsection

