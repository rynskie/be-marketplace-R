<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::join("product_types", "products.product_type_id", "=", "product_types.id")
        ->select("products.*", "product_types.type_name")
        ->get();
        return response([
            "message" => "product type list",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'products_name' => 'required|unique:products,products_name',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);
        $imagename = time().'.'.$request->img_url->extention(); 
        $request->img_url->move(public_path('image'), $imagename); 

        Product::create([
            'product_type_id' => $request->product_type_id,
            'products_name' => $request->products_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_url' => url('/images/'.$imagename), 
            'img_name' =>$imagename
        ]);

        return response(["message" => "Product name created succesfully"],201); 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id); 

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found', 
                'data' => [],
            ], 404); 
        }

        return response ([
            'message' => 'Product Type', 
            'data' => $data, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|unique:product_types,type_name',
            'product_types_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'img_url' => 'required'
        ]);

        $data = Product::find($id);

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found', 
                'data' => [],
            ], 404); 
        }

        $imagename = time().'.'.$request->img_url->extention(); 
        $request->img_url->move(public_path('image'), $imagename);  

        $data->type_name = $request->type_name;
        $data->product_type_id = $request->prodcut_type_id;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->img_url = $request->img_url;
        $data->img_name = $request->$imagename;
        $data->save();



        return response(['message => "Product Type update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id); 

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found', 
                'data' => [],
            ], 404); 
        }

        $data->delete();

        return response ([
            'message' => 'Product type list', 
            'data' => $data, 
        ]);
    }
}
