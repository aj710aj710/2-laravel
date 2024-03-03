<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeneficiaryRequest;
use App\Http\Requests\WithdrawalRequest;
use App\Http\Services\BeneficiaryService;
use App\Http\Services\WalletService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public $walletService;

    public function __construct()
    {
        $this->walletService = new WalletService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->walletService->getAllData(auth()->id());
        }
    }

    public function withdrawalRequest(WithdrawalRequest $request)
    {
       return $this->walletService->withdrawRequest($request);
    }
}
