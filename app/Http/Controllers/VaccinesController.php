<?php

namespace App\Http\Controllers;

use App\Models\Vaccines;
use Illuminate\Http\Request;

class VaccinesController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(Vaccines $data)
    {
        $this->data = $data;
        $this->dataType = 'Vaccines';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('Stock', 'Peserta', 'Stock.VacCenter');
        if($request->get('brand') != null && $request->get('brand')) {
            $data = $query->where('brand', 'LIKE', '%'.$request->get('brand').'%');
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
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $data = $this->data->with('Stock', 'Peserta', 'Stock.VacCenter')->where('id', $id)->first();
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
            $data = $this->data->with('Stock', 'Peserta')->where('id', $id)->first();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->with('Stock', 'Peserta')->where('id', $id)->first();
            $update = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function storeRelation(Request $request, $id)
    {
        $peserta_id = $request->peserta_id;
        $data = Vaccines::find($id);
        $data->Peserta()->attach([$peserta_id]);
        $vacciness = $this->data->with('Stock', 'Peserta')->find($id);
        return $this->onSuccess($this->dataType, $vacciness, 'Success add Participant');
    }

    public function destroyRelation(Request $request, $id)
    {
        $peserta_id = $request->peserta_id;
        $data = Vaccines::find($id);
        $data->Peserta()->detach([$peserta_id]);
        $vacciness = $this->data->with('Stock', 'Peserta')->find($id);
        return $this->onSuccess($this->dataType, $vacciness, 'Remove add Participant');
    }
}
