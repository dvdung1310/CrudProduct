<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function getListProducts()
    {
        $listProduct = ProductModel::join('category', 'category.id', '=', 'product.category_id')
            ->select('product.*', 'category.*', 'product.name as product_name', 'product.id as product_id', 'category.name as category_name')
            ->orderby('product.created_at', 'desc')
            ->paginate(5);

        return $listProduct;
    }

    public function getCategorys()
    {
        $category = CategoryModel::all();
        return $category;
    }


    public function StoreProduct(array  $data)
    {
        $product = new ProductModel();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];

        if (isset($data['images'])) {
            $files = $data['images'];
            $filename = time() . '_' . $files->getClientOriginalName();
            $path_upload = 'uploads/images_product/';
            $files->move($path_upload, $filename);
            $path_imgs = $path_upload . $filename;
            $product->images = $path_imgs;
        }
        $product->save();
        return $product;
    }

    public function UpdateProduct(array $data)
    {
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
            $file_input = $data['images'];
            $filename = time() . '_' . $file_input->getClientOriginalName();
            $path_upload = 'uploads/images_product/';
            $file_input->move($path_upload, $filename);
            $path_img = $path_upload . $filename;
            $product->images = $path_img;
        }
        $product->save();
        return $product;
    }

    public function DestroyProduct(int $productId)
    {
        $product = ProductModel::where('id', $productId)->first();
        $productImage = $product->images;
        $absolutePathImg = public_path($productImage);

        if (file_exists($absolutePathImg) && $productImage != null) {
            unlink($absolutePathImg);
        }
        $product->delete();
        return $product;
    }

    public function SearchProduct(?String $productName)
    {
        $listProduct = ProductModel::join('category', 'category.id', '=', 'product.category_id')
            ->where('product.name', 'like', '%' . $productName . '%')
            ->select('product.*', 'category.*', 'product.name as product_name', 'product.id as product_id', 'category.name as category_name')
            ->orderby('product.created_at', 'desc')
            ->paginate(5);
        return $listProduct;
    }

    public function storeImages(UploadedFile $file)
    {
        $newName = time() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/images_ckeditor';
        $file->move(public_path($path), $newName);
        $url = asset($path . '/' . $newName);
        return [
            'filename' => $newName,
            'url' => $url,
            'uploaded' => 1
        ];
    }
}
