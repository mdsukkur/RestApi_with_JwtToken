<?php

namespace App\Interfaces\Product;

use App\Http\Requests\Product\ProductRequest;

interface ProductInterface
{
    public function getAllProducts();

    public function getProductById($id);

    public function storeProduct(ProductRequest $request);

    public function updateProduct(ProductRequest $request, $id = null);

    public function destroyProduct($id);
}
