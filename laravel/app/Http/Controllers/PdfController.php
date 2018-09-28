<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Pdf;
use PDF;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('entrei');
        
        $pdf = Pdf::geraPdf();
        
        return $pdf;
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
    public function update(Request $request, $id)
    {
        //
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

    public function generatePdf(Request $request){

        $teste = 'José maria';
        $details = '<html>
        <body background="http://d1x4bjge7r9nas.cloudfront.net/wp-content/uploads/2018/02/17094131/bolsonaro.jpg">
        <div class="text-center">
        
            <h1 style="color:yellow">Ivento Terminado $user->name </h1>
           
           
        </div>
        </body>
        </html>';

        $details = str_replace('$user->name', $teste, $details);
        $pdf = PDF::loadHtml($details);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}
