@extends ('layouts.app')
@section('content')
    {{ csrf_field() }}
    <div id="app" >
        <form class="ui form " @submit.prevent="onSubmit">
            <h1 class="text-center">Food</h1><br>
            <div v-for="find in finds" >
                <div class="row mb-3">
                    <div class="col-sm-3 ">
                        {{--<input v-model="find.value">--}}

                        Name
                        <input id="amount" type="name" v-model="find.value" class="form-control " name="food_name" placeholder="Name" value="" required ><br>
                    </div>
                    <div class="col-sm-3 ">
                        Address
                        <input id="amount" type="text" v-model="find.address" class="form-control " name="area" placeholder="Address" value="" required><br>

                    </div>
                    <div class="col-sm-3 ">Quantity
                        <input id="amount" type="name" v-model="find.quantity" class="form-control " name="quantity" placeholder="Quantity" value="" required><br>
                    </div>
                   {{-- <div class="col-sm-3 ">
                    <input type="button'" @click="addFind">
                        <img src="{{ asset('images/plus.png') }}" style="height: 25px">
                    </div>--}}

                </div>

            </div>
            <div class="row text-right">
                <div class="col-sm-6 ">
                    <button class="btn btn-info " type="submit" @click="addFind">
                        Add Items
                    </button>

                    <button @click="saveData" type="submit" class="btn btn-info createbill"> Save</button>

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
                    this.$http.post('/food', { _token: this.csrf_field, data: this.finds,user_id: this.user_id}).then(function (response) {
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



