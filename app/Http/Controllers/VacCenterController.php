<?php

namespace App\Http\Controllers;

use App\Models\VacCenter;
use Illuminate\Http\Request;

class VacCenterController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(VacCenter $data)
    {
        $this->data = $data;
        $this->dataType = 'Vaccine Center';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('Peserta', 'Schedule', 'Stock', 'Stock.Vaccines');
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
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $data = $this->data->with('Peserta', 'Schedule', 'Stock', 'Stock.Vaccines')->where('id', $id)->first();
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
            $data = $this->data->with('Peserta', 'Schedule', 'Stock')->where('id', $id)->first();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->with('Peserta', 'Schedule', 'Stock')->where('id', $id)->first();
            $update = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function storeRelation(Request $request, $id)
    {
        $schedule_id = $request->schedule_id;
        $data = VacCenter::find($id);
        $data->Schedule()->attach([$schedule_id]);
        $vac = $this->data->with('Schedule')->find($id);
        return $this->onSuccess($this->dataType, $vac, 'Success Add Schedule');
    }

    public function destroyRelation(Request $request, $id)
    {
        $schedule_id = $request->schedule_id;
        $data = VacCenter::find($id);
        $data->Schedule()->detach([$schedule_id]);
        $vac = $this->data->with('Schedule')->find($id);
        return $this->onSuccess($this->dataType, $vac, 'Success Remove Schedule');
    }
}
