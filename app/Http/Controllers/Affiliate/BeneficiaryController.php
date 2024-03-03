<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeneficiaryRequest;
use App\Http\Services\BeneficiaryService;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public $beneficiary;

    public function __construct()
    {
        $this->beneficiary = new BeneficiaryService();
    }

    public function store(BeneficiaryRequest $request)
    {
        return $this->beneficiary->store($request);
    }

    public function edit($id)
    {
        $data['beneficiary'] = $this->beneficiary->getInfoById($id);
        return view('affiliate.wallet.beneficiary-edit-form', $data);
    }

    public function update($id, BeneficiaryRequest $request)
    {
        return $this->beneficiary->update($id, $request);
    }

    public function delete($id)
    {
        return $this->beneficiary->deleteById($id);
    }
}
