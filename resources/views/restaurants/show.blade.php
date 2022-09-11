@extends('restaurants.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Restaurant</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('restaurants.index') }}"> Back</a>
            </div>
        </div>
    </div>
     
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $restaurant->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image:</strong>
                @foreach (json_decode($restaurant->image) as $image)
                    <img src="/image/{{ preg_replace('([^A-Za-z0-9])', '', $restaurant->name)}}/{{ $image }}" width="100px">
                @endforeach
            </div>
        </div>
    </div>
@endsection 