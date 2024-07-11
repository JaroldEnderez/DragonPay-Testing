<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment.form');
    }

    public function processPayment(Request $request)
    {
        $errors = [];
        $is_link = false;

        $parameters = [
            'merchantid' => config('services.dragonpay.merchant_id'),
            'txnid' => $request->input('txnid'),
            'amount' => $request->input('amount'),
            'ccy' => 'PHP',
            'description' => $request->input('description'),
            'email' => $request->input('email'),
        ];

        // Validate values.
        if (!is_numeric($parameters['amount'])) {
            $errors[] = 'Amount should be a number.';
        } elseif ($parameters['amount'] <= 0) {
            $errors[] = 'Amount should be greater than 0.';
        }

        if (empty($errors)) {
            // Transform amount to correct format.
            $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');
            // Unset later from parameter after digest.
            $parameters['key'] = config('services.dragonpay.merchant_password');
            $digest_string = implode(':', $parameters);
            unset($parameters['key']);
            $parameters['digest'] = sha1($digest_string);
            $url = 'https://gw.dragonpay.ph/Pay.aspx?';

            if (config('services.dragonpay.environment') == 'test') {
                $url = 'http://test.dragonpay.ph/Pay.aspx?';
            }

            $url .= http_build_query($parameters, '', '&');

            if ($is_link) {
                return view('payment.link', ['url' => $url]);
            } else {
                return redirect($url);
            }
        }

        return view('payment.form', ['errors' => $errors]);
    }
}
