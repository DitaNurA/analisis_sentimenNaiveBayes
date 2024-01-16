<div class="row">
  <div class="col-12">
    <div class="card-box">
      <h4>Pilih Data Excel</h4>
      <br>
      <form enctype="multipart/form-data">
          <input id="upload" type="file" name="files">
          <button type="button" class="btn btn-primary btn-sm" id="upl" onclick="doupl()" style="display:none;">Upload</button>
      </form>
      <a href="<?php echo base_url('delete_all_data'); ?>">Hapus Semua Data</a>
    </div>
  </div>
</div>
<script type="text/javascript">setTimeout(function(){
  $('.btn.btn-default.gc-filter-button.btn-outline-dark.t5').hide();
  $('.btn.btn-outline-dark.dropdown-toggle').hide();
  $('.btn.btn-default.btn-outline-dark').hide();
},500);</script>
<?php
  echo $output;
?>
