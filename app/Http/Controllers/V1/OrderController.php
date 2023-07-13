<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Order;
use App\Services\OrderService;
use App\Jobs\EmailJob;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }
    
    public function orderProduct(Request $request) {

        $request->validate([
            'slug' => 'required',
            'type' => 'required|in:buy,rent',
            'rent_from' => 'required_if:type,rent|date',
            'rent_to' => 'required_if:type,rent|date'
        ]);

        $product = Product::where('slug', $request->slug)
                            ->where('status', 1)
                            ->first();
        
        if(!$product) return $this->getResponse(404, 'No product found!');

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->product_id = $product->id;
        $order->type = $request->type;
        $order->rent_from = $request->rent_from ? $request->rent_from : null;
        $order->rent_to = $request->rent_to ? $request->rent_to: null;

        $jobData = [
            'email' => Auth::user()->email,
            'title' => $product->title,
            'type' => $request->type,
            'purchase_price' => $product->purchase_price,
            'rent_price' => $product->rent_price,
            'rent_option' => $product->rent_option,
            'rent_from' => $request->rent_from ? $request->rent_from : null,
            'rent_to' => $request->rent_to ? $request->rent_to: null
        ];

        EmailJob::dispatch($jobData);

        if(!$order->save()) return $this->getResponse(500, 'Something went wrong');
        return $this->getResponse(201, "Product {$request->type} successfully.");
    }

    public function getOrderProducts(string $type) {

        if($type !== 'buy' && $type !== 'rent') return $this->getResponse(400, 'Invalid order type.');

        $orders = Order::with('product.productCategory.category')
                        ->where('type', $type)
                        ->where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->orderByDesc('created_at')
                        ->get();

        if($orders->isEmpty())
            return $this->getResponse(404, "No orders found!");
        return $this->getResponse(200, "Total {$orders->count()} products found.", $this->orderService->getAllOrders($orders));
    }
}
