<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin\Lote;
use App\Http\Requests\Admin\UpdateLoteRequest as UpdateRequest;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLote(UpdateRequest $request, $id)
    {
        $lote = Lote::find($id);
        
        if($lote){
            $lote->updateLote($request);
            return response()->success($lote);            
        }
        else{
            return response()->error('Lote não encontrado, verifique se o pacote existe.', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
