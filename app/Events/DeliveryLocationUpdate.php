<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lat;
    public $lng;

    // protected $delivery;
    /**
     * Create a new event instance.
     */
    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;

        // $this->$delivery = $delivery;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('deliveries. '.$this->delivery->order_id),
            new Channel('deliveries'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }


    public function broadcastAs()
    {
        return 'location-updated';
    }
}
