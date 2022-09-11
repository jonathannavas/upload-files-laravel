<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::latest()->paginate(5);
        return view('restaurants.index',compact('restaurants'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();
        $validName = preg_replace('([^A-Za-z0-9])', '', $input["name"]);
        if($request->hasfile('images'))
        {

           foreach($request->file('images') as $image)
           {
               $name=time().'.'.$image->getClientOriginalName();
               $image->move(public_path().'/image/'.$validName.'/', $name);  
               $data[] = $name;  
           }
        }
        $input["image"] = json_encode($data);
        Restaurant::create($input);
     
        return redirect()->route('restaurants.index')
                        ->with('success','Restaurant created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        return view('restaurants.show',compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        return view('restaurants.edit',compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();
        $validName = preg_replace('([^A-Za-z0-9])', '', $input["name"]);
        if($request->hasfile('images'))
        {
            if($input["oldImages"]!=null){
                foreach(json_decode($input["oldImages"][0]) as $oldImage){
                    unlink(public_path().'/image/'.$validName.'/'.$oldImage);
                }
            }
           foreach($request->file('images') as $image)
           {
               $name=time().'.'.$image->getClientOriginalName();
               $image->move(public_path().'/image/'.$validName.'/', $name);  
               $data[] = $name;  
           }
           $input["image"] = json_encode($data);

        }else{
            unset($input['image']);
        }
          
        $restaurant->update($input);
    
        return redirect()->route('restaurants.index')
                        ->with('success','Restaurant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $nameRestaurant = $restaurant->name;
        $validName = preg_replace('([^A-Za-z0-9])', '', $nameRestaurant);
        if($restaurant->image != null){
            foreach(json_decode($restaurant->image) as $img){
                unlink(public_path().'/image/'.$validName.'/'.$img);
            }
        }
        $restaurant->delete();
        return redirect()->route('restaurants.index')
                        ->with('success','Restaurant deleted successfully');
    }
}
