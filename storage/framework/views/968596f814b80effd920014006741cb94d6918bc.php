<?php $__env->startSection('content'); ?>
	
	<div class="col-md-8">
		<h1>User list</h1>
	</div>
	<div class="col-md-4">
		<a class="btn btn-success" href="createaccount">New User</a>
	</div>
	
	<div class="col-md-12">
		  <?php echo $__env->make('layouts.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		  
		  <?php echo $__env->make('layouts.success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</div>
	
	<table class="table table-bordered">
        <tr>
		
			<th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
			<th width="280px">Action</th>
        </tr>
    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <tr>
		<td><?php echo e($account->id); ?></td>
        <td><?php echo e($account->name); ?></td>
        <td><?php echo e($account->email); ?></td>
		<td><?php echo e($account->type); ?></td>
        <td>
		
		<?php if($account->type == 'custom'): ?>
            <a class="btn btn-primary" href="editaccount/<?php echo e($account->id); ?>">Edit</a>
			<a class="btn btn-danger" href="destroyaccount/<?php echo e($account->id); ?>">Delete</a>	
		<?php endif; ?>
           
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

	
	

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>