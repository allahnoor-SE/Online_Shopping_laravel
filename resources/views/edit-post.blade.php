<form method="product" action="{{url('product/update/'.$product->id)}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="text" value="{{$product->title}}" name="name">
    <input type="text" value="{{$product->description}}" name="name">
    <input type="submit">
</form>