<?php

namespace App\Imports;

use App\Models\Rab;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadingsRow;

class RabImport implements ToModel, WithHeadingRow
{
    private $organisasi_id;

    public function __construct($organisasi_id)
    {
        $this->organisasi_id = $organisasi_id;
    }

    public function model(array $row)
    {
        return new Rab([
            'organisasi_id' => $this->organisasi_id,
            'nama_kegiatan' => $row['nama_kegiatan'],
            'rencana_anggaran' => $row['rencana_anggaran'],
        ]);
    }
}
