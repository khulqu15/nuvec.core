<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginAdminVac(Request $request)
    {
        try {
            if(Auth::guard('adminvac')->attempt($request->only('username', 'password'))) {
                $data = Auth::guard('adminvac')->user();
                return $this->onSuccess('Authentifikasi', $data, 'Success');
            } else {
                return $this->onSuccess('Authenfikasi', null, 'Failed');
            }
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function loginAdminGeneral(Request $request)
    {
        try {
            if(Auth::guard('admin')->attempt($request->only('username', 'password'))) {
                $data = Auth::guard('admin')->user();
                return $this->onSuccess('Authentifikasi', $data, 'Success');
            } else {
                return $this->onSuccess('Authenfikasi', null, 'Failed');
            }
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
    
    public function loginGeneral(Request $request)
    {
        try {
            if(Auth::guard('peserta')->attempt($request->only('nik', 'password'))) {
                $data = Auth::guard('peserta')->user();
                return $this->onSuccess('Authentifikasi', $data, 'Success');
            } else {
                return $this->onSuccess('Authentifikasi', ['salah'], 'Failed');
            }
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function getAuth()
    {
        $user = Auth::guard('peserta')->user();
        return $this->onSuccess('Authentifikasi', $user, 'Founded');
    }

    public function getAuthAdmin()
    {
        $user = Auth::guard('admin-api')->user();
        return $this->onSuccess('Authentifikasi Admin', $user, 'Founded');
    }

    public function getAuthAdminVac()
    {
        $user = Auth::guard('adminvac')->user();
        return $this->onSuccess('Authentifikasi', $user, 'Founded');
    }
}
