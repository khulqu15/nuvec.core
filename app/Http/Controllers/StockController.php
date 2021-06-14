<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(Stock $data)
    {
        $this->data = $data;
        $this->dataType = 'Stock Vaccine';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('VacCenter', 'Vaccines');
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
        $data = $this->data->with('VacCenter', 'Vaccines')->where('id', $id)->first();
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
            $data = $this->data->with('VacCenter', 'Vaccines')->where('id', $id)->first();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->data->with('VacCenter', 'Vaccines')->where('id', $id)->first();
            $update = $this->data->destroy($id);
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
