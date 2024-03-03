<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProductController extends Controller
{
    use ResponseTrait;

    protected $product;
    public function __construct()
    {
        $this->product = new ProductService();
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->product->list();
        }
        $data['pageTitle'] = __('');
        $data['title'] = __('Product List');
        $data['activeProduct'] = 'active';
        return view('user.product.list', $data);
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->id)) {
                $product = Product::find(decrypt($request->id));
            } else {
                if (!getUserPackageLimit(RULES_PRODUCT, auth()->id()) > 0) {
                    throw new Exception(__('Your Product Limit Finished!'));
                }
                $product = new Product();
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->status = isset($request->status) ? $request->status : 1;
            $product->user_id = auth()->id();
            $product->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function delete($id)
    {
        try {
            $id = decrypt($id);
            $data = Product::find($id);
            $data->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function edit($id)
    {

        try {
            $data['product'] = Product::find(decrypt($id));
            return view('user.product.edit-form', $data)->render();
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
