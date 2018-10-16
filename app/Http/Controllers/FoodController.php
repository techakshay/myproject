<?php

namespace App\Http\Controllers;

use App\Food;
use App\FoodAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

//use TM\Crud\CRUDController;

class FoodController extends CRUDController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function init(){

        $this->model = "Food";
        $this->action = "food";
        $this->redirect = "food"; // /bill/items/1/

        //$this->keys = ['id', 'product_name','potency','packing','hsn_code','mfg_code','gst', 'available'];
        //$this->headers = ['ID', 'Product Name','Potency','Packing','Hsn Code','Mfg Code','Gst', 'Available'];
    }

    public function food(){

        return view('food.data');

    }
    public function store(Request $request)
    {
        foreach ($request['data'] as $data) {

            $abc[] = $data;

            /*$name = $data['value'];
            $age = $data['age'];
            $relation = $data['relation'];
            $age = $data['age'];
            $aadhar_no = $data['aadhar_no'];*/
        }
        //return $abc;
        $no = 1;
        foreach ($abc as $data) {
//return $data['quantity'];

            //Family::where('name',$data['value'])->where('age',$data['age'])->where('relation',$data['relation']);
                $food = new Food();
                $food->food_name = $data['value'];
                $food->area = $data['address'];
                $food->quantity = $data['quantity'];
            $food->save();
                session()->flash('success', "Items Added Successfully");
                //return redirect('/services');
            }
         /*   $request = $this->store_before($request);

            $model = "App\\" . $this->model;
            $view = $this->model;

            $data = request()->all();

            $data = $model::correct_data($data);


            //return $model::required_fields();
            $this->validate(request(), $model::required_fields());

            if (array_key_exists('password', $data)) {
                $data['password'] = Hash::make($data['password']);
            }
            //$data = $this->save_before($data);
            unset($data['submit']);
            $data = $model::create($data);
            /*if($this->redirect){

                return redirect($this->redirect);
            }*/
            /* return $data;*/
            //$this->redirect = str_replace('arg_id', $data['id'], $this->redirect);


            //return $this->store_after($request, $data, $view);
            //return redirect('food/address');


        }



        public function address()
        {
            //return 's';
            $this->init();

            $args = func_get_args();
            if(count($args) > 0) {
                list($prefill_data) =  $args;
            }


            $model = "App\\".$this->model;
            $action = 'address/store';
            $view=$this->model;
            $form['fields'] = FoodAddress::form();


            if(isset($prefill_data) && is_array($prefill_data) && count($prefill_data)) {
                foreach ($form['fields'] as $key => &$field) {
                    $field['value'] = $prefill_data[$key];

                }
            }

            $form['data']['action'] = $action;
            $form['data']['heading'] = "Address";
            $form['data']['type'] = "add";
            $form['data']['submit'] = "Add";




            return view('forms.add',compact( "form", 'action','view'));
        }
        public function address_store(Request $request){

        $data = $request;
            //$data = FoodAddress::create($data);
            $food = new FoodAddress();
            $food->name = $data->name;
            $food->user_id = auth()->user()->id;
            $food->address = $data->address;
            $food->phone_no = $data->phone_no;
            $food->save();
            session()->flash('success', "Items Added Successfully");
            return \redirect('/');
            //return Redirect::back();

        }
        public function create()
        {
            $user_id = auth()->user()->id;
        return view('food.create',compact('user_id'));
        }
        public function thankyou(){

        return view('food.thankyou');
        }

}


