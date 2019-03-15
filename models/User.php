<?php

namespace app\models;

class User extends base\User implements \yii\web\IdentityInterface
{
    private $token_salt = "po&&*@(__";
    public static function findIdentity($id)
    {
        return User::find()->where(array("id" => $id))->one();
    }
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        return null;
    }
    public static function findByUsername($username)
    {
        return User::find()->where(array("username" => $username))->one();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return null;
    }
    public function validateAuthKey($authKey)
    {
        return FALSE;
    }
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    public function fields()
    {
        return array("id", "username", "nama" => function ($model) {
            return $model->name;
        }, "token" => function ($model) {
            return md5($this->token_salt . $model->id);
        }, "kode", "name", "role_id", "role_name" => function ($model) {
            return $this->role->name;
        }, "photo_url", "jaringan_id", "token", "alamat", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "kodepos", "no_telpon", "email", "tempat_lahir", "tanggal_lahir", "agama", "jenis_kelamin", "pendidikan", "tanggal_masuk", "tanggal_keluar", "is_on_duty", "pit_id", "last_login", "last_logout");
    }
    public function generateToken()
    {
        $this->token = md5($this->token_salt . $this->id);
    }
    public function isAbsensiHariIni()
    {
        $absen = Absensi::find()->where(array("jaringan_id" => Jaringan::getCurrentID(), "karyawan_id" => $this->id, "date(jam_masuk)" => date("Y-m-d")))->one();
        return $absen != null;
    }
    public function getKodeNama()
    {
        return $this->kode . " - " . $this->name;
    }
    public static function getCurrentID()
    {
        return \Yii::$app->user->id;
    }
    public static function getCurrentActive()
    {
        return User::find()->where(array("jaringan_id" => Jaringan::getCurrentID()))->andWhere("role_id != 1")->all();
    }
    public static function getNotBusyUsers()
    {
        $notBusy = array();
        $users = User::find()->where(array("jaringan_id" => Jaringan::getCurrentID(), "is_on_duty" => 0, "role_id" => 6))->all();
        foreach ($users as $user) {
            if ($user->isAbsensiHariIni()) {
                $notBusy[] = $user;
            }
        }
        return $notBusy;
    }
    public static function getAuthorizedUsers()
    {
        return User::find()->where(array("jaringan_id" => Jaringan::getCurrentID(), "role_id" => array(2, 3)))->all();
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("kode" => $kode))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return null;
    }
    public static function findIdByNama($nama)
    {
        if ($nama == "") {
            return self::getCurrentID();
        }
        $kGroup = self::find()->where("name like '" . $nama . "%'")->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return self::getCurrentID();
    }
    public static function getFrontDesk()
    {
        $activeFrontdesk = null;
        $frontdesks = User::find()->where(array("role_id" => Role::FRONT_DESK, "jaringan_id" => Jaringan::getCurrentID()))->all();
        foreach ($frontdesks as $frontdesk) {
            if ($frontdesk->isAbsensiHariIni()) {
                $activeFrontdesk = $frontdesk;
                break;
            }
        }
        if ($activeFrontdesk == null) {
            $activeFrontdesk = \Yii::$app->user->identity;
        }
        return $activeFrontdesk;
    }
    public static function getKasir()
    {
        $activeKasir = null;
        $kasirs = User::find()->where(array("role_id" => Role::KASIR, "jaringan_id" => Jaringan::getCurrentID()))->all();
        foreach ($kasirs as $kasir) {
            if ($kasir->isAbsensiHariIni()) {
                $activeKasir = $kasir;
                break;
            }
        }
        if ($activeKasir == null) {
            $activeKasir = \Yii::$app->user->identity;
        }
        return $activeKasir;
    }
}

?>