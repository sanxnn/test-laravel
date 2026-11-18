<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Product $product
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('products'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'product.created';
    }
}
