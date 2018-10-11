@extends ('layouts.app')
@section('content')
    {{ csrf_field() }}
    <div id="app" >
        <form class="ui form " @submit.prevent="onSubmit">
            <h1 class="text-center">Food</h1><br>
            <div v-for="find in finds">
                <div class="row mb-3">
                    <div class="col-sm-2 ">
                        {{--<input v-model="find.value">--}}

                        Name
                        <input id="amount" type="name" v-model="find.value" class="form-control " name="food_name" placeholder="Name" value="" required ><br>
                    </div>
                    <div class="col-sm-2 ">
                        Age
                        <input id="amount" type="number" v-model="find.address" class="form-control " name="food_adress" placeholder="Age" value="" required><br>

                    </div>
                    <div class="col-sm-2 ">Quantity
                        <input id="amount" type="name" v-model="find.relation" class="form-control " name="quantity" placeholder="Relation" value="" required><br>
                    </div>

                </div>

            </div>
            <div class="row text-right">
                <div class="col-sm-6 ">
                    <button class="btn btn-info " @click="addFind">
                        Add
                    </button>
                    <button @click="saveData" type="submit" class="btn btn-info createbill"> Add</button>

                </div>
            </div>
            {{-- <pre>@{{ $data | json }}</pre>--}}

            {{--<div class="block-title">Family Members</div>--}}
        </form>
    </div>





    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://unpkg.com/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                csrf_field: '{{ csrf_token() }}',
                user_id: '{{$user_id}}',
                finds: []
            },
            methods: {
                addFind: function () {
                    this.finds.push({ value: '' });
                },
                saveData: function () {
                    this.$http.post('/address', { _token: this.csrf_field, data: this.finds,user_id: this.user_id}).then(function (response) {
                        console.log(response.data)
                        /* if(response.data.status == "success"){
                             //window.location.href = "/bill/"+response.data.id+"/print";
                             window.location.href = "/";
                         }*/
                        window.location.href = "/food/address";
                        // Success
                        console.log(response.data)
                    },function (response) {
                        // Error
                        console.log(response.data)
                    });
                }
            }
        });
    </script>


@endsection
@section('scripts')

@endsection



