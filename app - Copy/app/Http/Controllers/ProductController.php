<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ValueError;

class ProductController extends Controller
{
    public function details_product(Request $request,$product_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('brand_id', 'desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 
        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->get();

        foreach($details_product as $key =>$value){
            $category_id = $value->category_id;
            $product_slug = $value->product_slug;
                //seo
                meta_desc = $value->product_desc;
                meta_keywords = $value->product_slug;
                meta_title = $value->product_name;
                url_canonical = $request -> url();
                //--seo
        } 

        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)
        ->whereNotIn('tbl_product.product_slug',[$product_slug])->get();

        $manager_product = view('pages.sanpham.show_details')
        ->with('details_product',$details_product)->with('category',$cate_product)
        ->with('brand',$brand_product)->with('relate',$related_product);

            //return view('admin_layout')->with('admin.edit_product',$manager_product);
            return view('layout')->with('pages.sanpham.show_details',$manager_product)
            ->with('category', $cate_product)->with('brand', $brand_product)
            ->with('relate', $related_product);\


            
    }

}