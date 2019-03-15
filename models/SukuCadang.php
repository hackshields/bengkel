<?php

namespace app\models;

class SukuCadang extends base\SukuCadang
{
    public function fields()
    {
        return array("id", "kode", "nama", "nama_sinonim", "harga_beli" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->harga_beli;
            }
            return 0;
        }, "harga_jual" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->harga_jual;
            }
            return 0;
        }, "het", "hpp" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->hpp;
            }
            return 0;
        }, "quantity" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->quantity;
            }
            return 0;
        }, "quantity_max" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->quantity_max;
            }
            return 0;
        }, "quantity_min" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->quantity_min;
            }
            return 0;
        }, "quantity_order" => function ($model) {
            $jml = 0;
            $pos = PurchaseOrder::find()->where(array("jaringan_id" => Jaringan::getCurrentID(), "purchase_order_status_id" => 2))->all();
            foreach ($pos as $po) {
                foreach ($po->purchaseOrderDetails as $detail) {
                    if ($detail->suku_cadang_id == $model->id) {
                        $jml++;
                    }
                }
            }
            return $jml;
        }, "gudang_id" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->gudang_id;
            }
            return "";
        }, "gudang_nama" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj && $scj->gudang) {
                return $scj->gudang->nama;
            }
            return "-";
        }, "rak_id" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->rak_id;
            }
            return "";
        }, "rak_nama" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj && $scj->rak) {
                return $scj->rak->nama;
            }
            return "-";
        }, "opname_terakhir" => function ($model) {
            $scj = $model->getSukuCadangJaringan();
            if ($scj) {
                return $scj->opname_terakhir;
            }
            return "-";
        }, "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-sukucadang-gunakan", "data_id" => $model->id));
        }, "add_action" => function ($model) {
            return \yii\helpers\Html::button("Tambahkan", array("class" => "btn-sukucadang-add", "data_id" => $model->id));
        });
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = SukuCadang::find()->where(array("kode" => $kode))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return null;
    }
    public function getSukuCadangJaringan()
    {
        $scj = SukuCadangJaringan::find()->where(array("suku_cadang_id" => $this->id, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($scj == null) {
            $sc = new SukuCadangJaringan();
            $sc->suku_cadang_id = $this->id;
            $sc->jaringan_id = Jaringan::getCurrentID();
            $sc->quantity = 0;
            $sc->quantity_booking = 0;
            $sc->quantity_max = 0;
            $sc->quantity_min = 0;
            $sc->save();
        }
        return $scj;
    }
    public function prosesHet()
    {
        $all = PenerimaanPartDetail::find()->joinWith(array("penerimaanPart" => function ($query) {
            $query->orderBy("tanggal_penerimaan")->where(array("penerimaan_part.jaringan_id" => Jaringan::getCurrentID(), "status_spg_id" => StatusSpg::CLOSE));
        }))->where(array("suku_cadang_id" => $this->id))->all();
        $total = 0;
        $jumlah = 0;
        foreach ($all as $detail) {
            $total += $detail->harga_beli * $detail->quantity_supp;
            $jumlah += $detail->quantity_supp;
        }
        if ($jumlah != 0) {
            $sc = $this->getSukuCadangJaringan();
            $sc->hpp = $total / $jumlah;
            $sc->save();
        }
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
            $this->updated_by = \Yii::$app->user->id;
        }
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>