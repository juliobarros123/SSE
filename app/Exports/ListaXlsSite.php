<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ListaXlsSite implements FromView
{
    private $data;

    public function __construct( $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view("admin.pdfs.listaxlsx.index", $this->data);
    }

}
