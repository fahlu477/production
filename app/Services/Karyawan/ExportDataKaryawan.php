<?php

namespace App\Services\Karyawan;

use App\Karyawan;
use App\MyTrait\ExportCSVTrait;
use Illuminate\Support\Facades\DB;

class ExportDataKaryawan{
    use ExportCSVTrait{
        export as traitExport;
    }

    public static function exportCsvEndUser(){
        $records = [];
        DB::table('karyawan')
        ->select([
            'nik',
            'nama',
            'group',
            'branch',
            'departemen',
            'departemensub',
            'branchdetail',
            'departemensubsub',
            'jabatan',
            'tanggal_masuk',
            'statuskontrak',
            // DB::raw('if((isnull(tanggal_habis_kontrak2)),tanggal_habis_kontrak1,tanggal_habis_kontrak2) as akhir_kontrak'),
            'tanggal_mulai_kontrak1',
            'tanggal_habis_kontrak1',
            'tanggal_mulai_kontrak2',
            'tanggal_habis_kontrak2',
            'sisacuti',
            'agama',
            'statuskawin',
            'tempat_lahir',
            'tanggal_lahir',
            'jk',
            'pendidikan',
            'tna_group',
            'komp_gaji',
            'tanggungan',
            'alamat',
            'nik_ktp',
            'no_kpj',
            'no_kis',
            'no_npwp',
            'nohp',
            'isresign',
            'isaktif',
            'gmail',
            'nama_ibu_kandung',
            'no_tlp_keluarga_tdk_serumah',
            'nama_suami_istri',
            'nama_anak1',
            'nama_anak2',
            'nama_anak3',
            'branch_group',
            'group_jabatan',
            'approval_code',
            'nik_atasan',
        ])
        ->orderBy('nik', 'asc')
        ->chunk(200, function($data)use(&$records){
           foreach ($data as $key => $value) {
               array_push($records, $value);
           }
        });

        if(!count($records)) throw new \Exception("Data pengajuan kosong");

        return self::traitExport(self::callbackSeluruhData($records),'Data_personal_karyawan_' . date('Y_m_d'));
    }

    public static function exportCsvEndUserCln(){
        $records = [];
        DB::table('karyawan')
        ->select([
            'nik',
            'nama',
            'group',
            'branch',
            'departemen',
            'departemensub',
            'branchdetail',
            'departemensubsub',
            'jabatan',
            'tanggal_masuk',
            'statuskontrak',
            // DB::raw('if((isnull(tanggal_habis_kontrak2)),tanggal_habis_kontrak1,tanggal_habis_kontrak2) as akhir_kontrak'),
            'tanggal_mulai_kontrak1',
            'tanggal_habis_kontrak1',
            'tanggal_mulai_kontrak2',
            'tanggal_habis_kontrak2',
            'sisacuti',
            'agama',
            'statuskawin',
            'tempat_lahir',
            'tanggal_lahir',
            'jk',
            'pendidikan',
            'tna_group',
            'komp_gaji',
            'tanggungan',
            'alamat',
            'nik_ktp',
            'no_kpj',
            'no_kis',
            'no_npwp',
            'nohp',
            'isresign',
            'isaktif',
            'gmail',
            'nama_ibu_kandung',
            'no_tlp_keluarga_tdk_serumah',
            'nama_suami_istri',
            'nama_anak1',
            'nama_anak2',
            'nama_anak3',
            'branch_group',
            'group_jabatan',
            'approval_code',
            'nik_atasan',
        ])
        ->where('branch_group','cln')
        ->orderBy('nik', 'asc')
        ->chunk(200, function($data)use(&$records){
           foreach ($data as $key => $value) {
               array_push($records, $value);
           }
        });

        if(!count($records)) throw new \Exception("Data pengajuan kosong");

        return self::traitExport(self::callbackSeluruhData($records),'Data_personal_karyawan_cln_' . date('Y_m_d'));
    }

    public static function exportCsvEndUserMaja(){
        $records = [];
        DB::table('karyawan')
        ->select([
            'nik',
            'nama',
            'group',
            'branch',
            'departemen',
            'departemensub',
            'branchdetail',
            'departemensubsub',
            'jabatan',
            'tanggal_masuk',
            'statuskontrak',
            // DB::raw('if((isnull(tanggal_habis_kontrak2)),tanggal_habis_kontrak1,tanggal_habis_kontrak2) as akhir_kontrak'),
            'tanggal_mulai_kontrak1',
            'tanggal_habis_kontrak1',
            'tanggal_mulai_kontrak2',
            'tanggal_habis_kontrak2',
            'sisacuti',
            'agama',
            'statuskawin',
            'tempat_lahir',
            'tanggal_lahir',
            'jk',
            'pendidikan',
            'tna_group',
            'komp_gaji',
            'tanggungan',
            'alamat',
            'nik_ktp',
            'no_kpj',
            'no_kis',
            'no_npwp',
            'nohp',
            'isresign',
            'isaktif',
            'gmail',
            'nama_ibu_kandung',
            'no_tlp_keluarga_tdk_serumah',
            'nama_suami_istri',
            'nama_anak1',
            'nama_anak2',
            'nama_anak3',
            'branch_group',
            'group_jabatan',
            'approval_code',
            'nik_atasan',
        ])
        ->where('branch_group','maja')
        ->orderBy('nik', 'asc')
        ->chunk(200, function($data)use(&$records){
           foreach ($data as $key => $value) {
               array_push($records, $value);
           }
        });

        if(!count($records)) throw new \Exception("Data pengajuan kosong");

        return self::traitExport(self::callbackSeluruhData($records),'Data_personal_karyawan_maja_' . date('Y_m_d'));
    }
}