<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title><?=APPNAME?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
        <link href="<?=base_url()?>assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- App css -->
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <?php
            if(isset($gcrud)){
                if($gcrud==1){
                    foreach ($css_files as $key) {
                        ?>
                        <link href="<?=$key?>" rel="stylesheet" type="text/css" />
                        <?php
                    }
                }
            }
        ?>
        <!-- Vendor js -->
        <script type="text/javascript" src="<?=base_url();?>assets/js/jszip.js"></script>
        <script type="text/javascript" src="<?=base_url();?>assets/js/xlsx.js"></script>
        <script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <!-- init js -->
        <script src="<?=base_url()?>assets/libs/moment/moment.min.js"></script>
        <script src="<?=base_url()?>assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?=base_url()?>assets/js/pages/form-pickers.custom.js"></script>
        
    </head>
    <body>
        <div id="preloader">
            <div id="status">
                <div class="bouncingLoader"><div ></div><div ></div><div ></div></div>
            </div>
        </div>
        <?php $this->load->view("layout/header",isset($menu)?$menu:array()); ?>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <?php
                                        if(isset($breadcrumb)){
                                            foreach ($breadcrumb as $key=>$value) {
                                                ?>
                                                 <li class="breadcrumb-item <?=$value?>"><?=$key?></li>
                                                <?php
                                            }
                                        }
                                    ?>

                                </ol>
                            </div>
                            <?php
                                if(isset($content_title)){
                                    ?>
                                        <h4 class="page-title"><?=$content_title?></h4>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="globalmodal" tabindex="-1" role="dialog" aria-labelledby="modaljudul" aria-hidden="true">
                  <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="globalmodaljudul"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                      </div>
                      <div class="modal-footer">

                      </div>
                    </div>
                  </div>
                </div>
                <!-- end page title -->
                <?php
                if(isset($gcrud)){
                    if($gcrud==1){
                      $var_module['output']=$output;
                      $this->load->view("module/".$module,isset($var_module)?$var_module:array());
                    }else if(isset($module)){
                        $this->load->view("module/".$module,isset($var_module)?$var_module:array());
                    }else{
                        $this->load->view("module/dashboard");
                    }
                }else if(isset($module)){
                    $this->load->view("module/".$module,isset($var_module)?$var_module:array());
                }else{
                    $this->load->view("module/dashboard");
                }
                ?>
            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
        <!-- Footer Start -->
        <?php $this->load->view("layout/footer",isset($footer)?$footer:array()); ?>
        <!-- end Footer -->
        <?php if(rightbar){$this->load->view("layout/rightbar");} ?>
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- App js -->
        <script src="<?=base_url()?>assets/js/pages/custom.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
        <?php
            if(isset($gcrud)){
                if($gcrud==1){
                    foreach ($js_files as $key) {
                        ?>
                        <script src="<?=$key?>"></script>
                        <?php
                    }
                }
            }
        ?>
    </body>
</html>
