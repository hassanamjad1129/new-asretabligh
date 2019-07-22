<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordView()
    {
        return view('customer.auth.forgotPassword');
    }
}
