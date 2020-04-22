<?php

class Database
{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '123';
    protected $name = 'db_kesiswaan';
    public $mysqli;

    public function bukaKoneksi()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);

        // Jika jika kode error bukan 0 berarti terjadi error
        if ($this->mysqli->connect_errno != 0) {
            $err = null;
            $err .= 'Kode Error : ' . $this->mysql->connect_errno . '<br>';
            $err .= 'Deskripsi : ' . $this->mysql->connect_error;
        }
    }

    public function tutupKoneksi()
    {
        $this->mysqli->close();
    }

    public function cekError()
    {
        return $this->mysqli->error;
    }
}
