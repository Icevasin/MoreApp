<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordModel;
use App\Models\Brand;
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
        $start = $request->start;
        $end = $request->end;
        $brand = $request->brand;
        $record = RecordModel::LeftJoin('car_models','car_models.id','=','record_models.Model_id')
                ->LeftJoin('brands','brands.id','=','car_models.Brand_id')
                ->LeftJoin('employee_models','employee_models.id','=','record_models.Employee_id')
                ->select('brands.Brand_name as Brand',Brand::raw("COUNT(brands.id) as ขายได้"))
                ->where('car_models.Brand_id','like','%'.$brand.'%')
                ->WhereBetween('record_models.Record_date',[$start,$end])
                ->groupBy('Brand')
                ->orderBy('record_models.Record_date', 'ASC','brands.Brand_name')
                ->get();
                return [$record,'ระหว่างวันที่ ',$start,'ถึง',$end];
        
    }

    public function searchtwo(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $brand = $request->brand;
        $model = $request->model;
        $record = RecordModel::LeftJoin('car_models','car_models.id','=','record_models.Model_id')
                ->LeftJoin('brands','brands.id','=','car_models.Brand_id')
                ->LeftJoin('employee_models','employee_models.id','=','record_models.Employee_id')
                ->select('brands.Brand_name as Brand','car_models.CarModel_name as Model',Brand::raw("COUNT(brands.id) as ขายได้"))
                ->where('car_models.Brand_id','like','%'.$brand.'%')
                ->where('record_models.Model_id','like','%'.$model.'%')
                ->WhereBetween('record_models.Record_date',[$start,$end])
                ->groupBy('Brand','Model')
                ->orderBy('record_models.Record_date', 'ASC','brands.Brand_name')
                ->get();
        return [$record,'ระหว่างวันที่ ',$start,'ถึง',$end];
        
    }

    public function searchthree(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $employee = $request->employee;
        $record = RecordModel::LeftJoin('car_models','car_models.id','=','record_models.Model_id')
                ->LeftJoin('brands','brands.id','=','car_models.Brand_id')
                ->LeftJoin('employee_models','employee_models.id','=','record_models.Employee_id')
                ->select('brands.Brand_name as Brand','car_models.CarModel_name as model',Brand::raw("COUNT(brands.id) as ขายได้"))
                ->where('record_models.Employee_id','like','%'.$employee.'%')
                ->WhereBetween('record_models.Record_date',[$start,$end])
                ->groupBy('Brand','model')
                ->orderBy('record_models.Record_date', 'ASC','brands.Brand_name')
                ->get();
        return [$record,'ระหว่างวันที่ ',$start,'ถึง',$end];
        
    }
}


