@extends ('layouts.layout2')



@section('content')

	<h1>Edit User </h1><h2 class="text-primary">{{$account->name}}</h2>
	
	<div class="col-md-6">
		<form method="POST" action="../editaccount/{{$account->id}}">
		
		{{ csrf_field() }}
		
		  <div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$account->name}}">
		  </div>
		  <div class="form-group">
			<label for="email">Email address</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$account->email}}">
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
		  @include('layouts.errors')
		  
		  @include('layouts.success')
	</div>
	

	
	
	
	
	
@endsection