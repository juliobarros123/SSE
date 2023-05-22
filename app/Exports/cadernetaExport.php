<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class cadernetaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct( $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view("admin.pdfs.cadernetaxlsx.index", $this->data);
    }

}
