<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	//default action
	public function index()
	{
		if (is_logged_in()) {
			redirect(base_url());
		} else {
			$data['title'] = 'Login';
			$this->load->view('login/login_form', $data);
		}
	}

	function signin()
	{
		//$ip = $this->input->post('ip_client');
		//$comp = $this->computer_model->ip_check($ip);
		$comp['allow_access'] = true;
		if (!$comp['allow_access']) {
			$result['error'] = 'Check Jaringan Anda';
			echo json_encode($result);
		} else {
			$error = '';
			$data['username'] = $this->input->post('t_username');
			$data['password'] = $this->input->post('t_password');
			// $data['captcha_response'] = $this->input->post('g-recaptcha-response');

			if (!$data['username'])
				$error .= '<p style="color: #d9534f;">Username tidak boleh kosong, </p>';
			if (!$data['password'])
				$error .= '<p style="color: #d9534f;">Password belum diisi, </p>';
			// if (!$this->input->post('g-recaptcha-response')) {
			// 	$error .= '<p style="color: #d9534f;">Harap verifikasi reCAPTCHA!</p>';
			// }

			if (!$error) {
				// $captcha = $this->input->post('g-recaptcha-response');
				// $secret_key = "6LcZN9IqAAAAAFloffyA8ZomVF6hMuFJL1czqFLv";
				// $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$captcha}";
				// $verify_response = file_get_contents($verify_url);

				// if ($verify_response === false) {
				// 	$error .= '<p style="color: #d9534f;">Gagal menghubungi server reCAPTCHA.</p>';
				// } else {
				// 	$response_data = json_decode($verify_response);
				// 	if (!$response_data->success) {
				// 		$error .= '<p style="color: #d9534f;">Verifikasi reCAPTCHA gagal!</p>';
				// 	} else {
				$this->load->library('auth');
				$return = $this->auth->do_login($data);
				if ($return) {
					$error = '';
				} else {
					$error = '<p style="color: #d9534f;">Username atau password anda salah</p>';
				}
				// 	}
				// }
			}

			// if (!$error)
			// {

			// }
			$result['error'] = $error;
			echo json_encode($result);
		}
	}

	function signout()
	{
		$this->auth->logout();
		redirect(site_url());
	}
	function autorize($ip)
	{
		//echo $ip;
		$comp = $this->computer_model->ip_check($ip);
		//echo $comp['id_computer'];
		if ($comp['allow_absent']) {
			$data = array();
			$this->load->view('login_absensi_button', $data);
		}
	}

	public function captcha()
	{
		$secretKey = "6Lefos0qAAAAAOtkvBffS18rwNLbvOW9MfVQ2Z2E";
		$recaptchaResponse = isset($_POST["recaptcha_response"]) ? $_POST["recaptcha_response"] : "";

		$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
		$data = "secret=" . $secretKey . "&response=" . $recaptchaResponse;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $verifyUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		curl_close($ch);

		$responseData = json_decode($result);

		if ($responseData && isset($responseData->success) && $responseData->success && isset($responseData->score) && $responseData->score >= 0.5) {
			echo "reCAPTCHA valid! (Score: " . $responseData->score . ")";
		} else {
			echo "reCAPTCHA gagal! (Score: " . (isset($responseData->score) ? $responseData->score : "N/A") . ")";
		}
	}
}

/*
*Author: Rickytarius
*Author URL: http://www.bayssl.com
28052016
*/
