<?php

namespace App\Http\Controllers\PaymentControllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class RazorpayController extends BaseController
{
    protected $account;
    protected $razorpay;

    // Initialize Obj
    public function __construct($account)
    {
        $this->account = $account;
        $this->razorpay = new Api($account->padPartnerKeyId, $account->padPartnerSecret);
    }

    // Payment Method
    public function initiatePayment($paymentDetails)
    {
        $amount = $paymentDetails->amount;
        $employeeEmail = $paymentDetails->reciverEmail;

        try {
            // Create a Razorpay payout
            $payout = $this->razorpay->payout->create([
                'account_number' => $paymentDetails["account_number"],
                'fund_account_id' => $paymentDetails["fund_account_id"],
                'contact_id' => $paymentDetails["contact_id"],
                'amount' => $paymentDetails["amount"] * 100, // Amount in paisa
                'currency' => $paymentDetails["currency"],
                'mode' => $paymentDetails["mode"],
                'purpose' => $paymentDetails["purpose"],
                'queue_if_low_balance' => true,
                'reference_id' => $paymentDetails["reference_id"],
                'narration' => $paymentDetails["narration"],
            ]);

            // Update Balance in Account
            DB::table('tblPaymentAccountDetails')
                ->where('padId', $this->account->padId)
                ->update(['padLinkedBankBalance' => DB::raw('padLinkedBankBalance - ' . $amount)]);

            // Success Message
            return json_encode(['status' => 200, 'message' => 'Salary payment initiated successfully']);
        } catch (\Exception $e) {
            // Error Message
            return json_encode(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
