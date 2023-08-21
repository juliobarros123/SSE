<?php

namespace App\Http\Controllers;

use App\Models\Cabecalho;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    public function index()
    {
        $response['cabecalho'] = Cabecalho::find(1);
        return view('site.site', $response);
    }
}
 