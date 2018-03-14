@extends('layout')

@section('main')
<div class="col-lg-8">
<form method="POST" action = "{{ url('/blog')}}">
  <div class="form-group">
  	{{ csrf_field() }}
  	<label for="category">Category</label>
  	<select name="category_id" class="form-control" id="category">
  		@foreach($category->data->data as $ct) 
  			<option value="{{ $ct->id }}">{{ $ct->category_name }}</option>
  		@endforeach
	</select>
  </div>
   <div class="form-group"> 	
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
  </div>
  <div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control"  name="content" id="content" rows="6"></textarea>
  </div>
  <div class="form-group">
    <label for="tags">Tags</label>
    <input type="text" class="form-control" name="tags" id="tags" placeholder="Ex: home,design">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@endsection