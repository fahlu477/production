<?php


namespace App;

use App\MyTrait\TanggalIndo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'karyawan';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $appends = ['tanggal_lahir_indo','tanggal_masuk_indo'];
    protected $fillable = [
        'nik',
        'nama',
        'jk',
        'departemen',
        'departemensub',
        'departemensubsub',
        'jabatan',
        'group',
        'branch',
        'branchdetail',
        'statuskontrak',
        'agama',
        'statuskawin',
        'email',
        'password',
        'nohp',
        'foto',
        'sisacuti',
        'lastcuti',
        'lastlogin',
        'isresign',
        'isaktif',
        'approval_code',
        'role',
        'tanggal_masuk',
        'tanggal_mulai_kontrak1',
        'tanggal_habis_kontrak1',
        'tanggal_mulai_kontrak2',
        'tanggal_habis_kontrak2',
        'tanggal_lahir',
        'tempat_lahir',
        'tna_group',
        'tgl_trigger_cuti', //tgl masuk / tgl pengangkatan
        'branch_group', // gm1. gm2, maja --> maja | cln --> cln | gs -> gs
        'pendidikan',
        'komp_gaji',
        'bank',
        'rekening',
        'tanggungan',
        'alamat',
        'nik_ktp',
        'no_kpj',
        'no_kis',
        'no_npwp',
        'nohp',
        'gmail',
        'nama_ibu_kandung',
        'no_tlp_keluarga_tdk_serumah',
        'nama_suami_istri',
        'nama_anak1',
        'nama_anak2',
        'nama_anak3',
        'file'
    ];

    protected $hidden = [
        'password',
    ];

    public static function getListStatusKaryawan(){
        return [
            '0' => 'Karyawan Aktif',
            '1' => 'Karyawan Resign'
        ];
    }

    public static function listbranch(){
        return [
            'CLN',
            'MAJA',
            'GS',
            'GK'
        ];
    }

    public static function branchdetail(){
        return [
            'CLN',
            'GC',
            'GC 1',
            'GC 2',
            'GC 3',
            'GC 4',
            'GC 5',
            'GC 6',
            'GC 7',
            'GC 8',
            'GC 9',
            'GK',
            'MAN',
            'GM',
            'GM1',
            'GM2',
            'GS'
        ];
    }

    public static function getListResignKaryawan(){
        return [
            '0' => 'Karyawan Resign',
            '1' => 'Karyawan Aktif'
        ];
    }

    public function getTanggalLahirIndoAttribute(){
        $tgl = $this->attributes['tanggal_lahir'] ?? ''; //pake operator null coalescing untuk relasi eloquent yg spesifik attribute (jika attr ini ga dimasukan)
        if($tgl=='') return '';
        return TanggalIndo::getTanggalIndo($tgl);
    }

    public function getTanggalMasukIndoAttribute(){
        $tgl = $this->attributes['tanggal_masuk'] ?? ''; //pake operator null coalescing untuk relasi eloquent yg spesifik attribute (jika attr ini ga dimasukan)
        if($tgl=='') return '';
        return TanggalIndo::getTanggalIndo($tgl);
    }

}
