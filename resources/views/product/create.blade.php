@extends('layouts.app')

@section('content')

<div class="panel panel-default" style="margin-top: 50px;">

  <div class="panel-heading">
    <h3>Creating Product</h3></div>
  <div class="panel-body">
    <form action="{{ url('store')}}" method="POST" enctype="multipart/form-data">
      {{ csrf_field()}}

      <div class="form-group">
        <label for="image">Image</label>
        <input class="form-control" type="file"  name="icon" id="image">
      </div>

      <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="title" placeholder="title " id="title">
      </div>
      <div class="form-group">
        <label for="Description">Description</label>
        <input class="form-control" type="text" name="Description" placeholder="Description" id="Description">
      </div>
      <div class="form-group">
        <label for="Price">Price</label>
        <input class="form-control" type="text" name="Price" placeholder="Price" id="Price">
      </div>




      <input type="submit" name="submit" value="submit" ><br>
    </form>
  </div>
  <div class="panel-footer"></div>


</div>
  





  <div class="col-md-10">
                <div class="checkout-right">
                  <hr>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Image</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Price</th>
                           <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($data as $product)
                  
                        <tr>
                          <td>{{$product->id}} </td>
                          <td><img  style="width: 100px" src="{{ $product->imagePath}}"></td>
                        
                          <td>{{$product->title}}</td>
                          <td>{{$product->description}}</td>
                          <td>${{$product->price}}</td>
                          <td><a  href="{{url('product/edit',$product->id)}}">Edit</a>
                          <a href="{{url('product.destroy',$product->id)}}">Delet</a>
                    
                        </tr>
                      @endforeach
                     
                      </tbody>
                      
                    </table>
                  </div>
                
                  <div class="aa-payment-method">                    
                   
                      
                    <input type="submit" value="Place Order" class="aa-browse-btn">                
                  </div>
                </div>
              </div>



@endsection