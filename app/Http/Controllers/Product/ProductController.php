<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Services\Product\ProductService;

class ProductController extends BaseController
{
    public function __construct($service = null) {
        $this->service = (new ProductService())
        ->setModel(Product::class);
      }
}
