<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueryProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(QueryProductRequest $request)
    {
        try {
            $page = $request->validated('page') ? $request->validated('page') : 1;
            $limit = $request->validated('limit') ? $request->validated('limit') : 5;
            $sortBy = $request->validated('sort_by') ? $request->validated('sort_by') : 'product_name';
            $direction = $request->validated('direction') ? $request->validated('direction') : 'asc';
            $productName = $request->validated('product_name');
            $categoryId = $request->validated('category_id');
            $supplierId = $request->validated('supplier_id');
            $minPrice = $request->validated('min_price');
            $maxPrice = $request->validated('max_price');

            $query = Product::query();

            if (!empty($productName)) {
                $query->whereAny([
                    'product_name',
                ], 'like', $productName . '%');
            }

            if (!empty($categoryId)) {
                $query->where('category_id', $categoryId);
            }

            if (!empty($supplierId)) {
                $query->where('supplier_id', $supplierId);
            }

            if ($minPrice && $maxPrice) {

                $query = Product::whereBetween('unit_price', [$minPrice, $maxPrice]);
            }

            $data = $query->orderBy($sortBy, $direction)
                ->paginate($limit, ['*'], 'page', $page);

            return new ProductCollection($data);
        } catch (\Throwable $th) {
            Log::error('error get data product', [
                'message' => $th->getMessage(),
                'get_file' => $th->getFile(),
                'get_line' => $th->getLine(),
                'trace_string' => $th->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => 'Server Error'
            ], 500);
        }
    }
}
