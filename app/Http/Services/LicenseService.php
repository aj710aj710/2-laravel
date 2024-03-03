<?php

namespace App\Http\Services;

use App\Models\License;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class LicenseService
{
    use ResponseTrait;

    public function list($id)
    {
        $plan = License::join('plans', 'licenses.product_plan', 'plans.id')
            ->where(['licenses.product_id' => $id, 'licenses.user_id' => auth()->id()])
            ->select(DB::raw("plans.name as plan_name,licenses.*"));
        return datatables($plan)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "<p class='zBadge zBadge-active'>Active</p>";
                } else {
                    return "<p class='zBadge zBadge-inactive'>Inactive</p>";
                }
            })

            ->addColumn('action', function ($data) {
                return "<div class='d-flex justify-content-end align-items-center g-10'>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='getEditModal(\"" . route("user.license.edit", encrypt($data->id)) . "\"" . ", \"#editLicenseModal\")'><img src='" . asset('user') . "/images/icon/edit.svg' alt=''></button>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='deleteItem(\"" . route("user.license.delete", encrypt($data->id)) . "\", \"licenseDetailsTable\")'><img src='" . asset('user') . "/images/icon/delete.svg' alt=''></button>
                        </div>";
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
