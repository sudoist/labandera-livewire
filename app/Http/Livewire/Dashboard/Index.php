<?php

namespace App\Http\Livewire\Dashboard;

use App\Helpers\API\GuzzleHelper;
use Illuminate\Support\Arr;
use Livewire\Component;

class Index extends Component
{
    // Stats
    public $queued;
    public $washing;
    public $ready;
    public $complete;

    private $orders;

    public function mount(GuzzleHelper $guzzleHelper)
    {
        $requests = [
            'orders' => '/api/orders',
        ];

        $responses = $guzzleHelper->get($requests);

        $this->orders = json_decode($responses['orders']->getBody()->getContents());

        // Get stats
        $this->queued = $this->getStats('Queued', $this->orders);
        $this->washing = $this->getStats('Washing in progress', $this->orders);
        $this->ready = $this->getStats('Ready for Pickup/Delivery', $this->orders);
        $this->complete = $this->getStats('Order Complete', $this->orders);
    }

    private function getStats(string $status, $orders)
    {
        $stats = Arr::where($orders, function ($order, $key) use ($status) {
            return $order->status == $status;
        });
        return count($stats);
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'orders' => $this->orders
        ]);
    }
}
