<?php $__env->startSection('content'); ?>

	<h1>Edit User </h1><h2 class="text-primary"><?php echo e($account->name); ?></h2>
	
	<div class="col-md-6">
		<form method="POST" action="../editaccount/<?php echo e($account->id); ?>">
		
		<?php echo e(csrf_field()); ?>

		
		  <div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo e($account->name); ?>">
		  </div>
		  <div class="form-group">
			<label for="email">Email address</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo e($account->email); ?>">
		  </div>
		  <div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
		  </div>
		  <input type="hidden" name="type" value="custom">
		  <button type="submit" class="btn btn-default">Update User</button>

		</form>
	</div>
	

	
	<div class="col-md-6">
		  <?php echo $__env->make('layouts.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		  
		  <?php echo $__env->make('layouts.success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</div>
	

	
	
	
	
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>