<?php
namespace App\Exports;

use App\Models\TugasJawaban;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    protected $tugas_id;

    public function __construct($tugas_id)
    {
        $this->tugas_id = $tugas_id;
    }

    public function collection()
    {
        return TugasJawaban::with('siswa')
            ->where('tugas_id', $this->tugas_id)
            ->get()
            ->map(function ($jawaban) {
                return [
                    'nama_siswa' => $jawaban->siswa->name,
                    'nilai' => $jawaban->nilai ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Siswa', 'Nilai'];
    }
}
