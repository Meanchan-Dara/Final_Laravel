<?php

namespace App\Http\Controllers;

use App\Models\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderItemController extends Controller
{
    /**
     * Display a list of all Order Items
     */
    public function index()
    {
        try {
            $items = Order_item::with(['product', 'order.user'])
                ->latest()
                ->get();

            return response()->json($items, 200);
        } catch (\Exception $e) {
            Log::error('OrderItem index error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to retrieve order items'
            ], 500);
        }
    }

    /**
     * Create a new Order Item
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'order_id'    => 'required|exists:orders,id',
                'product_id'  => 'required|exists:products,id',
                'quantity'    => 'required|integer|min:1',
                'unit_price'  => 'required|numeric|min:0',
            ]);

            $orderItem = Order_item::create($fields);

            return response()->json([
                'message' => 'Order item created successfully',
                'data'    => $orderItem
            ], 201);
        } catch (\Exception $e) {
            Log::error('OrderItem store error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create order item'
            ], 500);
        }
    }

    /**
     * Display a single Order Item
     */
    public function show($id)
    {
        try {
            $orderItem = Order_item::with(['product', 'order'])
                ->find($id);

            if (!$orderItem) {
                return response()->json([
                    'message' => 'Order item not found'
                ], 404);
            }

            return response()->json($orderItem, 200);
        } catch (\Exception $e) {
            Log::error('OrderItem show error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to retrieve order item'
            ], 500);
        }
    }

    /**
     * Update an Order Item
     */
    public function update(Request $request, $id)
    {
        try {
            $orderItem = Order_item::find($id);

            if (!$orderItem) {
                return response()->json([
                    'message' => 'Order item not found for update'
                ], 404);
            }

            $fields = $request->validate([
                'quantity'   => 'integer|min:1',
                'unit_price' => 'numeric|min:0',
            ]);

            $orderItem->update($fields);

            return response()->json([
                'message' => 'Order item updated successfully',
                'data'    => $orderItem
            ], 200);
        } catch (\Exception $e) {
            Log::error('OrderItem update error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update order item'
            ], 500);
        }
    }

    /**
     * Delete an Order Item
     */
    public function destroy($id)
    {
        try {
            $orderItem = Order_item::find($id);

            if (!$orderItem) {
                return response()->json([
                    'message' => 'Order item not found for deletion'
                ], 404);
            }

            $orderItem->delete();

            return response()->json([
                'message' => 'Order item deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('OrderItem delete error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete order item'
            ], 500);
        }
    }
}
