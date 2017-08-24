@extends ('layouts.layout')



@section('content')
	
	<div class="col-md-8">
		<h1>User list</h1>
	</div>
	<div class="col-md-4">
		<a class="btn btn-success" href="createaccount">New User</a>
	</div>
	
	<div class="col-md-12">
		  @include('layouts.errors')
		  
		  @include('layouts.success')
	</div>
	
	<table class="table table-bordered">
        <tr>
		
			<th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
			<th width="280px">Action</th>
        </tr>
    @foreach ($accounts as $account)

    <tr>
		<td>{{ $account->id }}</td>
        <td>{{ $account->name }}</td>
        <td>{{ $account->email }}</td>
		<td>{{ $account->type }}</td>
        <td>
		
		@if ($account->type == 'custom')
            <a class="btn btn-primary" href="editaccount/{{ $account->id }}">Edit</a>
			<a class="btn btn-danger" href="destroyaccount/{{ $account->id }}">Delete</a>	
		@endif
           
        </td>
    </tr>
    @endforeach
    </table>

	
	

@endsection