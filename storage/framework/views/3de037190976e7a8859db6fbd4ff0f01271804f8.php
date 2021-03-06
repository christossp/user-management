	<?php $__env->startSection('content'); ?>


<div id="media-library" class="clearfix">
	<h1>Import from Active Directory</h1>
	<div class="col-md-12 toolbar">
	
		<h4>Choose Region/s</h4><hr />
		
		<button id="fetchusers" class="btn btn-primary" data-toggle="modal" data-target="#createFolder" data-title="Create folder">
					Fetch Users
		</button>
		
		<form id="fetchusersfromad" method="POST" enctype="multipart/form-data" action="adimport">
			<?php echo e(csrf_field()); ?>	 

			<div class="form-group-checkboxes">
				<input type="checkbox" name="node[0]" id="fancy-checkbox-default" autocomplete="off" value="OU=Montreal,OU=Canada" />
				<div class="[ btn-group ]">
					<label for="fancy-checkbox-default" class="btn btn-default">
						<span class="[ glyphicon glyphicon-ok ]"></span>
						<span> </span>
					</label>
					<label for="fancy-checkbox-default" class="[ btn btn-default active ]">
						Montreal-Canada
					</label>
				</div>
			</div>
			<div class="form-group-checkboxes">
				<input type="checkbox" name="node[1]" id="fancy-checkbox-primary" autocomplete="off" value="OU=Bogota,OU=Colombia"/>
				<div class="[ btn-group ]">
					<label for="fancy-checkbox-primary" class="btn btn-default">
						<span class="[ glyphicon glyphicon-ok ]"></span>
						<span> </span>
					</label>
					<label for="fancy-checkbox-primary" class="[ btn btn-default active ]">
						Bogota-Colombia
					</label>
				</div>
			</div>
			<div class="form-group-checkboxes">
				<input type="checkbox" name="node[2]" id="fancy-checkbox-success" autocomplete="off" value="OU=Faridabad,OU=India"/>
				<div class="[ btn-group ]">
					<label for="fancy-checkbox-success" class="btn btn-default">
						<span class="[ glyphicon glyphicon-ok ]"></span>
						<span> </span>
					</label>
					<label for="fancy-checkbox-success" class="[ btn btn-default active ]">
						Faridabad-India
					</label>
				</div>
			</div>
			<div class="form-group-checkboxes">
				<input type="checkbox" name="node[3]" id="fancy-checkbox-info" autocomplete="off" value="OU=Regional Offices,OU=India"/>
				<div class="[ btn-group ]">
					<label for="fancy-checkbox-info" class="btn btn-default">
						<span class="[ glyphicon glyphicon-ok ]"></span>
						<span> </span>
					</label>
					<label for="fancy-checkbox-info" class="[ btn btn-default active ]">
						Regional Offices-India
					</label>
				</div>
			</div>
			<div class="form-group-checkboxes">
				<input type="checkbox" name="node[4]" id="fancy-checkbox-warning" autocomplete="off" value="OU=Warsaw,OU=Poland"/>
				<div class="[ btn-group ]">
					<label for="fancy-checkbox-warning" class="btn btn-default">
						<span class="[ glyphicon glyphicon-ok ]"></span>
						<span> </span>
					</label>
					<label for="fancy-checkbox-warning" class="[ btn btn-default active ]">
						Warsaw-Poland
					</label>
				</div>
			</div>
			
		</form>
	</div>
</div>

<?php if(isset($users)): ?>
	
<div class="tableOfUsers">
    

<form id="importSelectedUsers" method="POST" action="importselectedusers">
<?php echo e(csrf_field()); ?>	 
	<button id="importUsers" class="btn btn-primary">Import</button>
	<!--<input type="Submit"/>-->
	<table id="usersTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Import</th>
					<th>Name</th>
					<th>Email</th>
					<th>Region</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Import</th>
					<th>Name</th>
					<th>Email</th>
					<th>Region</th>
				</tr>
			</tfoot>
			<tbody>
		<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			
			
			<?php $trCss = '';  $inputStyle = ''; ?>
			<?php if($user['stored']=='yes'): ?>
				<?php 
					  $trCss = 'already-imported';  
					  $inputStyle = 'hide';  
				?>
			<?php endif; ?>

				
				
		
			<tr class="<?php echo e($trCss); ?>">
				<td><input class="insert-checkbox <?php echo e($inputStyle); ?>" name="checkbox[]" type="checkbox" id="<?php echo e($user['name']); ?>" value="<?php echo e($user['email']); ?>:<?php echo e($user['name']); ?>"/></td>
				<td><?php echo e($user['name']); ?></td>
				<td><?php echo e($user['email']); ?></td>
				<td><?php echo e($user['place']); ?></td>
			</tr>
		

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		
				
		</tbody>
	</table>
	
<form>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>