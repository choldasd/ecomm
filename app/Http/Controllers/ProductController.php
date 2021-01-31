<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use DataTables;
use App\Product;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_name = $request->product_name;
        if($request->ajax()){
            
            $productList = Product::select('*');
            if(isset($product_name) && !empty($product_name)){
                $productList->where('product_name','LIKE','%'.$product_name.'%');
            }
            //$productList->orderby('id','DESC');
            
            return Datatables::of($productList)
                /* ->editColumn('status', function($row) {
                    if($row->status){
                        return 'Disable';
                    }else{
                        return 'Active';
                    }
                }) */
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $vurl = route('products.show',$row->id);
                        $eurl = route('products.edit',$row->id);
                        $durl = route('products.destroy',$row->id);
                        $btn = '<a href="javascript:void(0)" class="show btn btn-info btn-sm" action="'.$vurl.'" >View</a>&nbsp;';
                        $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" action="'.$eurl.'">Edit</a>&nbsp;';
                        $btn = $btn.'<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" action="'.$durl.'">Delete</a>&nbsp;';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $message = ['status'=>false, 'message'=>'Oops! Something went wrong.','data' => ''];
        $validated = $request->validated();

        DB::beginTransaction();
        $productDetail = '';
        if(isset($validated) && !empty($validated) && count($validated)){
            $productDetail =  Product::create([
                'product_name' => $validated['product_name'],
                'product_price' => $validated['product_price'],
                'product_desccription' => $validated['product_desccription']
            ]);
            if(!empty($productDetail)){

                $mphoto_name = "";
                $product_id = $productDetail->id;
                if(isset($validated['product_image']) && count($validated['product_image'])>0) {
                    $pro_images = "";
                    foreach($validated['product_image'] as $mkey => $image){

                        if(isset($image)){
                            if ($image->isValid()) {
                                $inm = $image->getClientOriginalName();
                                $mphoto_extension = $image->extension();
                                $mphoto_name = date("ymd")."_".mt_rand(01,99)."_".$product_id."_".$inm;
                                $image->storeAs('/public/product/'.$product_id, $mphoto_name);
                                $url = Storage::url($image);
                                $pro_images .= $mphoto_name.',';
                            }
                        }
                    }
                    $productDetail->product_image = $pro_images;
                    $isupdated = $productDetail->save();
                    DB::commit();
                    $message = ['status'=>true, 'message'=>'Product created successfully','data' => $productDetail];
                }else{
                    DB::rollback();
                    $message = ['status'=>false, 'message'=>'Please select product images to upload.','data' => ''];
                }
            }else{
                DB::rollback();
                $message = ['status'=>false, 'message'=>'Unable to create product.','data' => ''];
            }
        }else{
            DB::rollback();
            $message = ['status'=>false, 'message'=>'Something went wrong! Please make sure you entered correct field.','data' => ''];
        }
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productDetail = Product::where('id',$id)->first();
        $productData =  $productDetail->toArray();
        $proimg = array();
        if(!empty($productData['product_image'])){
            $pimg = explode(",",rtrim($productData['product_image'],","));
            foreach($pimg as $value){
                $imgurl = asset("storage/Product/".$id."/".$value);
                $proimg[] = $imgurl;
            }
        }
        $productData['images'] = $proimg;
        //print_r($productData['product_image']);
        if(!empty($productDetail)){
            return response()->json(['status'=>true, 'message'=>'Product retrieved successfully','data' => $productData]);
        }else{
            return response()->json(['status'=>false, 'message'=>'Unable to retrieve product.','data' => '']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productDetail = Product::where('id',$id)->first();
        $productData =  $productDetail->toArray();
        $proimg = $proact = array();
        if(!empty($productData['product_image'])){
            $pimg = explode(",",rtrim($productData['product_image'],","));
            //dd($pimg);
            foreach($pimg as $value){
                $imgurl = asset("storage/Product/".$id."/".$value);
                $proimg[] = $imgurl;
                $proact[] = route("products.imagedelete",$id);
            }
        }
        $productData['images'] = $proimg;
        $productData['imgact'] = $proact;
        //print_r($productData['product_image']);
        if(!empty($productDetail)){
            return response()->json(['status'=>true, 'message'=>'Product retrieved successfully','data' => $productData]);
        }else{
            return response()->json(['status'=>false, 'message'=>'Unable to retrieve product.','data' => '']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, $id)
    {
        //validation
        $message = ['status'=>false, 'message'=>'Oops! Something went wrong.','data' => ''];
        $validated = $request->validated();
        $productDetail = '';
        
        if(isset($validated) && !empty($validated) && count($validated)){
            $product = Product::findOrFail($id);
            $product->product_name = $validated['product_name'];
            $product->product_price =  $validated['product_price'];
            $product->product_desccription =  $validated['product_desccription'];            
            $is_update = $product->save();

            if(!empty($is_update)){
                if(isset($validated['product_image']) && count($validated['product_image'])>0) {
                    $pro_images = "";
                    foreach($validated['product_image'] as $mkey => $image){

                        if(isset($image)){
                            if ($image->isValid()) {
                                $inm = $image->getClientOriginalName();
                                $mphoto_extension = $image->extension();
                                $mphoto_name = date("ymd")."_".mt_rand(01,99)."_".$id."_".$inm;
                                $image->storeAs('/public/product/'.$id, $mphoto_name);
                                $url = Storage::url($image);
                                $pro_images .= $mphoto_name.',';
                            }
                        }
                    }
                    $pre_imges = $product->product_image;
                    if($pro_images != ""){
                        $pre_imges .= ','.$pro_images;
                    }
                    $product->product_image = $pre_imges;
                    $isupdated = $product->save();
                }
                $message = ['status'=>true, 'message'=>'Product updated successfully','data' => $product];
            }else{
                $message = ['status'=>false, 'message'=>'Unable to update product.','data' => ''];
            }
        }
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ['status'=>false, 'message'=>'Oops! Something went wrong.','data' => ''];
        if(!empty($id) && $id > 0){
            $isDeleted = Product::find($id)->delete($id);
            if(!empty($isDeleted) && $isDeleted === true){    
                $this->deleteDir(getcwd()."/storage/product/".$id);                    
                $message = ['status'=>true, 'message'=>'Product deleted successfully','data' => $isDeleted];
            }else{
                $message = ['status'=>false, 'message'=>'Unable to delete product.','data' => ''];
            }                      
        }
        return response()->json($message);        
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function imagedelete(Request $request,$id){
        $message = ['status'=>false, 'message'=>'Oops! Something went wrong.','data' => ''];
        if(!empty($id) && $id > 0){
            $productDetail = Product::where('id',$id)->first();
            $productData =  $productDetail->toArray();
            
            if(!empty($productData['product_image'])){
                $imgnm = $request->altstr;
                $pimg = explode(",",rtrim($productData['product_image'],","));
                $ikey = array_search($imgnm,$pimg);
                unset($pimg[$ikey]);
                $proimgstr = implode(",",$pimg);
                $productDetail->product_image = $proimgstr;
                $isupdate = $productDetail->save();

                if($isupdate){
                    $path = getcwd()."/storage/product/".$id."/".$imgnm;
                    $isunlink = unlink($path);
                    if($isunlink){
                        $message = ['status'=>true, 'message'=>'Product image deleted successfully','data' => $isupdate];
                    }else{
                        $message = ['status'=>false, 'message'=>'Unable to delete product image','data' =>''];
                    }                    
                }else{
                    $message = ['status'=>false, 'message'=>'Unable to delete product image.','data' => ''];
                }
            }
        }
        return response()->json($message);
    }
}
