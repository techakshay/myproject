<?php

namespace Tests\Browser;

use App\Item;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FormTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    /*public function testTutorForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->resize(1920, 1080);
            //items
            $forms = [
                "items" => "items",
                //"customer" => "customer",
                //"vendor" => "vendor",
                //"bill" => "bill",
                //"payment" => "payment"
            ];
            foreach($forms as $item) {
                $model = "\App\\".title_case($item);
                $form = $model::form();
                $name = $item.".create";
                $this->checkForm($browser, $form, $name);
                $this->fillForm($browser, $form, $name);
                $this->checkFormAfter($browser, $form, $name);
            }
        });
    }*/

    public $counter = 0;

    public function testItems(){
        $this->counter = 1;
        $this->form("items");
    }

    public function testCustomer(){
        $this->counter = 2;
        $this->form("customer");
    }

    public function testVendor(){
        $this->counter = 3;
        $this->form("vendor");
    }

    public function testBill(){
        $this->counter = 4;
        $this->form("bill", "Bills");
    }

    public function testPayment(){
        $this->counter = 5;
        $this->form("payment");
    }

    public function form($item, $model = "")
    {

        if(!$model){
            $model = title_case($item);
        }

        $model = "\App\\".$model;

        $this->browse(function (Browser $browser) use ($item, $model) {
            $browser->loginAs(User::find(1));
            $browser->resize(1920, 1080);
            //items

            //foreach($forms as $item) {

                $form = $model::form();
                $name = $item.".create";
                $this->checkForm($browser, $form, $name);
                $this->fillForm($browser, $form, $name);
                $this->fillRequiredForm($browser, $form, $name);
                $this->checkFormAfter($browser, $form, $name);
            //}
        });
    }


    public function checkForm($browser, $form, $name){


        fwrite(STDERR, print_r($name, TRUE));
        $browser->visit(route($name))
            ->screenshot($this->counter."_".$name."_1_".__FUNCTION__."_load")
            ->press('submit');

        foreach ($form as $key => $item) {

            if(!isset($item['required']) || !$item['required']) continue;
            if(isset($item['value']) && empty($item['value'])) continue;

            $item['name'] = $item['name'] ?? $key;
            if ((!isset($item['value']) || !$item["value"]) && strstr($item['name'],"_confirmation") === false) {
                $error_text = str_replace('_', ' ', $item['name']);
                $browser->assertSee("The $error_text field is required.");
            }
        }

        $browser->screenshot($this->counter."_".$name."_2_".__FUNCTION__);
    }

    public function fillForm($browser, $form, $name){

        /*$browser->attach('resume', __DIR__ . '/images/sample.pdf');
        $browser->press('submit');
        return;*/
        foreach ($form as $key => $field) {
            $item['name'] = $item['name'] ?? $key;
            //$key = $field['name'];
            //if ((!isset($item['value']) || !$item["value"]) && strstr($item['name'],"_confirmation") === false) {
            //$error_text = str_replace('_', ' ', $item['name']);
            /*if($item['type'] == "radio"){
                $browser->type($item['name'], "test");
            } else {
                $browser->type($item['name'], "test");
            }*/
            if ($field['type'] == "radio") {
                $array = array_flip($field["options"]);
                $value = end($array);
                $browser->radio($key, $value);
            } elseif ($field['type'] == "select") {
                $array = array_flip($field["options"]);
                $value = end($array);
                $browser->select($key, $value);
            } elseif ($field['type'] == "date") {
                //$browser2->type($key, "01062018");
            } else if ($field['type'] == "text") {
                $browser->type($key, "Akshay");
            }else if ($field['type'] == "file") {
                $browser->attach($key, __DIR__ . '/images/sample.pdf');
                //$browser2->value($key, "akshay@gmail.com");

            }
            else if ($field['type'] == "email") {
                $browser->type($key, "akshay@gmail.com");
            }
            elseif ($field['type'] == "number") {
                $browser->type($key, 1000);
            }elseif ($field['type'] == "boolean") {
                $browser->check($key);
                //$browser2->value($key, "akshay@gmail.com");

            } elseif($field['type'] == "password") {
                $browser->type($key, "123456");
            }

            //}
        }
        //$browser->screenshot($name.__FUNCTION__);
        $browser->screenshot($this->counter."_".$name."_3_".__FUNCTION__);
        $browser->press('submit');

    }

    public function checkFormAfter($browser, $form, $name){

        $browser->screenshot($this->counter."_".$name."_4_".__FUNCTION__);
        foreach ($form as $key => $item) {
            $item['name'] = $item['name'] ?? $key;
            if ((!isset($item['value']) || !$item["value"]) && strstr($item['name'],"_confirmation") === false) {
                $error_text = str_replace('_', ' ', $item['name']);
                $browser->assertDontSee("The $error_text field is required.");
            }
        }
    }

    public function fillRequiredForm($browser, $form, $name){

        /*$browser->attach('resume', __DIR__ . '/images/sample.pdf');
        $browser->press('submit');
        return;*/
        $browser->visit(route($name));
        $browser->screenshot($this->counter."_".$name."_5_".__FUNCTION__."_pre");
        foreach ($form as $key => $field) {
            $item['name'] = $item['name'] ?? $key;
            //$key = $field['name'];
            //if ((!isset($item['value']) || !$item["value"]) && strstr($item['name'],"_confirmation") === false) {
            //$error_text = str_replace('_', ' ', $item['name']);
            /*if($item['type'] == "radio"){
                $browser->type($item['name'], "test");
            } else {
                $browser->type($item['name'], "test");
            }*/

            if(!isset($item['required']) || !$item['required']) continue;

            if ($field['type'] == "radio") {
                $array = array_flip($field["options"]);
                $value = end($array);
                $browser->radio($key, $value);
            } elseif ($field['type'] == "select") {
                $array = array_flip($field["options"]);
                $value = end($array);
                $browser->select($key, $value);
            } elseif ($field['type'] == "date") {
                //$browser2->type($key, "01062018");
            } else if ($field['type'] == "text") {
                $browser->type($key, "Akshay");
            }else if ($field['type'] == "file") {
                $browser->attach($key, __DIR__ . '/images/sample.pdf');
                //$browser2->value($key, "akshay@gmail.com");

            }
            else if ($field['type'] == "email") {
                $browser->type($key, "akshay@gmail.com");
            }
            elseif ($field['type'] == "number") {
                $browser->type($key, 1000);
            }elseif ($field['type'] == "boolean") {
                $browser->check($key);
                //$browser2->value($key, "akshay@gmail.com");

            } elseif($field['type'] == "password") {
                $browser->type($key, "123456");
            }

            //}
        }
        //$browser->screenshot($name.__FUNCTION__);
        $browser->screenshot($this->counter."_".$name."_5_".__FUNCTION__);
        $browser->press('submit');

    }
}
