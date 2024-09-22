<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <form action="<?php echo base_url("product/image_upload"); ?>" class="dropzone" data-plugin="dropzone">
                    <div class="dz-message">
                        <h3 class="m-h-lg">Yüklemek istediğiniz resimleri buraya sürükleyiniz.</h3>
                        <p class="m-b-lg text-muted">(Yüklemek istediğiniz dosyayı seçmek için tıklayınız.)</p>
                    </div>
                </form>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>

<div class="row">
    <div class="col-md-12">
        <h4 class="m-b-lg">
            <b><?php echo $item->title; ?></b> kaydına ait resimler
        </h4>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <table class="table table-striped table-bordered table-hover pictures_list">
                    <thead>
                        <th>#id</th>
                        <th>Görsel</th>
                        <th>Durumu</th>
                        <th>İşlem</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w100 text-center">#1</td>
                            <td class="w100 text-center">
                                <img width="30" src="https://avatars.githubusercontent.com/u/93264402?v=4" alt="" class="img-responsive">
                            </td>
                            <td>deneme-urunu.jpg</td>
                            <td class="w100 text-center">
                                <input
                                        data-url="<?php echo base_url("product/isActiveSetter"); ?>"
                                        class="isActive"
                                        type="checkbox"
                                        data-switchery
                                        data-color="#10c469"
                                    <?php echo (true) ? 'checked' : ''; ?>
                                />
                            </td>
                            <td class="w100 text-center">
                                <button data-url="<?php echo base_url("product/delete"); ?>" type="button" class="btn btn-sm btn-block btn-danger btn-outline remove-btn"><i class="fa fa-trash"></i> Sil</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>