<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    use ResponseTrait;

    public function myProfile()
    {
        $data['pageTitle'] = 'Profile';
        $data['affiliateInfo'] = User::where('role', USER_ROLE_AFFILIATE)->where('id', auth()->id())->first();
        return view('affiliate.profile.index', $data);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
        ]);
        $authUser = auth()->user();
        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
            ];
            if ($request->hasFile('image')) {
                $existFile = FileManager::where('id', $authUser->image)->first();
                if ($existFile) {
                    $existFile->removeFile();
                    $uploaded = $existFile->upload('User', $request->file('image'), '', $existFile->id);
                } else {
                    $newFile = new FileManager();
                    $uploaded = $newFile->upload('User', $request->file('image'));
                }

                if ($uploaded) {
                    $userData['image'] = $uploaded->id;
                } else {
                    throw new \Exception(__('Image Not Uploaded.'));
                }
            }
            $oldPassword = $request->get('old_password','');
            $password = $request->get('password','');
            if($password != '' && $oldPassword != '') {
                if (Hash::check($oldPassword, $authUser->password)) {
                    $userData['password'] = Hash::make($request->password);
                } else {
                    DB::rollBack();
                    return $this->error([], "Current password does not match!");
                }
            }

            $authUser->update($userData);
            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));


        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
