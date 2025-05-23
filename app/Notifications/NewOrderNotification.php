<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// class NewOrderNotification extends Notification implements ShouldQueue
class NewOrderNotification extends Notification
{
    use Queueable;

    // protected $name, $product, $price, $order;
    protected $name, $product, $price;

    /**
     * Create a new notification instance.
     */
    // public function __construct($name, $product, $price,Order $order)
    public function __construct($name, $product, $price)
    {
        $this->name    = $name;
        $this->product = $product;
        $this->price   = $price;
        // $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // mail, database, broadcast, vonage, slack
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
        // mail trap
        // $addr = $this->order->billingAddress;
        // return (new MailMessage)
            // ->subject("New Order #" . $this->order->number)
            // ->greeting('Dear ' . $notifiable->name)
            // ->line("A New Order (#({$this->order->number}) created by {$addr->name} from {$addr->country_name}")
            // ->action('Notification Action', url('/'))
            // ->line('Thank you for using our application!');
            // ->view('')
    // }

    public function toDatabase(object $notifiable)
    {
        return
        [
            'msg' => 'New order created, '.$this->name.' purchase '.$this->product.' with cost '.$this->price,
            'url' => route('admin.orders')
        ];
    }

    public function toBroadcast(object $notifiable)
    {
        return
        new BroadcastMessage([
            'msg' => 'New order created, '.$this->name.' purchase '.$this->product.' with cost '.$this->price,
            'url' => route('admin.orders')
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // 'msg' => 'New order created, ' . $this->name . ' purchase ' . $this->product . ' with cost ' . $this->price,
            // 'url' => route('admin.orders')
        ];
    }
}
