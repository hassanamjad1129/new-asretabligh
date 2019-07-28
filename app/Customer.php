<?php

namespace App;

use App\Notifications\CustomerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'telephone', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token));
    }

    public function totalOrders()
    {
        return order::where('customer_id', $this->id)->count();
    }

    public function totalOrderItems()
    {
        return OrderItem::where('user_id', $this->id)->count();
    }

    public function totalCart()
    {
        return cart::where('customer_id', $this->id)->where('status', 0)->count();
    }

    public function lastOrder()
    {
        $order = order::where('customer_id', $this->id)->orderBy('id', 'desc')->first();
        if ($order) {
            return $order->created_at;
        }
        return null;
    }

    public function finalOrders()
    {
        return order::where('customer_id', $this->id)->where('status', 3)->count();
    }

    public function ordersCleard()
    {
        $orders = order::where('customer_id', $this->id)->get();
        $counter = 0;
        foreach ($orders as $order) {
            if ($order->isCleared())
                $counter++;
        }
        return $counter;
    }

    public function sumPays()
    {
        $orders = order::where('customer_id', $this->id)->get();
        $sumPrice = 0;
        foreach ($orders as $order) {
            $pays = $order->pay;
            foreach ($pays as $pay) {
                if ($pay->status)
                    $sumPrice += $pay->price;
            }
        }
        return $sumPrice;
    }

    public function lastPay()
    {
        $created_at = pay::join('orders', 'pays.order_id', '=', 'orders.id')->select(['pays.id AS uid', 'pays.created_at'])->where('orders.customer_id', Auth::guard('customer')->user()->id)->where('pays.status', 1)->orderBy("uid", 'desc')->first();
        if ($created_at)
            return $created_at->created_at;
        return null;
    }

    public function moneybagReport()
    {
        return $this->hasMany(MoneyBagReport::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'user_id');
    }

}
