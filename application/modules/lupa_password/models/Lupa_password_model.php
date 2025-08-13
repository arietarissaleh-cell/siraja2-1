<?php

class Lupa_password_model extends Base_Model
{

    function __construct()
    {

        parent::__construct();
        $this->set_schema('public');
        $this->set_table('dtl_keluhan_pelanggan');
        $this->set_pk('id_keluhan');
        $this->set_log(true);
    }




    function update_password($nik, $new_password, $hashed_password, $no_telp, $tanggal)
    {
        $data = array(
            'pwd' => $hashed_password,
            'no_wa' => $no_telp,
            'tanggal_reset' => $tanggal

        );
        $this->db->where("nik", $nik);
        $approve = $this->db->update("public.ms_operator_sdm", $data);
        return $approve;
    }

    public function post_wa_($nik, $no_telp, $new_password)
    {
        $query_data_penerima = $this->db->query(
            "SELECT
			tbl.*
			FROM ms_operator_sdm tbl
			where tbl.nik= '" . $nik . "' 
			"
        );



        foreach ($query_data_penerima->result() as $row) {
            $username            = $row->username;
            $message_anggaan = "Anda Telah Berhasil Me-Reset Password anda dengan rincian sebagai berikut:
			Username      : *$username*
			Password Baru : *$new_password* 
			Password dan Username tersebut dapat di gunakan di semua aplikasi PT PG RAJAWALI II 
			";
            $telp_kry = $no_telp;
            if ($telp_kry <> null && $telp_kry <> 0) {
                //$send_to_admin = $this->wa->send_text_now($telp_kry,$message_anggaan); 
                $send_to_admin = $this->wa->send_text_now($telp_kry, $message_anggaan);
            }
        }
    }
}
