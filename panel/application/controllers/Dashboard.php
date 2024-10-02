<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('user'))) {
            redirect(base_url("login"));
        }
        $this->viewFolder = "dashboard_v";
    }
	public function index()
	{
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";

		$this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
	}
}
