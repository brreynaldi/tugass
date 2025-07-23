<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SemuaNilaiExport implements FromCollection, WithHeadings
{
    protected $guru_id;

    public function __construct($guru_id)
    {
        $this->guru_id = $guru_id;
    }

    public function collection()
    {
        return DB::table('tugas_jawaban')
            ->join('tugas', 'tugas_jawaban.tugas_id', '=', 'tugas.id')
            ->join('users', 'tugas_jawaban.siswa_id', '=', 'users.id')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->where('tugas.guru_id', $this->guru_id)
            ->select(
                'tugas.judul as Judul Tugas',
                'kelas.nama as Kelas',
                'users.name as Nama Siswa',
                'tugas_jawaban.nilai as Nilai'
            )
            ->get();
    }

    public function headings(): array
    {
        return ['Judul Tugas', 'Kelas', 'Nama Siswa', 'Nilai'];
    }
}
