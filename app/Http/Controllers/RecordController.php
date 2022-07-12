<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordModel;
class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RecordModel::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Record_date' => 'required',
            'Model_id' => 'required',
            'Brand_id' => 'required',
            'Employee_id' => 'required',
        ]);
        return RecordModel::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return RecordModel::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = RecordModel::find($id);
        $record->update($request->all());
        return $record;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return RecordModel::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return RecordModel::where('Employee_firstname','like','%'.$name.'%')->get();
    }

    public function searchone(Request $request)
    {
        $brand = $request->brand;
        $start = $request->start;
        $end = $request->end;
        $model = $request->model;
        $record = RecordModel::LeftJoin('brands','brands.id','=','record_models.Brand_id')
                ->LeftJoin('car_models','car_models.id','=','record_models.Model_id')
                ->LeftJoin('employee_models','employee_models.id','=','record_models.Employee_id')
                ->select('brands.Brand_name','car_models.CarModel_name','record_models.Record_date','employee_models.Employee_firstname','employee_models.Employee_lastname')
                ->where('record_models.Brand_id','like','%'.$brand.'%')
                ->where('record_models.Model_id','like','%'.$model.'%')
                ->WhereBetween('record_models.Record_date',[$start,$end])
                ->orderBy('record_models.Record_date', 'ASC')
                ->get();
        $count = $record->count();
        return [$record,'จำนวนที่ขายได้',$count];
        
    }
}
