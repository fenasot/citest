<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Welcome extends CI_Controller
{

	public function index()
	{

		$data = array(
			'title' => "Welcome to the summoner's rift",
			'content' => "Thirty seconds until minions spawn",
		);

		$this->smarty_library->assign($data);
		$this->smarty_library->display('welcome_message.php');

	}
}
