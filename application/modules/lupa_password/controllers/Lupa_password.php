<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Lupa_password extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('lupa_password_model');
        $this->load->library('wa');
    }

    //default action
    public function index()
    {
        if (is_logged_in()) {
            redirect(base_url());
        } else {
            $data['title'] = 'Lupa Password';
            $this->load->view('lupa_password/lupa_password', $data);
        }
    }

    public function save()
    {
        $error = '';
        $data['nik'] = $this->input->post('t_nik');
        $data['no_wa'] = $this->input->post('t_no_wa');

        if (!$data['nik'])
            $error .= '<p style="color: #d9534f;">NIK tidak boleh kosong, </p>';
        if (!$data['no_wa'])
            $error .= '<p style="color: #d9534f;">No WhatsApp belum diisi, </p>';

        if (!$error) {
            $new_password = trim($this->generatePassword(8)); // Hapus spasi/karakter aneh
            $tanggal =  date('Y-m-d H:i:s');
            $nik = $data['nik'];
            $no_telp = $data['no_wa'];
            $nChar = strlen($new_password) + 1;
            $hashed_password = $new_password;
            $x = 1;
            while ($x <= $nChar) {
                $hashed_password = md5($hashed_password);
                $x++;
            }

            $update = $this->lupa_password_model->update_password($nik, $new_password, $hashed_password, $no_telp, $tanggal);
            $send_wa = $this->lupa_password_model->post_wa_($nik, $no_telp, $new_password);
            // Here you would typically process the data, e.g., send a reset link via WhatsApp
            // For now, we will just simulate success
            $result = ['error' => ''];
        } else {
            $result = ['error' => $error];
        }

        echo json_encode($result);
    }

    private function generatePassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        $charLength = strlen($chars);

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, $charLength - 1)];
        }

        return $password;
    }
}
