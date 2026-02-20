<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function AddProduct()
    {
        $order = DB::table('order')->where('status', 'pending')->count();
        $DbCate = DB::table('category')->get();
        $DbAttribute = DB::table('attribute')->get();
        return view('backend.add-product',['cate'=>$DbCate,'attri'=>$DbAttribute ,  'orderRow'=>$order]);
    }
    public function addProductSubmit(Request $request){
        $name = $request->name;
        $qty = $request->qty;
        $regular_price = $request->regular_price;
        $sale_price = $request->sale_price;
        $size =implode(',',$request->size); 
        $color = implode(',',$request->color);
        
        $category = $request->category;
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
        }else{
            $thumbnail = "";
        }
        $description = $request->description;
        if($name){
            
                $product = DB::table('product')->insert([
                    'name'=> $name,
                    'slug' => $this->slug($name),
                    'quantity' => $qty,
                    'regular_price' => $regular_price,
                    'sale_price'=> $sale_price,
                    'attribute_size' => $size,
                    'attribute_color' =>$color,
                    'category'  => $category,
                    'thumbnail' => $thumbnail,
                    'viewer'    => 0,
                    'author'    => Auth::user()->id,
                    'description'   => $description,
                    'created_at'    => date('Y-m-d H:i:s',strtotime('+ 7 hours')),
                    'updated_at'    => date('Y-m-d H:i:s',strtotime('+ 7 hours')),
                ]); 
                if($product){
                    $lastId = $this->getLastPostId('product');
                    $this->logActivity('product',$name,$lastId,'insert');
                    return redirect('/admin/list-product')->with('message','Insert Product Successful');
                }
                else{
                    return redirect('/admin/add-product')->with('message','Insert Product Fail');
                }            
        }   
    }

    public function updateProductSubmit(Request $request){
        $DBProduct = DB::table('product')->where('id',$request->id)->first();
        $name = $request->name;
        $qty = $request->qty;
        $regular_price = $request->regular_price;
        $sale_price = $request->sale_price;
        $size =implode(',',$request->size); 
        $color = implode(',',$request->color);
        
        $category = $request->category;
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
        }else{
            $thumbnail = $DBProduct->thumbnail;
        }
        $description = $request->description;
        if($name){
            
                $product = DB::table('product')->where('id',$request->id)->update([
                    'name'=> $name,
                    'slug' => $this->slug($name),
                    'quantity' => $qty,
                    'regular_price' => $regular_price,
                    'sale_price'=> $sale_price,
                    'attribute_size' => $size,
                    'attribute_color' =>$color,
                    'category'  => $category,
                    'thumbnail' => $thumbnail,
                    'viewer'    => 0,
                    'author'    => Auth::user()->id,
                    'description'   => $description,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]); 
                if($product){
                    $lastId = $this->getLastPostId('product');
                    $this->logActivity('product',$name,$lastId,'Update');
                    return redirect('/admin/list-product')->with('message','Update Product Successful');
                }
                else{
                    return redirect('/admin/add-product')->with('message','Update Product Fail');
                }            
        }
    }

    public function listProduct(Request $request){
        $order = DB::table('order')->where('status', 'pending')->count();
        $limitPage = 2;
        $currentPage = $request->input('page', 1);
      
        $offset = ($currentPage - 1) * $limitPage;

        $products = DB::table('product')
        ->leftJoin('users','users.id','product.author')
        ->leftJoin('category','category.id','product.category')
        ->select('category.name as cateName','users.name as authorname','product.*')
        ->orderByDesc('product.id')
        ->limit($limitPage)
        ->offset($offset)
        ->get();

        $productsCount = DB::table('product')->count();
        $totalPage = ceil($productsCount / $limitPage);


        return view('backend.list-product',['product'=>$products , 'totalPage'=>$totalPage , 'currentPage'=>$currentPage , 'orderRow'=>$order ]);
    }

    public function updateProduct($id){
        $order = DB::table('order')->where('status', 'pending')->count();
        $DbProduct = DB::table('product')
        ->find($id);

        $productSize = explode(',',$DbProduct->attribute_size);
        $productColor = explode(',',$DbProduct->attribute_color);

        $DbCate = DB::table('category')->get();
        $attributeSize = DB::table('attribute')->where('type','size')->get();
        $attributeColor = DB::table('attribute')->where('type','color')->get();

        
        return view('backend.update-product',['product'=>$DbProduct , 'cate'=>$DbCate , 'size'=>$attributeSize 
        , 'color'=>$attributeColor ,'productSize'=>$productSize , 'productColor'=>$productColor , 'orderRow'=>$order ]);
    }

    public function removeProductSubmit(Request $request){
        $order = DB::table('order')->where('status', 'pending')->count();
        $id = $request->remove_id;
        $Delete = DB::table('product')->where('id',$id)->delete();
        if($Delete){
            return redirect('/admin/list-product')->with('message','Delete Successful');
        }else{
            return redirect('/admin/list-product')->with('message','Delete Fail');
        }
    }

    public function detailProduct(){
        $order = DB::table('order')->where('status', 'pending')->count();
        $products = DB::table('product')
        ->leftJoin('users','users.id','product.author')
        ->leftJoin('category','category.id','product.category')
        ->select('category.name as cateName','users.name as authorname','product.*')
        ->get();
        return view('backend.detail-product',['product'=>$products , 'orderRow'=>$order ]);
    }
}
