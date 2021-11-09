<?php

namespace App\MyTrait;

/**
 * Export CSV
 */
trait ExportCSVTrait
{
    /**
     * header export csv
     *
     * @param [type] $callback
     * @param [type] $filename
     */
    public static function export($callback, $filename){
        $headers = array(
            "Content-type" => "text/csv",
            // "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        return response()->streamDownload($callback, $filename.'.csv',$headers);
    }

    /**
     * Call back export 
     * 
     * Diperuntukan untuk backup (data utuh seperti table kecuali nama kolom ada kostum)
     * 
     * @param array $records
     * 
     * @return anonymous function
     */
    public static function callbackSeluruhData($records)
    {
        $cb = function () use (&$records) {
            // create file
            $file = fopen('php://output', 'w');
            // get column
            $columns = array_keys(json_decode(json_encode($records[0] ?? []), true));
            // write column
            fputcsv($file, $columns);
            // masukan nilai per fieldnya
            foreach ($records as $record) {
                $valueOfFields = [];
                foreach ($record as $field => $value) {
                    array_push($valueOfFields, $value);
                }
                fputcsv($file, $valueOfFields);
            }
            // close file
            fclose($file);
        };

        return $cb;
    }
}
