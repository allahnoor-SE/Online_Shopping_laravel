@extends('layouts.app')

@section('content')


  

<form action="{{ url('product/store')}}" method="POST" enctype="multipart/form-data">
{{ csrf_field()}}
  <input type="file"  name="icon"><br>
  <input type="text" name="title">
   <input type="text" name="description">
    <input type="text" name="price">

  <select name="category_id">
            <option>Select Category</option>

            <option value="{{1}}" id="classes" >Men</option>
            <option value="{{2}}" id="classes" >Women</option>
            <option value="{{3}}" id="classes" >Kids</option>
           <!--  <option value="{{4}}" id="classes" >Drass</option> -->

  </select>

    <select name="type_id">
            <option>Select Type</option>

            <option value="{{1}}" id="classes" >Formal</option>
            <option value="{{2}}" id="classes" >Sport</option>
            <option value="{{3}}" id="classes" >Shirt</option>
            <option value="{{4}}" id="classes" >T_Shirt</option>
            <option value="{{5}}" id="classes" >Jeans</option>
            <option value="{{6}}" id="classes" >Suit</option>
            <option value="{{7}}" id="classes" >Shose</option>

  </select>
  <input type="submit" name="submit" value="submit" >
</form>



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
                          <td><img  style="width: 100px" src="../{{ $product->imagePath}}"></td>
                        
                          <td>{{$product->title}}</td>
                          <td>{{$product->description}}</td>
                          <td>${{$product->price}}</td>
                          <td><a  href="{{url('product/edit',$product->id)}}">Edit</a>
                          <a href="{{url('product/destroy',$product->id)}}">Delete</a>
                    
                        </tr>
                      @endforeach
                     
                      </tbody>
                      
                    </table>
                  </div>
                

                </div>
              </div>



@endsection