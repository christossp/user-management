	<?php $__env->startSection('content'); ?>

<div id="media-library">
<h1>Upload Files</h1>
		<div class="col-md-12 toolbar">
			
			<div class="toolbar-btn-group">
				<form id="uploadFile" method="POST" enctype="multipart/form-data">
				<?php echo e(csrf_field()); ?>

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
				<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
					<?php if($file['type']=='file'): ?>
						<?php  $typeOfFile = 'file';  ?>
					<?php else: ?>
						<?php  $typeOfFile = 'folder'; ?>
					<?php endif; ?>

					<li data-type="<?php echo e($typeOfFile); ?>" data-index="<?php echo e($file['id']); ?>" class="dir-item">
					<div>
						<span><i class="fa fa-<?php echo e($typeOfFile); ?>-o" aria-hidden="true"></i></span>
						<span class="file-name"><?php echo e($file['name']); ?></span>
					</div>
					<span class="file-tools">
						<button class="btn btn-xs no-bg" type="button" data-form="<?php echo e($file['id']); ?>" data-title="Rename <?php echo e($file['name']); ?>" data-message="Rename <?php echo e($file['name']); ?> ?"><a class = "formRename" href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></button>
						<?php echo e(Form::open(array(
						'url' => 'editmedia',
						'method' => 'post',
						'style' => 'display:none',
						'id' => '#edit-form-' . $file['id']))); ?><?php echo e(Form::text('id', $file['id'])); ?><?php echo e(Form::close()); ?>

						 <button class="btn btn-xs no-bg" type="button" data-form="<?php echo e($file['id']); ?>" data-title="Delete <?php echo e($file['name']); ?>" data-message="Are you sure you want to delete <?php echo e($file['name']); ?> ?"><a class = "formConfirm" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></button>
					</span>
						<?php echo e(Form::open(array(
						'url' => 'deletemedia',
						'method' => 'post',
						'style' => 'display:none',
						'id' => '#delete-form-' . $file['id']))); ?><?php echo e(Form::text('id', $file['id'])); ?><?php echo e(Form::close()); ?>

					</li>	
					
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>

	
		<div class="col-md-6">
			  <?php echo $__env->make('layouts.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			  <?php echo $__env->make('layouts.success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
		<?php echo e(csrf_field()); ?>

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
		<?php echo e(csrf_field()); ?>

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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>