<?php

namespace App\Http\Controllers;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\WishList;
use App\Type;
use App\Http\Requests;
use Session;
use Image;
use Illuminate\Support\Facades\Input;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
    {
       $products = Product::all();
       return view('shop.index')->withProducts($products);
    }


public function getAddToCart(Request $request, $id){

        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart',$cart);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function getcart()
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

   
public function getcheckout(){

          if (!Session::has('cart')) {
            return view('shop.shopping-cart');
         }
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    $total = $cart->totalPrice;
    return view('shop.checkout', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);

        }


public function postcheckout(Request $request){
               if (!Session::has('cart')) {
            return view('shop.shoppingCart');
         }
         $oldCart = Session::get('cart');
         $cart = new Cart($oldCart);
         Stripe::setApiKey('sk_test_c2KkjUaxDA1VD4Fnqcbz3DL1');
         try {
            Charge::create(array(
               "amount" => $cart->totalPrice * 100,
               "currency" => "usd",
               "source" =>  $request->input('stripeToken'),
               "description" => "test Charge"

                ));
             
         } catch (Exception $e) {
            return redirect()->route('checkout')->with('error', $e->getMessage());
             
         }
         Session::forget('cart');
         return redirect()->route('product.index')->with('success','Successfully purchased products');
        }

      
public function getAddToWishlist(Request $request, $id){
        $product = Product::find($id);
        $oldwish = Session::has('wish') ? Session::get('wish') : null;
        $wish = new WishList($oldwish);
        $wish->add($product, $product->id);

        $request->session()->put('wish',$wish);
        return redirect()->back();

}

public function getwishlist(){
       $product = new Product;
        $data = $product->get();
         if (!Session::has('wish')) {
            return view('shop.wish_list');
        }
        $oldwish = Session::get('wish');
        $wish = new WishList($oldwish);
        return view('shop.wish_list', ['products' => $wish->items, 'totalPrice' => $wish->totalPrice])->with('data',  $data);

}

    public function create(){

        if (Auth::user()->role != 1) {
            return response()->view('errors.503');
        }
        $products = new Product;
        $data = $products->get();
        return view('Product.create')->with('data',$data);

    }
    public function edit($id)
    {
    $product = Product::find($id);
    return view('product.edit')->with('product',$product);
    }

    public function update(Request $request, $id){
        $title = $request->get('title');
        $desc = $request->get('description');
        $price = $request->get('price');

        $product = Product::find($id);


        $image = $request->file('imagePath');
        $filename  = time() . '.' . $image->getClientOriginalExtension();
        $request->file('imagePath')->move(
            base_path() . '/public/img/', $filename
        );

        $product->title = $title;
        $product->description = $desc;
        $product->price = $price;
        $product->imagePath = $filename;
        $product->update();

        return redirect('product/create');

    }

    public function delete($id){
        $product = Product::find($id);
        $product->delete();

        return redirect('product/create');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {

             if (Auth::user()->role != 1) {
        return response()->view('errors.503');
    }
       
        $product = new Product; 
        $product->title = $request->title;
         $product->description = $request->description;
         $product->price = $request->price; 
         $product->category_id = $request->category_id;
         $product->type_id = $request->type_id;   
        if($request->hasFile('icon')){
             $image = $request->file('icon');
             $filename  = time() . '.' . $image->getClientOriginalExtension();
             $path = public_path('img/' . $filename);
             $imgpath = 'img/product'. $filename;
             Image::make($image)->resize(200, 200)->save($imgpath);
             $product->imagePath = $imgpath;
           }
             $product->save();
             return redirect()->back();
    }
 

    public function show($id){
        $product = Product::find($id);
        return view('product.show')->withProduct($product);
 }



      public function destroy($id)
    {
        $product = Product::find($id);
        $path = asset('img/').'/'.$product->image;
        Storage::delete($path);
        $product->delete();
        
        session()->flash('delete_message', 'flash_message');
        return redirect()->back();
    }

    public function men(){
        $products = Product::where('category_id', 1);
        return view('shop.index',compact('products'));
    }


}
