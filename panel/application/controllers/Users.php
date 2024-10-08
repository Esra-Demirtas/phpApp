<?php

class Users extends CI_Controller
{
    public  $viewFolder = "";
    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('user'))) {
            redirect(base_url("login"));
        }

        $this->viewFolder = "users_v";

        $this->load->model("user_model");

    }
    public function index()
    {
        $viewData = new stdClass();

        /**Tablodan verilerin getirilmesi**/
        $items = $this->user_model->get_all(
            array()
        );

        /**View'e gönderilecek değişkenlerin set edilmesi**/
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "list";
        $viewData->items = $items;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form()
    {

        $viewData = new stdClass();

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "add";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save()
    {

        $this->load->library("form_validation");

        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|is_unique[users.user_name]");
        $this->form_validation->set_rules("full_name", "Ad Soyad", "required|trim");
        $this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email|is_unique[users.email]");
        $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[8]|max_length[32]");

        $this->form_validation->set_message(
            array(
                //required'a ait bir hata meydana geldiğinde ilgili mesajı verecek.
                "required" => "{field} alanını doldurulmalıdır."
            )
        );

        $validate = $this->form_validation->run();

        if($validate) {

            //upload süreci
            $insert = $this->user_model->add(
                array(
                    "user_name"         => $this->input->post("user_name"),
                    "full_name"         => $this->input->post("full_name"),
                    "email"             => $this->input->post("email"),
                    "password"          => md5($this->input->post("password")),
                    "createdAt"         => date('Y-m-d H:i:s')
                )
            );

            //TODO Alert Sistemi Eklenecek
            if($insert){

                $alert = array(
                    "title" => "İşlem Başarılıdır.",
                    "text" => "Kayıt başarılı bir şekilde eklendi.",
                    "type" => "success"
                );

            }else{

                $alert = array(
                    "title" => "İşlem Başarısızdır.",
                    "text" => "Kayıt eklenemedi.",
                    "type" => "error"
                );
            }

            //İşlemin sonucunu session a yazma işlemi
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("users"));
        }else{

            $viewData = new stdClass();

            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder =  "add";
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $delete = $this->user_model->delete(
            array(
                "id"    => $id
            )
        );

        //TODO Alert Sistemi Eklenecek
        if($delete){
            $alert = array(
                "title" => "İşlem Başarılıdır.",
                "text" => "Kayıt başarılı bir şekilde silindi.",
                "type" => "success"
            );
        }else{
            $alert = array(
                "title" => "İşlem Başarısız.",
                "text" => "Kayıt silinemedi.",
                "type" => "error"
            );
        }

        $this->session->set_flashdata("alert", $alert);

        redirect(base_url("users"));
    }

    public function isActiveSetter($id)
    {
        if ($id){
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->user_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

    public function rankSetter()
    {

        $data = $this->input->post("data");

        parse_str($data, $order);

        $items = $order["ord"];

        //print_r($items);

        foreach ($items as $rank => $id){

            $this->user_model->update(
                array(
                    "id"        => $id,
                    "rank !="   => $rank
                ),
                array(
                    "rank"      => $rank
                )
            );
        }
    }

}