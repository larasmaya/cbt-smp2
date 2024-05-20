<?php

namespace App\Imports;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Actions\SendResponse;
use Illuminate\Support\Str;

class PesertaImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        $agama_kodes = [];
        $jurusan_kodes = [];

        $pesertas = [];
        foreach($rows as $row) {
            if ($row->filter()->isNotEmpty()) {
                $agama_kodes = array_unique(array_merge($agama_kodes, [$row[5]]));
                $jurusan_kodes = array_unique(array_merge($jurusan_kodes, [$row[4]]));

                $pesertas[] = [
                    'sesi' => $row[0],
                    'no_ujian' => $row[1],
                    'nama' => $row[2],
                    'password' => $row[3],
                    'jurusan_id' => $row[4],
                    'agama_id' => $row[5]
                ];
            }
        }

        $agama_kodes = DB::table('agamas')->whereIn('kode', $agama_kodes)->get();
        $jurusan_kodes = DB::table('jurusans')->whereIn('kode', $jurusan_kodes)->get();

        $final = $pesertas;
        foreach($pesertas as $key => $value) {
            $final[$key]['id'] = Str::uuid()->toString();

            $jurusan = $jurusan_kodes->where('kode', $value['jurusan_id'])->first();
            if (is_null($jurusan)) {
                throw new Exception("jurusan dengan kode: ".$value['jurusan_id']." tidak ditemukan");
            }
            $final[$key]['jurusan_id'] = $jurusan->id;

            $agama = $agama_kodes->where('kode', $value['agama_id'])->first();
            if (is_null($agama)) {
                throw new Exception("agama dengan kode: ".$value['agama_id']." tidak ditemukan");
            }

            $final[$key]['agama_id'] = $agama->id;
            $final[$key]['created_at'] = now()->addSeconds($key);
            $final[$key]['updated_at'] = now()->addSeconds($key);
        }

        try {
            DB::table('pesertas')->insert($final);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
