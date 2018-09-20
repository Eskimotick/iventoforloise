<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cezpdf;
// include ('class.ezpdf.php');

class Pdf extends Model
{
    public static function geraPdf(){
        $pdf = new Cezpdf();
        $pdf->selectFont('Helvetica');
        $pdf->ezText('Hello World!',50);
        $pdf->ezStream();
    }
    
}
