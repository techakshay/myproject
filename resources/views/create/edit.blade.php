@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {{--<div class="panel-heading">Login</div>--}}
                    <div class="panel-body">
                        <form method="post" action="/edit_bills">

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="">Bill Id</label>
                                <input type="text" class="form-control" name="bill_id" aria-describedby="helpId" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Item Id</label>
                                <input type="text" class="form-control" name="item_id" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Stock Id</label>
                                <input type="text" class="form-control" name="stock_id" stock_id="" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="text" class="form-control" name="quantity" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Rate</label>
                                <input type="text" class="form-control" name="rate" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Discount</label>
                                <input type="text" class="form-control" name="discount" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">GST</label>
                                <input type="text" class="form-control" name="gst" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="text" class="form-control" name="amount" aria-describedby="helpId">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Register">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection