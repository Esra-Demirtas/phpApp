<?php

class Brands extends CI_Controller
{
    public  $viewFolder = "";
    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "brands_v";

        $this->load->model("brand_model");

    }
    public function index()
    {
        $viewData = new stdClass();

        /**Tablodan verilerin getirilmesi**/
        $items = $this->brand_model->get_all(
            array(), "rank ASC"
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
        //Kurallar yazılır. Daha sonra form validation çalıştırılır. Başarılı ise kayıt işlemi başlar başarısız ise hata mesajı sayfada görünür.

        if ($_FILES["img_url"]["name"] == ""){

            $alert = array(
                "title" => "İşlem Başarısız.",
                "text" => "Lütfen bir görsel seçiniz.",
                "type" => "error"
            );

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("brands/new_form"));

            die();
        }

        $this->form_validation->set_rules("title", "Başlık", "required|trim");

        $this->form_validation->set_message(
            array(
                //required'a ait bir hata meydana geldiğinde ilgili mesajı verecek.
                "required" => "{field} alanını doldurulmalıdır."
            )
        );

        $validate = $this->form_validation->run();

        if($validate){

            //upload süreci

            $file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

            $config["allowed_types"] = "gif|jpg|png|jpeg";
            $config["upload_path"] = "uploads/$this->viewFolder/";
            $config["file_name"] = $file_name;

            $this->load->library("upload", $config);

            $upload = $this->upload->do_upload("img_url");

            if($upload){

                $uploaded_file = $this->upload->data("file_name");

                $insert = $this->brand_model->add(
                    array(
                        "title"         => $this->input->post("title"),
                        "img_url"       => "$uploaded_file",
                        "rank"          => 0,
                        "isActive"      => 1,
                        "createdAt"     => date('Y-m-d H:i:s')
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
            } else {

                $alert = array(
                    "title" => "İşlem Başarısızdır.",
                    "text" => "Görsel yüklenemedi.",
                    "type" => "error"
                );

                $this->session->set_flashdata("alert", $alert);

                redirect(base_url("brands/new_form"));

            }

            //İşlemin sonucunu session a yazma işlemi
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("brands"));

        }else{

            $viewData = new stdClass();

            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder =  "add";
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function update_form($id)
    {

        $viewData = new stdClass();

        /**Tablodan verilerin getirilmesi**/
        $item = $this->brand_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "update";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update($id)
    {

        $this->load->library("form_validation");
        //Kurallar yazılır. Daha sonra form validation çalıştırılır. Başarılı ise kayıt işlemi başlar başarısız ise hata mesajı sayfada görünür.

        $this->form_validation->set_rules("title", "Başlık", "required|trim");

        $this->form_validation->set_message(
            array(
                //required'a ait bir hata meydana geldiğinde ilgili mesajı verecek.
                "required" => "{field} alanını doldurulmalıdır."
            )
        );

        $validate = $this->form_validation->run();

        if($validate){

            //upload süreci

            if($_FILES["img_url"]["name"] !== ""){

                $file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

                $config["allowed_types"] = "gif|jpg|png|jpeg";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("img_url");

                if($upload){

                    $uploaded_file = $this->upload->data("file_name");

                    $data = array(
                        "title"         => $this->input->post("title"),
                        "description"   => $this->input->post("description"),
                        "url"           => convertToSEO($this->input->post("title")),
                        "img_url"       => "$uploaded_file",
                    );
                } else {

                    $alert = array(
                        "title" => "İşlem Başarısızdır.",
                        "text" => "Görsel yüklenemedi.",
                        "type" => "error"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("brands/update_form/$id"));

                    die();

                }
            } else {
                $data = array(
                    "title"         => $this->input->post("title"),
                    "description"   => $this->input->post("description"),
                    "url"           => convertToSEO($this->input->post("title")),
                );
            }

            $update = $this->brand_model->update(
                array(
                    "id" => $id
                ),
                    $data
            );

            //TODO Alert Sistemi Eklenecek
            if($update){

                $alert = array(
                    "title" => "İşlem Başarılıdır.",
                    "text" => "Kayıt başarılı bir şekilde güncellendi.",
                    "type" => "success"
                );

            }else{

                $alert = array(
                    "title" => "İşlem Başarısızdır.",
                    "text" => "Kayıt güncellenemedi.",
                    "type" => "error"
                );
            }

            //İşlemin sonucunu session a yazma işlemi
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("brands"));

        }else{

            $viewData = new stdClass();

            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder =  "update";
            $viewData->form_error = true;

            $viewData->item = $this->brand_model->get(
                array(
                    "id" => $id
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $delete = $this->brand_model->delete(
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

        redirect(base_url("brands"));
    }

    public function isActiveSetter($id)
    {
        if ($id){
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->brand_model->update(
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

            $this->brand_model->update(
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