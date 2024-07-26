<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    //
    public function ListProduct()
    {
       $listProduct = $this->productService->getListProducts();
       $category = $this->productService->getCategorys();
        return view('welcome', [
            'listProduct' => $listProduct,
            'category' => $category
        ]);
    }

    public function StoreProduct(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
            'images' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $this->productService->storeProduct($validatedData);
        return redirect()->back()->with('success', 'Bạn đã thêm sản phẩm thành công');
    }

    public function UpdateProduct(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:product,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
            'images' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
       
        $this->productService->UpdateProduct($validatedData);
        return redirect()->back()->with('success', 'Bạn đã sửa sản phẩm thành công');
    }

    public function DestroyProduct($productId)
    {
        $this->productService->DestroyProduct($productId);
        return redirect()->back()->with('success', 'Bạn đã xóa sản phẩm thành công');
    }

    public function SearchProduct(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'nullable|string|max:255',
        ]);
        $productName = $validatedData['product_name'] ?? null;
        $listProduct = $this->productService->SearchProduct($productName);
        $category = $this->productService->getCategorys();
        return view('welcome', [
            'listProduct' => $listProduct,
            'category' => $category,
            'productName' => $productName,
        ]);
    }

    public function StoreCkeditorImages(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $result = $this->productService->storeImages($file);
            return response()->json($result);
        }
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'File upload failed.']]);
    }
}
