<?php

namespace app\models;

class SukuCadangMaster extends SukuCadang
{
    public function fields()
    {
        return array("id", "kode", "kode_plasa", "nama", "nama_sinonim", "suku_cadang_group_id", "suku_cadang_kategori_id", "group_nama" => function ($model) {
            return $model->sukuCadangGroup->nama;
        }, "kategori_nama" => function ($model) {
            return $model->sukuCadangKategori->nama;
        }, "merek_id", "fs", "import", "rank", "lifetime", "fungsi", "het", "kode_promosi", "dimensi_panjang", "dimensi_lebar", "dimensi_tinggi", "dimensi_berat", "foto", "status", "created_at", "updated_at", "created_by", "updated_by");
    }
}

?>