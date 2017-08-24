@extends ('layouts.layout')



@section('content')

	<h1>Create new User</h1>
	

	<div class="col-md-6">
		<form method="POST" action="createaccount">
		
		{{ csrf_field() }}
		
		  <div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name">
		  </div>
		  <div class="form-group">
			<label for="email">Email address</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Email">
		  </div>
		  <div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
		  </div>
		  <input type="hidden" name="type" value="custom">
		  <button type="submit" class="btn btn-default">Create User</button>

		</form>
	</div>
	
	<div class="col-md-6">
		  @include('layouts.errors')
		  
		  @include('layouts.success')
	</div>
	

	
	
	
	
	
@endsection