<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wa {

	public function __construct(){
        $this->_ci = &get_instance(); // Set variabel _ci dengan Fungsi2-fungsi dari Codeigniter
       
    }
	
	public function send_text($number,$message){
		date_default_timezone_set('Asia/Jakarta');
		
		$jadwal = date("Y-m-d h:i:sa");
		
		$api_key='ff793cd04db6d34a3986b4b7208dce449512533b';
		
		try{
		
			$data = [
				'nomor'  => $number,
				'msg' => $message,
				'jadwal' => $jadwal
			];

			$curl = curl_init();
			curl_setopt_array($curl, array(
			  //CURLOPT_URL => "http://103.140.207.233:3334/api/send.php?key=".$api_key,
			  CURLOPT_URL => "http://e-siraja.rajawali2.co.id/wa_api/api/send_jadwal.php?key=".$api_key,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data))
			);

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
		
		}catch(Exception $e){
			
			$response = array('status'=>'Gagal', 'message'=>'Notif WA gagal dikirim');
			//echo $response;
		}
	
	
		
	}
	
	
	public function send_text_now($number,$message){
		date_default_timezone_set('Asia/Jakarta');
		
		$jadwal = date("Y-m-d h:i:sa");
		
		$api_key='ff793cd04db6d34a3986b4b7208dce449512533b';
		
		try{
		
			$data = [
				'nomor'  => $number,
				'msg' => $message
			];

			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://e-siraja.rajawali2.co.id/wa_api/api/send.php?key=".$api_key,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data))
			);

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
		
		}catch(Exception $e){
			
			$response = array('status'=>'Gagal', 'message'=>'Notif WA gagal dikirim');
			//echo $response;
		}
	
	
		
	}
	
	 
	public function send_media($number,$message){
		
		$api_key='ff793cd04db6d34a3986b4b7208dce449512533b';
		
		try{
		
			$data = [
			'nomor'  => $number,
			'msg' => $message,
			'url' => 'Link gambar/pdf'];

			$curl = curl_init();
			curl_setopt_array($curl, array(
			   CURLOPT_URL => "http://e-siraja.rajawali2.co.id/wa_api/api/send.php?key=".$api_key,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($data))
			);

			$response = curl_exec($curl);

			curl_close($curl);
			echo $response;
			
		}catch(Exception $e){
			
			$response = array('status'=>'Gagal', 'message'=>'Notif WA gagal dikirim');
			echo $response;
		}

	}	 
	 
	function send_wa_webhook($tanggal,$id_pb){
		
		$api_key='ff793cd04db6d34a3986b4b7208dce449512533b';
		
		try{
			
			// ------------------------------------------------------------------//
			header('content-type: application/json');
			$data = json_decode(file_get_contents('php://input'), true);
			file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
			$message = $data['message']; // ini menangkap pesan masuk
			$from = $data['from']; // ini menangkap nomor pengirim pesan


			if (strtolower($message) == 'hai') {
				$result = [
					'mode' => 'chat', // mode chat = chat biasa
					'pesan' => 'Hai juga'
				];
			} else if (strtolower($message) == 'hallo') {
				$result = [
					'mode' => 'reply', // mode reply = reply pessan
					'pesan' => 'Halo juga'
				];
			} else if (strtolower($message) == 'gambar') {
				$result = [
					'mode' => 'picture', // type picture = kirim pesan gambar
					'data' => [
						'caption' => '*webhook picture*',
						'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ2Ox4zgP799q86H56GbPMNWAdQQrfIWD-Mw&usqp=CAU'
					]
				];
			}

			print json_encode($result);
		
		}catch(Exception $e){
			
			$response = array('status'=>'Gagal', 'message'=>'Notif WA gagal dikirim');
			echo $response;
		}
		
		
	}
	 
	
	
}