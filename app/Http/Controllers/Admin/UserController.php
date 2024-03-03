<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    use General;

    public function customerList(Request $request)
    {
        $data['pageTitle'] = __('Customers');
        $data['showCustomerList'] = 'show active';
        $data['activeCustomerList'] = 'active';

        if ($request->ajax()) {
            $user = User::leftJoin('orders', 'users.id', '=', 'orders.customer_id')
                ->leftJoin('gateways', 'orders.gateway_id', '=', 'gateways.id')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->select(
                    'users.name as customer_name',
                    'gateways.title as gateway_name',
                    'users.email as customer_email',
                    'users.created_at as customer_create_date',
                    'user_details.billing_country',
                    DB::raw('SUM(orders.total) as total_revenue'),
                    'users.id as customer_id'
                )
                ->where('users.role', USER_ROLE_CUSTOMER)
                ->groupBy('users.id');


            return datatables($user)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return '<h4 class="fs-14 fw-400 lh-24 text-para-text">' . htmlspecialchars($data->customer_name) . ' </h4>';
                })
                ->addColumn('email', function ($data) {
                    return $data->customer_email ?? __("N/A");
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y', strtotime($data->customer_create_date));
                })
                ->addColumn('revenue', function ($data) {
                    return showPrice($data->total_revenue); // Display the total revenue
                })
                ->addColumn('country', function ($data) {
                    return $data->billing_country ?? __("N/A");
                })
                ->addColumn('payment', function ($data) {
                    return $data->gateway_name ?? __("N/A");
                })
                ->rawColumns(['name'])
                ->make(true);
        }
        return view('admin.customer.index', $data);
    }
    public function userList(Request $request)
    {
        $data['pageTitle'] = __('Users');
        $data['showUserList'] = 'show active';
        $data['activeCustomerList'] = 'active';

        if ($request->ajax()) {
            $user = User::leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.role', USER_ROLE_USER)
            ->select("users.*",  DB::raw('SUM(orders.total) as total_revenue'))
            ->groupBy('users.id');


            return datatables($user)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return '<h4 class="fs-14 fw-400 lh-24 text-para-text">' . htmlspecialchars($data->name) . ' </h4>';
                })
                ->addColumn('revenue', function ($data) {
                    return showPrice($data->total_revenue); // Display the total revenue
                })
                ->addColumn('email', function ($data) {
                    return $data->email ?? __("N/A");
                })
                ->addColumn('created_at', function ($data) {
                    if($data->created_at == null){
                        return 'N/A';
                    }
                    return date('d-m-Y', strtotime($data->created_at));
                })


                ->rawColumns(['name'])
                ->make(true);
        }
        return view('admin.user.index', $data);
    }



    public function create()
    {
        $data['title'] = 'Add User';
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserCreateActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
    }


    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 1;
        $user->assignRole($request->role_name);
        $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');

    }

    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        $data['user'] = User::find($id);
        return view('admin.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        if (User::whereEmail($request->email)->where('id', '!=', $id)->count() > 0)
        {
            $this->showToastrMessage('warning', 'Email already exist');
            return redirect()->back();
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        if ($request->role_name)
        {
            DB::table('model_has_roles')->where('role_id', $user->roles->first()->id)->where('model_id', $id)->delete();
        }
        $user->assignRole($request->role_name);
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');

    }

    public function delete($id)
    {
        User::whereId($id)->delete();

        $this->showToastrMessage('error', 'User has been deleted');
        return redirect()->back();
    }


}
