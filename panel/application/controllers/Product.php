<?php

class Product extends CI_Controller
{
    public  $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('user'))) {
            redirect(base_url("login"));
        }
        $this->viewFolder = "product_v";

        $this->load->model("product_model");

        $this->load->model("product_image_model");
    }
    public function index()
    {
        $viewData = new stdClass();

        /**Tablodan verilerin getirilmesi**/
        $items = $this->product_model->get_all(
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

        $this->form_validation->set_rules("title", "Başlık", "required|trim");

        $this->form_validation->set_message(
            array(
                //required'a ait bir hata meydana geldiğinde ilgili mesajı verecek.
                "required" => "{field} alanını doldurulmalıdır."
            )
        );

        $validate = $this->form_validation->run();

        if($validate){
            $insert = $this->product_model->add(
                array(
                    "title"         => $this->input->post("title"),
                    "description"   => $this->input->post("description"),
                    "url"           => convertToSEO($this->input->post("title")),
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

            //İşlemin sonucunu session a yazma işlemi
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("product"));


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
        $item = $this->product_model->get(
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
            $update = $this->product_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "title"         => $this->input->post("title"),
                    "description"   => $this->input->post("description"),
                    "url"           => convertToSEO($this->input->post("title")),
                )
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
                    "title" => "İşlem Başarısız.",
                    "text" => "Kayıt güncellenemedi.",
                    "type" => "error"
                );
            }

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("product"));

        }else{
            $viewData = new stdClass();

            /**Tablodan verilerin getirilmesi**/
            $item = $this->product_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder =  "update";
            $viewData->form_error = true;
            $viewData->item = $item;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id)
    {
        $delete = $this->product_model->delete(
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

        redirect(base_url("product"));
    }

    public function imageDelete($id, $parent_id)
    {
        $fileName = $this->product_image_model->get(
            array(
                "id"    => $id
            )
        );

        $delete = $this->product_image_model->delete(
            array(
                "id"    => $id
            )
        );

        //TODO Alert Sistemi Eklenecek
        if($delete){

            unlink("uploads/{$this->viewFolder}/$fileName->img_url");

            redirect(base_url("product/image_form/$parent_id"));
        } else {
            redirect(base_url("product/image_form/$parent_id"));
        }
    }

    public function isActiveSetter($id)
    {
        if ($id){
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->product_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

    public function imageIsActiveSetter($id)
    {
        if ($id){
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->product_image_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

    public function isCoverSetter($id, $parent_id)
    {
        if ($id && $parent_id){
            $isCover = ($this->input->post("data") === "true") ? 1 : 0;

            //Kapak olması istenen resim
            $this->product_image_model->update(
                array(
                    "id"            => $id,
                    "product_id"    => $parent_id
                ),
                array(
                    "isCover"       => $isCover
                )
            );

            //Kapak olması istenmeyen diğer resimler
            $this->product_image_model->update(
                array(
                    "id !="         => $id,
                    "product_id"    => $parent_id
                ),
                array(
                    "isCover"       => 0
                )
            );
        }

        $viewData = new stdClass();

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "image";

        $viewData->item_images = $this->product_image_model->get_all(
            array(
                "product_id" => $parent_id
            ), "rank ASC"
        );

        $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/image_list_v", $viewData, true);

        echo $render_html;
    }

    public function rankSetter()
    {

        $data = $this->input->post("data");

        parse_str($data, $order);

        $items = $order["ord"];

        //print_r($items);

        foreach ($items as $rank => $id){

            $this->product_model->update(
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

    public function imageRankSetter()
    {

        $data = $this->input->post("data");

        parse_str($data, $order);

        $items = $order["ord"];

        //print_r($items);

        foreach ($items as $rank => $id){

            $this->product_image_model->update(
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

    public function image_form($id)
    {
        $viewData = new stdClass();

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "image";

        $viewData->item = $this->product_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_images =  $this->product_image_model->get_all(
            array(
                "product_id" => $id
            ), "rank ASC"
        );

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function image_upload($id){

        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $config["allowed_types"] = "gif|jpg|png|jpeg";
        $config["upload_path"] = "uploads/$this->viewFolder/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);

        $upload = $this->upload->do_upload("file");

        if($upload){

            $uploaded_file = $this->upload->data("file_name");

            $this->product_image_model->add(
                array(
                    "img_url"        => $uploaded_file,
                    "rank"           => 0,
                    "isActive"       => 1,
                    "isCover"        => 0,
                    "createdAt"      => date("Y-m-d H:i:s"),
                    "product_id"     => $id
                )
            );
        } else {
            echo "işlem başarısız";
        }
    }

    public function refresh_image_list($id)
    {
        $viewData = new stdClass();

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder =  "image";

        $viewData->item_images = $this->product_image_model->get_all(
            array(
                "product_id" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/image_list_v", $viewData, true);

        echo $render_html;

    }

}