<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Gtin;
use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function list()
    {
        return auth()->user()->orders()->get();
    }

    public function store(array $pedido)
    {
        $totalOrder = 0;

        $order = auth()->user()->orders()->create([
            'total' => 0,
            'status' => 'realizado',
            'bgcolor' => 'bg-blue-500'
        ]);

        foreach ($pedido as $item) {
            $productGtin = Gtin::find($item['id']);
            $productGtin['quantity'] = 1;
            $totalOrder += $productGtin['price'];

            $order->gtins()->attach($productGtin);
        }

        $order['total'] = $totalOrder;
        $order->save();

        return $order;
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->user()->id) {
            return null;
        }

        return auth()->user()->orders()
            ->with(['gtins' => fn($gtins) => $gtins
                ->with(['images' => fn($img) => $img
                    ->select('id', 'url', 'cover', 'gtin_id')
                    ->where('cover', 1)
                    ->limit(1), 'product' => fn($prod) => $prod
                    ->select('id', 'name')])])
            ->where('id', $order->id)
            ->select('id', 'user_id', 'created_at', 'total', 'status', 'bgcolor')
            ->first();
    }
}
