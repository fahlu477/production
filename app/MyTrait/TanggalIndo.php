<?php

namespace App\MyTrait;

trait TanggalIndo{
    /**
     * Get tanggal indonesia : kamis, 26 Desember 2019
     *
     * @param string $tanggal
     * @return string
     */
    public static function getTanggalIndo($tanggal){
        $objDate = new \DateTime($tanggal);
        $hariIndo = config('app.hari_indo')[$objDate->format('w')];
        $bulanIndo = config('app.bulan')[$objDate->format('n')];
        return $hariIndo . ', ' . $objDate->format('d ') . $bulanIndo . ' ' . $objDate->format('Y');
    }

    /**
     * Get tanggal indonesia tanpa nama hari
     *
     * @param string $tanggal
     * @return string
     */
    public static function getTanggalIndo2($tanggal){
        $objDate = new \DateTime($tanggal);
        $hariIndo = config('app.hari_indo')[$objDate->format('w')];
        $bulanIndo = config('app.bulan')[$objDate->format('n')];
        return $objDate->format('d ') . $bulanIndo . ' ' . $objDate->format('Y');
    }
}