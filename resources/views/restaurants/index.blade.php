
@extends('restaurants.layout')
     
     @section('content')
         <div class="row py-5">
             <div class="col-lg-12 margin-tb">
                 <div class="pull-left">
                     <h2>Laravel 9 CRUD with multiple images</h2>
                 </div>
                 <div class="pull-right">
                     <a class="btn btn-primary" href="{{ route('restaurants.create') }}"> Create New Restaurant</a>
                 </div>
             </div>
         </div>
         
         @if ($message = Session::get('success'))
             <div class="alert alert-success">
                 <p>{{ $message }}</p>
             </div>
         @endif
          
         <table class="table table-bordered">
             <tr>
                 <th>No</th>
                 <th>Image</th>
                 <th>Name</th>
                 <th width="280px">Action</th>
             </tr>
             @foreach ($restaurants as $restaurant)
             <tr>
                 <td>{{ ++$i }}</td>
                 <td>

                    @foreach (json_decode($restaurant->image) as $image)
                        <img src="/image/{{preg_replace('([^A-Za-z0-9])', '', $restaurant->name)}}/{{ $image }}" width="100px">
                    @endforeach
                   
                </td>
                 <td>{{ $restaurant->name }}</td>
                 <td>
                     <form action="{{ route('restaurants.destroy',$restaurant->id) }}" method="POST">
          
                         <a class="btn btn-info" href="{{ route('restaurants.show',$restaurant->id) }}">Show</a>
           
                         <a class="btn btn-warning" href="{{ route('restaurants.edit',$restaurant->id) }}">Edit</a>
          
                         @csrf
                         @method('DELETE')
             
                         <button type="submit" class="btn btn-danger">Delete</button>
                     </form>
                 </td>
             </tr>
             @endforeach
         </table>
         
         {!! $restaurants->links() !!}
             
     @endsection 