<?php

namespace App\Http\Services;
use App\Models\Product;
use App\Traits\ResponseTrait;

class ProductService
{
    use ResponseTrait;

    public function list()
    {
        $product = Product::where('user_id', auth()->id());

        return datatables($product)
            ->addIndexColumn()
            ->addColumn('plans', function ($data) {
                return count($data->plans);
            })
            ->addColumn('coupons', function ($data) {
                return count($data->coupons);
            })
            ->addColumn('addons', function ($data) {
                return count($data->license);
            })
            ->addColumn('action', function ($data) {
                return "<div class='d-flex flex-column flex-lg-row justify-content-xl-end align-items-center flex-wrap flex-sm-nowrap g-11'>
                           <div class='dropdown-one'>
                              <button class='dropdown-toggle bg-color7' type='button' data-bs-toggle='dropdown' aria-expanded='false'>".__('Plans')."</button>
                              <ul class='dropdown-menu'>
                                 <li><a class='dropdown-item product-id-push-on-add-modal addPlanModal' href='#' data-id='".encrypt($data->id)."' data-bs-toggle='modal' data-bs-target='#addPlanModal'><span><img src='".asset('user')."/images/icon/plus.svg' alt='' /></span><span>".__('Add Plan')."</span></a></li>
                                 <li><a class='dropdown-item' href='".route('user.plan.list', encrypt($data->id))."'><span><img src='".asset('user')."/images/icon/eye.svg' alt='' /></span><span>".__('View Plan')."</span></a></li>
                              </ul>
                           </div>
                           <div class='dropdown-one'>
                              <button class='dropdown-toggle bg-color6' type='button' data-bs-toggle='dropdown' aria-expanded='false'>".__('Coupons')."</button>
                              <ul class='dropdown-menu'>
                                 <li><a class='dropdown-item product-id-push-on-add-modal get-plan-list addCouponModal' href='#' data-id='".encrypt($data->id)."' data-bs-toggle='modal' data-bs-target='#addCouponModal'><span><img src='".asset('user')."/images/icon/plus.svg' alt='' /></span><span>".__('Add Coupon')."</span></a></li>
                                 <li><a class='dropdown-item' href='".route('user.coupon.list', encrypt($data->id))."'><span><img src='".asset('user')."/images/icon/eye.svg' alt='' /></span><span>View Coupon</span></a></li>
                              </ul>
                           </div>
                           <div class='dropdown-one'>
                              <button class='dropdown-toggle bg-color4' type='button' data-bs-toggle='dropdown' aria-expanded='false'>".__('License')."</button>
                              <ul class='dropdown-menu'>
                                 <li><a class='dropdown-item product-id-push-on-add-modal get-plan-list addLicenseModal' href='#' data-id='".encrypt($data->id)."' data-bs-toggle='modal' data-bs-target='#addLicenseModal'><span><img src='".asset('user')."/images/icon/plus.svg' alt='' /></span><span>".__('Add License')."</span></a></li>
                                 <li><a class='dropdown-item' href='".route('user.license.list', encrypt($data->id))."'><span class='flex-shrink-0'><img src='".asset('user')."/images/icon/eye.svg' alt='' /></span><span>".__('View License')."</span></a></li>
                              </ul>
                           </div>
                           <div class='d-flex align-items-center cg-10'>
                              <a href='#' onclick='getEditModal(\"" . route("user.product.edit", encrypt($data->id)) . "\"" . ", \"#editProductModal\")' class='d-flex'>
                                 <svg width='17' height='17' viewBox='0 0 17 17' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M7.75 2.59106H2.5C2.10218 2.59106 1.72064 2.7491 1.43934 3.0304C1.15804 3.31171 1 3.69324 1 4.09106V14.5911C1 14.9889 1.15804 15.3704 1.43934 15.6517C1.72064 15.933 2.10218 16.0911 2.5 16.0911H13C13.3978 16.0911 13.7794 15.933 14.0607 15.6517C14.342 15.3704 14.5 14.9889 14.5 14.5911V9.34106' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                    <path d='M13.375 1.46599C13.6734 1.16762 14.078 1 14.5 1C14.922 1 15.3266 1.16762 15.625 1.46599C15.9234 1.76436 16.091 2.16903 16.091 2.59099C16.091 3.01295 15.9234 3.41762 15.625 3.71599L8.5 10.841L5.5 11.591L6.25 8.59099L13.375 1.46599Z' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                 </svg>
                              </a>
                              <a href='#' onclick='deleteItem(\"" . route("user.product.delete", encrypt($data->id)) . "\", \"productTable\")' class='d-flex'>
                                 <svg width='16' height='17' viewBox='0 0 16 17' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M1 4H2.5H14.5' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                    <path d='M4.75 4V2.5C4.75 2.10218 4.90804 1.72064 5.18934 1.43934C5.47064 1.15804 5.85218 1 6.25 1H9.25C9.64782 1 10.0294 1.15804 10.3107 1.43934C10.592 1.72064 10.75 2.10218 10.75 2.5V4M13 4V14.5C13 14.8978 12.842 15.2794 12.5607 15.5607C12.2794 15.842 11.8978 16 11.5 16H4C3.60218 16 3.22064 15.842 2.93934 15.5607C2.65804 15.2794 2.5 14.8978 2.5 14.5V4H13Z' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                    <path d='M6.25 7.75V12.25' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                    <path d='M9.25 7.75V12.25' stroke='#596680' stroke-width='1.3' stroke-linecap='round' stroke-linejoin='round' />
                                 </svg>
                              </a>
                           </div>
                        </div>";
            })
            ->rawColumns(['action', 'plans', 'coupons', 'addons'])
            ->make(true);
    }
}
