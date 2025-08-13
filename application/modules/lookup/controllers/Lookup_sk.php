<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookup_sk extends MY_Controller {
      function __construct(){
            parent::__construct();
            $this->load->model('lookup/lookup_sk_model');
            $this->load->helper(array('url','download'));	
            $this->load->library('session');
            $this->load->helper("general_helper");
            $this->load->library('wa');
      }

      public function pilih_sk(){
            $list = $this->lookup_sk_model->get_datatables_list_sk();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $list_sk) {
                  $pilih = '
                  <a href="javascript:void(0);" onclick="pilih_sk(\''.$list_sk->id_sk.'\', \''.$list_sk->nomor_sk.'\', \''.$list_sk->judul_sk.'\')" title="Detail \''.$list_sk->judul_sk.'\'"><i class="fas fa-check"> Pilih</i></a>
                  ';
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $list_sk->nomor_sk;
                  $row[] = $list_sk->judul_sk;
                  $row[] = $pilih;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->lookup_sk_model->count_all_list_sk(),
                  "recordsFiltered" => $this->lookup_sk_model->count_filtered_list_sk(),
                  "data" => $data,
            );
            echo json_encode($output);
      }

      
}