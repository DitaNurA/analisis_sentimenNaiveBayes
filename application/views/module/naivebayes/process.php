<?php
include("./nbtc-lib/vendor/autoload.php");
$stopwords = array("der", "die", "das", "the");
// escape the stopword array and implode with pipe
$s = '~^\W*('.implode("|", array_map("preg_quote", $stopwords)).')\W+\b|\b\W+(?1)\W*$~i';
$options['tokenizer'] = function($text) use ($s) {
        $text = mb_strtolower($text);
       // remove stop words
       $text = preg_replace($s, '', $text);
       // split the words
       preg_match_all('/[[:alpha:]]+/u', $text, $matches);
       // first match list of words
       return $matches[0];
};
$classifier = new \Niiknow\Bayes($options);
?>
<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box">
            <!-- Left sidebar -->
            <div class="inbox-leftbar">
                <a href="#" class="btn btn-danger btn-block waves-effect waves-light">Analisis Sentimen Menu</a>
                <div class="mail-list mt-4">
                    <a href="<?=base_url()?>NaiveBayes/process/dataset" class="list-group-item border-0 <?=$page=='dataset'?'font-weight-bold':'';?>">Dataset Sentimen</a> <hr>
                    <a href="<?=base_url()?>NaiveBayes/process/init" class="list-group-item border-0 <?=$page=='init'?'font-weight-bold':'';?>">Proses Data</a> <hr>
                    <a href="<?=base_url()?>NaiveBayes/process/performance" class="list-group-item border-0 <?=$page=='performance'?'font-weight-bold':'';?>">Klasifikasi dan Uji Data</a> <hr>
                    <a href="<?=base_url()?>NaiveBayes/process/prediksi" class="list-group-item border-0 <?=$page=='prediksi'?'font-weight-bold':'';?>">Uji Sentimen Baru</a> <hr>
                </div>
            </div>
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
            <?php
                //Dataset
                if($page == 'dataset'){
                ?>
                <div class="col-md-12">
                    <?php
                    $index = array("response","label");
                    $dataset = $this->db->get("dataset")->result_array();
                        if(sizeof($index)>0 && sizeof($dataset)>0){
                    ?>
                    <div class="card-box">
                      <h4>Dataset Analisis Sentimen</h4>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dataset as $key) {
                                ?>
                                <tr>
                                    <?php
                                     foreach ($index as $keys) {
                                        ?>
                                            <td><?=$key[$keys]?></td>
                                        <?php
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } ?>
                  </div>
                <?php
                }
                if($page == 'init'){
                    ?>
                     <?php
                     $index = array("response","label");
                     $dataset = $this->db->get("dataset")->result_array();
                         if(sizeof($index)>0 && sizeof($dataset)>0){
                    ?>
                    <div class="card-box">
                      <h4>Proses Data</h4>
                      <table class="table table-border">
                        <thead>
                          <tr>
                              <th>Sentimen</th>
                            <th>Preprocessing</th>
                              <th>Label</th>
                          </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td align="center" style="border-right: 1px solid black;" colspan="<?=sizeof($index)-1?>"><b>--Atribut Pendukung--</b></td>
                            <td align="center" style="border-right: 1px solid black;" colspan="<?=sizeof($index)-1?>"><b>--Atribut Pendukung Preprocessing--</b></td>
                            <td align="center"><b>--Label Target--</b></td>
                        </tr>
                            <?php
                            foreach ($dataset as $key) {
                                ?>

                                <tr>
                                    <?php
                                    $x=0;
                                    $txt = "";
                                     foreach ($index as $keys) {
                                        $x++;
                                        if($x!=sizeof($index)){
                                          $txt=$key[$keys];

                                          ?>
                                          <td><?=$key[$keys]?></td>
                                          <td class="table-warning">
                                            <?php
                                            $text = mb_strtolower($txt);
                                            $text = preg_replace($s, '', $text);
                                            // split the words
                                            $text = preg_replace('/[^A-Za-z ]/','', $text);
                                            // first match list of words
                                            echo $text;
                                             ?>
                                         </td>
                                          <?php
                                        }else{
                                          ?>
                                              <td class="<?=$x==sizeof($index)?'table-success':'table-warning';?>"><?=$key[$keys]?></td>
                                          <?php
                                        }

                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } ?>
                    <?php
                }
                if($page == 'prediksi'){
                  $index = array("response","label");
                  $dataset = $this->db->get("dataset")->result_array();
                      if(sizeof($index)>0 && sizeof($dataset)>0){
                        foreach ($dataset as $key) {
                          $classifier->learn($key['response'], $key['label']);
                        }
                        ?>
                        <div class="card-box">
                            <div class="row">
                            <div class="col-md-6">
                            <h4>Uji Sentimen Baru</h4>
                            <form method="POST" action="">
                              <div class="form-group">
                                <label>Masukkan Sentimen baru</label>
                                <textarea type="text" name="response" class="form-control"><?=$this->input->post('response')?></textarea>
                              </div>
                              <div class="form-group">
                                 <button class="btn btn-primary" name="prediksi" value="1" type="submit">Uji Sentimen</button>
                              </div>
                            </form>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    if($this->input->post('prediksi') !== NULL){
                                      $result = $classifier->categorize($this->input->post('response'));
                                      $stateJson = $classifier->toJson();
                                      $debug = $classifier->fromJson($stateJson);
                                      // echo "<pre>";
                                      // print_r($debug);
                                      // echo "</pre>";
                                      $categories = $debug->categories;
                                      $docCount = $debug->docCount;
                                      $totalDocuments = $debug->totalDocuments;
                                        ?>
                                        <h4>Proses</h4>
                                        <div class="card card-body bg-info text-white">
                                            <h4 class="card-title text-white mb-2">Total Label</h4>
                                            <?php
                                              foreach ($categories as $key => $value) {
                                                echo $key." : ".$value."<br />";
                                              }
                                            ?>
                                            <h4 class="card-title mt-2 text-white mb-2">Document by Label</h4>
                                            Total Document : <?=$totalDocuments?><br />
                                            <?php
                                              foreach ($docCount as $key => $value) {
                                                echo $key." : ".$value."<br />";
                                              }
                                            ?>
                                        </div>
                                        <h4>Hasil</h4>
                                        <div class="card card-body bg-primary text-white">
                                          <h4 class="card-title mb-2 text-white">Hasil Uji</h4>
                                          <h4 class="card-title mb-2 text-white" align="center"><?=$result?></h4>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                if($page == 'performance'){
                  $index = array("response","label");
                  $dataset = $this->db->query("select * from dataset")->result_array();
                    // // $print($train);
                    // var_dump($dataset);
                    // die();
                  
                      if(sizeof($index)>0 && sizeof($dataset)>0){
                    ?>
                       <div class="card-box">
                            <div class="row">
                            <div class="col-md-6">
                            <h4>Uji Metode dan Akurasi (Memilih Prosentase Data)</h4>
                            <form method="POST" action="" id="performance">
                                <div class="form-group">
                                    <label id="lab"><?=$this->input->post('train')!==NULL?$this->input->post('train').'%, Data Testing '.(100-$this->input->post('train')).'%':''?></label>
                                    <select name="train" required="" onchange="if($(event.target).val()!=''){$('#lab').html('Data Training'+ $(event.target).val()+'%, Data Testing '+(100-$(event.target).val())+'%');$('#performance').submit();}else{$('#lab').html('Prosentase Data Training');}" class="form-control">
                                       <option value="">-- Pilih Prosentase --</option>
                                       <option value="10" <?=$this->input->post('train')==10?'selected':''?>>10 % Data Training, 90% Data Testing</option>
                                       <option value="20" <?=$this->input->post('train')==20?'selected':''?>>20 % Data Training, 80% Data Testing</option>
                                       <option value="30" <?=$this->input->post('train')==30?'selected':''?>>30 % Data Training, 70% Data Testing</option>
                                       <option value="40" <?=$this->input->post('train')==40?'selected':''?>>40 % Data Training, 60% Data Testing</option>
                                       <option value="50" <?=$this->input->post('train')==50?'selected':''?>>50 % Data Training, 50% Data Testing</option>
                                       <option value="60" <?=$this->input->post('train')==60?'selected':''?>>60 % Data Training, 40% Data Testing</option>
                                       <option value="70" <?=$this->input->post('train')==70?'selected':''?>>70 % Data Training, 30% Data Testing</option>
                                       <option value="80" <?=$this->input->post('train')==80?'selected':''?>>80 % Data Training, 20% Data Testing</option>
                                       <option value="90" <?=$this->input->post('train')==90?'selected':''?>>90 % Data Training, 10% Data Testing</option>                                       
                                    </select>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-6">

                            </div>
                            </div>
                        </div>
                        <?php if($this->input->post('train')!==NULL){ ?>
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Pemisahan Data Training & Testing</h4>
                                    <?php
                                        $train = $this->input->post('train');
                                        
                                        $countdata = sizeof($dataset);
                      
                                        $ndatatrain = ($train/100)*$countdata;
                                        $ndatatrain = floor($ndatatrain);
                                        $newtraindata = [];
                                    ?>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td align="center" colspan="<?=sizeof($index)?>"><b>--Data Training--</b></td>
                                        </tr>
                                            <?php
                                            $x=0;$flagtesting=0;
                                            
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($ndatatrain>=$x){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $newtraindata_temp=[];
                                                    $x_temp = 0;
                                                    $resp = "";$label="";
                                                    foreach ($index as $keys) {
                                                        $newtraindata_temp[]=$key[$keys];
                                                        $text = mb_strtolower($key[$keys]);
                                                        $text = preg_replace($s, '', $text);
                                                        // split the words
                                                        $text = preg_replace('/[^A-Za-z ]/','', $text);
                                                        // first match list of words
                                                        ?>
                                                            <td class="table-primary"><?=$text?></td>
                                                        <?php
                                                        if($x_temp==0){
                                                          $resp=$key[$keys];
                                                        }else if($x_temp==1){
                                                          $label=$key[$keys];
                                                        }
                                                        $x_temp++;
                                                    }
                                                    $classifier->learn($resp, $label);
                                                    $newtraindata[]=$newtraindata_temp;
                                                    ?>
                                                </tr>
                                                <?php
                                                }else{
                                                ?>
                                                <?php if($flagtesting==0){$flagtesting++; ?>
                                                <tr>
                                                <td align="center" colspan="<?=sizeof($index)?>"><b>--Data Testing--</b></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <?php
                                                    foreach ($index as $keys) {
                                                      $text = mb_strtolower($key[$keys]);
                                                      $text = preg_replace($s, '', $text);
                                                      // split the words
                                                      $text = preg_replace('/[^A-Za-z ]/','', $text);
                                                    ?>
                                                        <td class="table-warning"><?=$text?></td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <h4 class="mt-3">Proses Testing</h4>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                            <th>Hasil Testing</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x=0;$benar=0;
                                            $tp=0;$tn=0;$fp=0;$fn=0;
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($x>$ndatatrain){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $resp="";$lab="";$x_temp=0;
                                                    foreach ($index as $keys) {
                                                      ?>
                                                          <td class="table-warning"><?=$key[$keys]?></td>
                                                      <?php
                                                      if($x_temp==0){
                                                        $resp = $key[$keys];
                                                      }else if($x_temp==1){
                                                        $lab = $key[$keys];
                                                      }
                                                      $x_temp++;
                                                    }
                                                    $result = $classifier->categorize($resp);
                                                    ?>
                                                    <td class="table-primary">
                                                    <?php
                                                    echo $result;
                                                      if($result==$lab){
                                                        $benar++;
                                                      }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                              }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <?php
                                        $akurasi=(($ndatatrain)/($ndatatrain+$benar))*100;
                                    ?>
                                    <div class="card card-body <?php if($akurasi<60){echo 'bg-danger';}else if($akurasi<80){echo 'bg-warning';}else{echo 'bg-primary';} ?> text-white">
                                        <h4 class="card-title mb-0 text-white">Hasil Akurasi : <?=round($akurasi)?>%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php
                }
              }
            ?>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end card-box -->
    </div> <!-- end Col -->
</div>