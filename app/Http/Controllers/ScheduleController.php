<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\VacCenter;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(Schedule $data)
    {
        $this->data = $data;
        $this->dataType = 'Schedule';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('VacCenter');
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
        $data = $this->data->with('VacCenter')->where('id', $id)->first();
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
            $data = $this->data->with('VacCenter')->where('id', $id)->first();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->with('VacCenter')->where('id', $id)->first();
            $update = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function storeRelation(Request $request, $id)
    {
        $vac_center_id = $request->vac_center_id;
        $data = Schedule::find($id);
        $data->VacCenter()->attach([$vac_center_id]);
        $schedule = Schedule::with('VacCenter')->find($id);
        return $this->onSuccess($this->dataType, $schedule, 'Success add Vac Center');
    }

    public function destroyRelation(Request $request, $id)
    {
        $vac_center_id = $request->vac_center_id;
        $data = Schedule::find($id);
        $data->VacCenter()->detach([$vac_center_id]);
        $schedule = Schedule::with('VacCenter')->find($id);
        return $this->onSuccess($this->dataType, $schedule, 'Success remove Vac Center');
    }
}
