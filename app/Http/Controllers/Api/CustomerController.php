<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::join('orders', 'customers.customer_id', '=', 'orders.customer_id')
                ->groupBy('customers.customer_id')
                ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')->groupBy('order_details.unit_price')
                ->select('customers.company_name', 'customers.country', 'order_details.unit_price',  DB::raw('SUM(order_details.unit_price) as total_purchase'))
                ->orderBy('total_purchase', 'DESC')
                ->limit(10)
                ->get();

            return CustomerResource::collection($customers);
        } catch (\Throwable $th) {
            Log::error('error get data Customer', [
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
