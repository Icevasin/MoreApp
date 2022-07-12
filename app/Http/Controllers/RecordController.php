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

    public function searchdate(Request $request)
    {
        $brand = $request->brand;
        $start = date($request->start);
        $end = date($request->end);
        $record = RecordModel::LeftJoin('brands','brands.id','=','record_models.Brand_id')
                ->select('brands.Brand_name','record_models.Record_date')
                ->WhereBetween('record_models.Record_date',[$start,$end])->get();
        $count = $record->count();
        return [$record,$count];
        
    }
}
