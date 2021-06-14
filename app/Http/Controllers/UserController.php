<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public $data;
    public $dataType;

    public function __construct(User $data)
    {
        $this->data = $data;
        $this->dataType = 'User';
    }

    public function index(Request $request)
    {
        $query = $this->data->query();
        if($request->get('username') != null && $request->get('username')) {
            $data = $query->where('username', 'like', '%'.$request->get('username').'%');
        }
        if($request->get('pagination') != null && $request->get('pagination')) {
            $data = $query->paginate($request->get('pagination'));
        } else {
            $data = $query->get();
        }
        return $this->onSuccess($this->dataType, $data, 'Founded');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $data = $this->data->create($request->except('_method', '_token'));
            $api = User::find($data->id);
            $api->api_token = Str::random(50);
            $api->password = Hash::make($data->password);
            $api->save();
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $data = $this->data->find($id);
        return $this->onSuccess($this->dataType, $data, 'Founded');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->data->where('id', $id)->update($request->except('_method', '_token'));
            $data = $this->data->find($id);
            $api = User::find($data->id);
            $api->api_token = Str::random(50);
            $api->password = Hash::make($data->password);
            $api->save();
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->find($id);
            $delete = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
