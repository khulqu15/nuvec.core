<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PesertaController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(Peserta $data)
    {
        $this->data = $data;
        $this->dataType = 'Peserta';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('VacCenter', 'VacStatus', 'Vaccines');
        if($request->get('name') != null && $request->get('name')) {
            $data = $query->where('name', 'LIKE', '%'.$request->get('name').'%');
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
            $api = $this->data->find($data->id);
            $api->api_token = Str::random(60);
            $api->password = Hash::make($api->password);
            $api->save();
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $data = $this->data->with('VacCenter', 'VacStatus', 'Vaccines')->where('id', $id)->first();
        return $this->onSuccess($this->dataType, $data, 'Founded');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->data->where('id', $id)->update($request->except('_method', '_token', 'password'));
            $data = $this->data->with('VacCenter', 'VacStatus', 'Vaccines')->where('id', $id)->first();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->with('VacCenter', 'VacStatus', 'Vaccines')->where('id', $id)->first();
            $update = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function storeRelation(Request $request, $id)
    {
        $vaccines_id = $request->vaccines_id;
        $data = Peserta::find($id);
        $data->Vaccines()->attach([$vaccines_id]);
        $peserta = $this->data->with('VacStatus', 'VacCenter', 'Vaccines')->find($id);
        return $this->onSuccess($this->dataType, $peserta, 'Success add vaccines');
    }

    public function destroyRelation(Request $request, $id)
    {
        $vaccines_id = $request->vaccines_id;
        $data = Peserta::find($id);
        $data->Vaccines()->detach([$vaccines_id]);
        $peserta = $this->data->with('VacStatus', 'VacCenter', 'Vaccines')->find($id);
        return $this->onSuccess($this->dataType, $peserta, 'Success remove vaccines');
    }

    public function storeRelationStatus(Request $request, $id)
    {
        $status_id = $request->status_id;
        $data = Peserta::find($id);
        $data->VacStatus()->attach([$status_id]);
        $peserta = $this->data->with('VacStatus', 'VacCenter', 'Vaccines')->find($id);
        return $this->onSuccess($this->dataType, $peserta, 'Success add status');
    }

    public function destroyRelationStatus(Request $request, $id)
    {
        $status_id = $request->status_id;
        $data = Peserta::find($id);
        $data->VacStatus()->detach([$status_id]);
        $peserta = $this->data->with('VacStatus', 'VacCenter', 'Vaccines')->find($id);
        return $this->onSuccess($this->dataType, $peserta, 'Success remove status');
    }
}
