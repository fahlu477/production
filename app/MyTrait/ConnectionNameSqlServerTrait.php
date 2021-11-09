<?php

namespace App\MyTrait;

trait ConnectionNameSqlServerTrait {
    public static function getConnStaff(){
        return 'tna_staff';
    }

    public static function getConnProd(){
        return 'tna_produksi';
    }

    public static function getConnStaffMaja(){
        return 'tna_maja_staff';
    }

    public static function getConnProdMaja(){
        return 'tna_maja_produksi';
    }
}