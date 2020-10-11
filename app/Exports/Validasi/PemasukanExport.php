<?php

namespace App\Exports\Validasi;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PemasukanExport implements FromView, ShouldAutoSize
{
    protected $catatan,$barang;

    function __construct($catatan,$barang) {
        $this->catatan = $catatan;
        $this->barang = $barang;
    }

    public function view(): View
    {
        return view('export.export_pemasukan', [
            'catatan'               => $this->catatan,
            'barang'                => $this->barang,
        ]);
    }
}
