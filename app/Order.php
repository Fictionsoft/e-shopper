<?php

namespace App;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $order_data)
 * @method static orderBy(string $string, string $string1)
 */
class Order extends Model
{
    protected $fillable = ['user_id', 'shipping_id', 'payment_id', 'order_total', 'status', 'seen'];

    protected $appends = ['OrderSubmitAgoTimes'];

    public function getOrderSubmitAgoTimesAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($order) {
            $order->orderDetails()->delete(); // For delete order first use find($id) then store into $order. Then use $order->delete()
            $order->shipping()->delete();
        });
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => OrderCreated::class,
    ];
}
