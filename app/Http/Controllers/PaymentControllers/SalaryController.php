<?php

namespace App\Http\Controllers\PaymentControllers;

use Illuminate\Routing\Controller as BaseController;
use Razorpay\Api\Api;

class SalaryController extends BaseController
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }
}
