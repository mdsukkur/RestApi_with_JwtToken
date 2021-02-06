<?php

namespace App\Repositories\Product;

use App\Helpers\ImageHelper;
use App\Http\Requests\Product\ProductRequest;
use App\Interfaces\Product\ProductInterface;
use App\Models\Product\ProductModel;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    use ResponseAPI;

    public function getAllProducts()
    {
        try {
            $products = ProductModel::paginate(20);

            return $this->success($products);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductById($id)
    {
        try {
            $product = ProductModel::find($id);

            if (!$product) return $this->error("Product not found with ID $id", 404);

            return $this->success($product);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function storeProduct(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = new ProductModel;

            $product->title = $request->title;

            $product->description = $request->description;

            $product->price = $request->price;

            $product->image = ImageHelper::uploadImage($request, 'image', 'product');

            $product->save();

            DB::commit();
            return $this->success($product, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateProduct(ProductRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::find($id);

            if (!$product) return $this->error("Product not found with ID $id", 404);

            $product->title = $request->title;

            $product->description = $request->description;

            $product->price = $request->price;

            $product->image = $request->has('image') ? ImageHelper::uploadImage($request, 'image', 'product', true, $product->image) : $product->image;

            $product->save();

            DB::commit();
            return $this->success($product);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function destroyProduct($id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::find($id);

            if (!$product) return $this->error("Product not found with ID $id", 404);

            ImageHelper::deleteImage('product', $product->image);

            $product->delete();

            DB::commit();
            return $this->success($product);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
