
@extends('restaurants.layout')
     
     @section('content')
         <div class="row">
             <div class="col-lg-12 margin-tb">
                 <div class="pull-left">
                     <h2>Edit Restaurant</h2>
                 </div>
                 <div class="pull-right">
                     <a class="btn btn-warning" href="{{ route('restaurants.index') }}"> Back</a>
                 </div>
             </div>
         </div>
          
         @if ($errors->any())
             <div class="alert alert-danger">
                 <strong>Whoops!</strong> There were some problems with your input.<br><br>
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
         
         <form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST" enctype="multipart/form-data"> 
             @csrf
             @method('PUT')
          
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Name:</strong>
                         <input type="text" name="name" value="{{ $restaurant->name }}" class="form-control" placeholder="Name">
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Image:</strong>
                         <input type="file" name="images[]" multiple class="form-control" placeholder="image">
                         <input type="hidden" name="oldImages[]" id="oldImages" multiple class="form-control" placeholder="image" value="{{$restaurant->image}}">
                         <input type="hidden" id="pathImg" multiple class="form-control" placeholder="image" value="/image/{{preg_replace('([^A-Za-z0-9])', '', $restaurant->name)}}/">
                         <input type="hidden" name="imagesToCompare" multiple class="form-control" placeholder="image" value="{{$restaurant->image}}">
                        @foreach (json_decode($restaurant->image) as $image)
                            <img src="/image/{{preg_replace('([^A-Za-z0-9])', '', $restaurant->name)}}/{{ $image }}" width="100px" class="image-restaurant">
                        @endforeach
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                   <button type="submit" class="btn btn-primary">Submit</button>
                 </div>
             </div>
          
         </form>
         <script>
            $( ".image-restaurant" ).click(function() {
                const pathUrl = $("#pathImg").val()
                const oldImages = JSON.parse($("#oldImages").val() || "[]").map((img)=> {
                    return img.replace(pathUrl, '')
                })

                const imageToDelete = $(this).attr("src").replace(pathUrl, '') 
                const imagesToDelete = []

                const imagesArrFiltered = oldImages.filter((img)=> {
                    return img != imageToDelete
                })

                $(this).css("display", "none");

                $("#oldImages").val(JSON.stringify(imagesArrFiltered)) 
            });
         </script>
     @endsection 