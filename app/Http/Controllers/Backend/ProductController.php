<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function ListProduct()
    {
        $listProduct = ProductModel::join('category', 'category.id', '=', 'product.category_id')
            ->select('product.*', 'category.*', 'product.name as product_name', 'product.id as product_id', 'category.name as category_name')
            ->orderby('product.created_at','desc')
            ->paginate(5);
        $category = CategoryModel::all();
        return view('welcome', [
            'listProduct' => $listProduct,
            'category' => $category
        ]);
    }

    public function StoreProduct(Request $request)
    {
        $data = $request->all();
        $product = new ProductModel();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];
        $files = $request->file('images');
        $filename = time() . '_' . $files->getClientOriginalName();
        $path_upload = 'uploads/images_product/';
        $files->move($path_upload, $filename);
        $path_imgs = $path_upload . $filename;
        $product->images =  $path_imgs;
        $product->save();
        return redirect()->back()->with('success', 'Bạn đã thêm sản phẩm thành công');
    }

    public function UpdateProduct(Request $request)
    {
        $data = $request->all();
        $product = ProductModel::where('id', $data['product_id'])->first();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];

        if (isset($data['images'])) {
            // xóa file cũ
            $productImage = $product->images;
            $absolutePathImg = public_path($productImage);

            if (file_exists($absolutePathImg) && $productImage != null) {
                unlink($absolutePathImg);
            }
            // thêm file mới
            if ($request->hasFile('images')) {
                $file_input = $request->file('images');
                $filename = time() . '_' .  $file_input->getClientOriginalName();
                $path_upload = 'uploads/images_product/';
                $request->file('images')->move($path_upload, $filename);
                $path_img = $path_upload . $filename;
                $product->images = $path_img;
            }
        }

        $product->save();
        return redirect()->back()->with('success', 'Bạn đã sửa sản phẩm thành công');
    }

    public function DestroyProduct($productId)
    {
        $product = ProductModel::where('id', $productId)->first();
        $productImage = $product->images;
        $absolutePathImg = public_path($productImage);

        if (file_exists($absolutePathImg) && $productImage != null) {
            unlink($absolutePathImg);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Bạn đã xóa sản phẩm thành công');
    }

    public function SearchProduct(Request $request)
    {
        $productName = $request->input('product_name');
        $listProduct = ProductModel::join('category', 'category.id', '=', 'product.category_id')
            ->where('product.name', 'like', '%' . $productName . '%')
            ->select('product.*', 'category.*', 'product.name as product_name', 'product.id as product_id', 'category.name as category_name')
            ->paginate(4);
        $category = CategoryModel::all();
        return view('welcome', [
            'listProduct' => $listProduct,
            'category' => $category
        ]);
    }

    public function StoreCkeditorImages(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $newName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/images_ckeditor'), $newName);
            $url = asset('/uploads/images_ckeditor/' . $newName);
            return response()->json(['filename' => $newName, 'uploaded' => 1, 'url' => $url]);
        }
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'File upload failed.']]);
    }
}
