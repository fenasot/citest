<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }

    public function index()
    {
        // TODO: It's OK. But warn still continue.
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';
        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }
    public function view($slug = NULL)
    {
        // TODO: It's OK. But warn still continue.
        $data['news_item'] = $this->news_model->get_news($slug);
        if (empty($data['news_item'])) {
            show_404();
        }
        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';
        // TODO: It's OK. But warn still continue.
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'text', 'required');
        // TODO: It's OK. But warn still continue.
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');
        } else {
            // TODO: It's OK. But warn still continue.
            $this->news_model->set_news();
            $this->load->view('news/success');
        }
    }
}
