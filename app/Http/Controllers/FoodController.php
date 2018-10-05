<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;
use TM\Crud\CRUDController;

class FoodController extends CRUDController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function food(){

        return view('food.data');

    }
    public function store(Request $request)
    {
        $this->init();

        $request = request()->all();
        $request = $this->store_before($request);

        $model = "App\\" . $this->model;
        $view = $this->model;

        $data = request()->all();

        $data = $model::correct_data($data);


        //return $model::required_fields();
        $this->validate(request(), $model::required_fields());

        if(array_key_exists('password', $data)){
            $data['password'] = Hash::make($data['password']);
        }
        //$data = $this->save_before($data);
        $data = $model::create($data);
        /*if($this->redirect){

            return redirect($this->redirect);
        }*/
        /* return $data;*/
        //$this->redirect = str_replace('arg_id', $data['id'], $this->redirect);


        //return $this->store_after($request, $data, $view);
        return redirect('food/address');

    }
    public function address(){

    }
}
