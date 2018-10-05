@extends ('layouts.app')

@section('content')

    <link rel="stylesheet" href="">




    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
    <div class="container">
        <div class="col-sm-8 blog-main">
            <h1> {{$form['data']['heading']}}<strong> {{--{{$project->name}}--}} </strong></h1>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <form method="POST" action="/{{$form['data']['action']}}">
                        {{csrf_field()}}
                        @if($form['data']['type']=='edit')
                            @method('PUT')
                        @endif

                        @foreach($form['fields'] as $name => $field)
                            <div class="form-group @if(isset($field['div-class'])) {{$field['div-class']}} @endif">
                                <label for="exampleInputEmail1">{{$field['label']}}</label>

                                @if($field['type'] == "select")

                                    <select name="{{$name}}" class="form-control @if(isset($field['class'])){{$field['class']}}@endif" id="@if(isset($field['id'])){{$field['id']}}@endif">
                                        @foreach($field['options'] as $value => $label)
                                            <option @if(old($name) == $value || $field['value'] == $value) selected @endif value="{{$value}}">{{$label}}</option>
                                        @endforeach
                                    </select>

                                @elseif($field['type'] == "multi")
                                    <input type="hidden" name="{{$name}}" />
                                    <select multiple class="form-control @if(isset($field['class'])){{$field['class']}}@endif" id="" name="{{$name}}[]">
                                        @foreach($field['options'] as $value => $label)
                                            <option @if(old($name) && in_array($value,old($name) ) )selected @elseif(is_array($field['value']) && in_array($value,$field['value'] ) ) selected @endif value="{{$value}}">{{$label}}</option>
                                        @endforeach
                                    </select>

                                @elseif($field['type'] == "boolean")

                                    <div class="form-check">
                                        <input type="checkbox" name="{{$name}}" class="form-check-input" id="" value="1" @if($field['value'] == 1) checked @elseif(old($name) == 1) checked @endif>
                                        {{--&nbsp;<label class="form-check-label" for="exampleCheck1">{{$field['label']}}</label>--}}
                                    </div>

                                @elseif($field['type'] == "autocomplete")


                                    <input type="text" name="{{$name}}" value="{{$field['value']}}" id="search-bar" class="form-control" aria-describedby="" placeholder="{{$field['placeholder']}}">

                                @else {{--for other fields like text, number, email etc. --}}

                                <input type="{{$field['type']}}" name="{{$name}}" value="@if(old($name)){{ old($name) }}@else{{$field['value']}}@endif" class="form-control @if(isset($field['text-class'])) {{$field['text-class']}} @endif" id="" aria-describedby="" placeholder="{{$field['placeholder']}}">

                                @endif

                                @if(isset($field['text']))
                                    <small id="emailHelp" class="form-text text-muted @if(isset($field['text-class'])) {{$field['text-class']}} @endif">{!! $field['text'] !!}</small>
                                @endif

                                @if ($errors->has($name))
                                    <span class="text-muted text-danger">
                                        <strong>{{ $errors->first($name) }}</strong>
                                    </span>
                                @endif

                            </div>
                        @endforeach
                        <button type="submit" name="submit" class="btn btn-primary"> {{$form['data']['submit']}}</button>
                    </form>
                    {{--<form method="POST" action="">
                    {{csrf_field()}}
                    <table class="table table-bordered">

                        --}}{{--@foreach($projects as $key => $project)--}}{{--
                    <div class="col-md-6">
                        --}}{{--<select name="projects" class="form-control">
                            @foreach($projects as $project)
                                <option  value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach--}}{{--
                        --}}{{--<label>projects</label>
                        <input type="text" name="" value=""><br>
                        <label>clients</label>
                        @foreach($clients as $client)
                        <input type="text" name="" value="{{$client->name}}"><br>

                        @endforeach--}}{{--

                        --}}{{--<select>
                        <label>priority</label>
                        <input type="text" name="" value=""><br>
                        <label>delivery date</label>
                        <input type="time" name="delivery_date" value=""><br>

                           <label> status</label>
                        <input type="text" name="" value="">

                        </select>--}}{{--
                        <div class="form-group">
                            <label for="project"></label>

                            <select class="form-control" name="project" id="">
                                <label>client</label>
                                @foreach($clients as $client)
                                    <option  value="{{$client->id}}">{{$client->name}}</option><
                                @endforeach
                            </select>
                            <div class="form-group">
                                <label for="priority"></label>
                                <textarea class="form-control" name="priority" id="" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="delivery date"></label>
                                <input type="date" name="" id="" class="form-control" placeholder=""
                                       aria-describedby="helpId">
                        <label>status</label>
                                <input type="status" name="" id="" class="form-control" placeholder="">

                            </div>
                        </div>
                    </div>

              --}}{{--@endforeach--}}{{--
            </table>
                    <button type="submit">Update</button>
                </form>--}}

            </div>
        </div>
    </div>
        <div class="col-sm-4">

            <div id="stocks-listing">
                @if(Request::is('stocks/create'))
                @if(isset($invoice_number))

                <h2>Last Added Stock</h2>
                <h5>Product name</h5>
                @foreach($stocks_data as $stock_data)
                    @php($item = $stock_data->item)
                <ul class="list-group">
                <li class="list-group-item active " style="cursor: pointer" data-toggle="collapse" data-target="#hidden-block-{{$stock_data->id}}">
                {{++$loop->index}}. {{$item->product_name}} {{$item->packing}} {{$item->potency}} : {{--{{$stock_data->total}}--}}  Quantity: {{$stock_data->quantity}} Available: {{$item->available}}
                </li>


                    <div id="hidden-block-{{$stock_data->id}}" class="collapse">
                        <div class="show-listing">
                        <h5>Hsn code</h5>
                        <li class="list-group-item">
                            {{$item->hsn_code}}
                        </li>
                        <h5>Mfg code</h5>
                        <li class="list-group-item">
                            {{$item->mfg_code}}
                        </li>
                        <h5>Gst</h5>
                        <li class="list-group-item">
                            {{$item->gst}}
                        </li>
                        <h5>Short name</h5>
                        <li class="list-group-item">
                            {{$item->short_name}}
                        </li>
                        <br>
                        Stock Amount
                        <li class="list-group-item active">
                            {{$stock_data->quantity}} * {{$stock_data->dealer_price}} = {{$stock_data->total}}
                        </li><br>
                    </div>
                    </div>
                </ul>
                    @endforeach

            </div>
            <div>
                <h2>Stock Total Amount</h2>
                <ul class="list-group">
                    <li class="list-group-item active">


                        {{$stock_data->stocks_total}}
                        Quantity: {{$stock_data->stocks_quantity}}

                        @endif
                    </li>
                </ul>
            </div>

        </div>
        @endif
    </div>



@endsection()

@section('scripts')
    <script>
    $('document').ready(function(){
    $('.no-expiry-link').click(function(e){
        e.preventDefault();
        //alert('123');
        $('.no_field').hide(function(){
            $('.no_expiry_field').prop('disabled',false);


        });
    });


    });
    </script>



@endsection