<?php

namespace app\models;

class ViewKpb extends base\ViewKpb
{
    public function fields()
    {
        return array("pkb_id", "tanggal_service", "tanggal_service_date" => function ($model) {
            return date("Y-m-d", strtotime($model->tanggal_service));
        }, "no_pkb", "konsumen_id", "no_mesin", "no_rangka", "nopol", "motor_id", "motor_kode", "motor_nama", "tanggal_beli", "kpb_id", "kpb_nama", "km", "kpb_data" => function ($model) {
            $pkb = PerintahKerja::find()->where(array("id" => $model->pkb_id))->one();
            foreach ($pkb->notaJasas as $notaJasa) {
                foreach ($notaJasa->notaJasaDetails as $notaJasaDetail) {
                    if ($notaJasaDetail->jasa->jasa_group_id == JasaGroup::ASS1) {
                        return "ASS1";
                    }
                    if ($notaJasaDetail->jasa->jasa_group_id == JasaGroup::ASS2) {
                        return "ASS2";
                    }
                    if ($notaJasaDetail->jasa->jasa_group_id == JasaGroup::ASS3) {
                        return "ASS3";
                    }
                    if ($notaJasaDetail->jasa->jasa_group_id == JasaGroup::ASS4) {
                        return "ASS4";
                    }
                }
            }
            return "";
        });
    }
}

?>