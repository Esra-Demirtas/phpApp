<div class="row">
    <div class="col-md-12">
        <h4 class="m-b-lg">
            Yeni Kullanıcı Ekle
        </h4>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <form action="<?php echo base_url("users/save"); ?>" method="post">
                    <div class="form-group">
                        <label>Kullanıcı Adı</label>
                        <input class="form-control" placeholder="Kullanıcı Adı" name="user_name">
                        <?php if (isset($form_error)) { ?>
                            <small class="input-form-error"> <?php echo form_error("user_name"); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input class="form-control" placeholder="Ad Soyad" name="full_name">
                        <?php if (isset($form_error)) { ?>
                            <small class="input-form-error"> <?php echo form_error("full_name"); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>E-posta</label>
                        <input class="form-control" type="email" placeholder="E-posta" name="email">
                        <?php if (isset($form_error)) { ?>
                            <small class="input-form-error"> <?php echo form_error("email"); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Şifre</label>
                        <input class="form-control" type="password" placeholder="Şifre" name="password">
                        <?php if (isset($form_error)) { ?>
                            <small class="input-form-error"> <?php echo form_error("password"); ?></small>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-md btn-outline">Kaydet</button>
                    <a href="<?php echo base_url("users"); ?>" class="btn btn-md btn-danger btn-outline">İptal</a>
                </form>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>