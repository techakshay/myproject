<a href="javascript://"
   onclick="event.preventDefault();
           document.getElementById('delete-{{$stock_data->id}}').submit();">
    Delete Stock
</a>

<form id="delete-{{$stock_data->id}}" action="{{ route('stocks.destroy', ['stock' => $stock_data]) }}" method="POST" style="display: none;">
    {!! method_field('delete') !!}
    {{ csrf_field() }}
</form>