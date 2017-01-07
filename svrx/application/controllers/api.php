<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/REST_Controller.php');
class Api extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->methods['login_get']['limit'] = 500;

	}

	public function getusers_get()
	{
		$data['users']=$this->user_model->get_users();
        $this->response($data, 201);
	}

	public function setusers_post()
	{
		$data = array(
		        'name' => $this->post('name'),
		        'type' => $this->post('type'),
		        'url' => $this->post('url'),
		        'username' => $this->post('username'),
		        'password' => $this->post('password')
		);
		$this->user_model->set_users($data);
		$this->response($data, 201);
	}

}
