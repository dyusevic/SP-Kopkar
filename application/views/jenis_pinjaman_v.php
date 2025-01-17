
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<?php
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
// print_r($data_jpinjam);
?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah Jenis Pinjaman</button>
<div style="padding: 25px;">

  <?php
  $data=$this->session->flashdata('sukses');
  if($data!=""){
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Sukses! </h4>
      <?=$data;?>
    </div>
    <?php
  }
  ?>
  <?php
  $data2=$this->session->flashdata('error');
  if($data2!=""){
    ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Gagal! </h4>
      <?=$data2;?>
    </div>
    <?php
  }
  ?>

  <table id="example" class="display nowrap" style="width:100%">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Jenis Pinjaman</th>
        <th class="text-center">Chart Of Account</th>
		<th class="text-center">Chart Of Account Biaya Administrasi</th>
		<th class="text-center">Chart Of Account Bunga Pinjaman</th>
		<th class="text-center">Chart Of Account Denda</th>
        <th class="text-center">Status</th>
        <th class="text-center">Aksi</th>

      </tr>
    </thead>
    <tbody>
      <?php
      $i=0;
      foreach ($data_jpinjam as $jpinjam) {
        $i++;
		//$coapb=$this->KodeCOA('00.10.10.120');
        ?>
        <tr>
          <td class="text-center"><?= $i;?></td>
          <td class="text-center"><?php echo $jpinjam->jns_pinjam;?></td>
          <td class="text-left"><?php echo $jpinjam->vcCOAName;?></td>
		  <td class="text-left"><?php echo $jpinjam->namaCOAPB;?></td>
		  <td class="text-left"><?php echo $jpinjam->namaCOABA;?></td>
		  <td class="text-left"><?php echo $jpinjam->namaCOADA;?></td>
          <td class="text-center">
            <?php
              if($jpinjam->tampil == 'Y'){
                echo 'Aktif';
              }else{
                echo 'Tidak aktif';
              }
            ?>
          </td>
          <td class="text-center">
            <a title="Edit" href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#edit-<?php echo $jpinjam->id?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            <a title="Hapus" href="<?= site_url('jenis_pinjaman/delete/'.$jpinjam->id)?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
          </td>
        </tr>

        <!-- looping modal start -->
        <div class="modal fade" id="edit-<?php echo $jpinjam->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Jenis Pinjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="<?php echo site_url('jenis_pinjaman/post_update_jenis_pinjaman')?>" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Jenis Pinjaman</label>
                    <input type="text" class="form-control" id="jns_pinjam" name="jns_pinjam" style="height: 20%;" required="required" value="<?php echo $jpinjam->jns_pinjam?>">
                    <input type="hidden" class="form-control" id="id" name="id" style="height: 20%;" required="required" value="<?php echo $jpinjam->id?>">
                  </div>
                  <div class="form-group">
                    <label for="vcCOACode" class="col-form-label">Chart Of Account</label><br>
                    <select type="text" class="form-control" id="vcCOACode" name="vcCOACode" style="height: 20%;" required="required">
                      <option value="">-----Pilih COA-----</option>
                      <?php
                      foreach ($coa as $code) {
                        if($code->vcCOACode == $jpinjam->vcCOACode){
                          ?>
                          <option selected="selected" value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                          <?php
                        }else{
                          ?>
                          <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
					<div class="form-group">
                    <label for="COAPB" class="col-form-label">Chart Of Account BUNGA PINJAMAN</label><br>
                    <select type="text" class="form-control" id="coapb" name="coapb" style="height: 20%;" required="required" onclick="editpilcoapb()">
                      <option value="">-----Pilih COA PB-----</option>
                      <?php
                      foreach ($coa as $codepb) {
                        if($codepb->vcCOACode == $jpinjam->COAPB){
                          ?>
                          <option selected="selected" value="<?php echo $codepb->vcCOACode?>"><?php echo $codepb->vcCOAName?></option>
                          <?php
                        }else{
                          ?>
                          <option value="<?php echo $codepb->vcCOACode?>"><?php echo $codepb->vcCOAName?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
					<input type="text" class="form-control" id="namacoapb" name="namacoapb">
                  </div>
				  <div class="form-group">
                    <label for="COABA" class="col-form-label">Chart Of Account BIAYA ADMINISTRASI</label><br>
                    <select type="text" class="form-control" id="coaba" name="coaba" style="height: 20%;" required="required" onclick="editpilcoaba()">
                      <option value="">-----Pilih COA BA-----</option>
                      <?php
                      foreach ($coa as $codeba) {
                        if($codeba->vcCOACode == $jpinjam->COABA){
                          ?>
                          <option selected="selected" value="<?php echo $codeba->vcCOACode?>"><?php echo $codeba->vcCOAName?></option>
                          <?php
                        }else{
                          ?>
                          <option value="<?php echo $codeba->vcCOACode?>"><?php echo $codeba->vcCOAName?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
					<input type="text" class="form-control" id="namacoaba" name="namacoaba">
                  </div>
				  <div class="form-group">
                    <label for="COADA" class="col-form-label">Chart Of Account DENDA</label><br>
                    <select type="text" class="form-control" id="coada" name="coada" style="height: 20%;" required="required" onclick="editpilcoada()">
                      <option value="">-----Pilih COA DA-----</option>
                      <?php
                      foreach ($coa as $codeda) {
                        if($codeda->vcCOACode == $jpinjam->COADA){
                          ?>
                          <option selected="selected" value="<?php echo $codeda->vcCOACode?>"><?php echo $codeda->vcCOAName?></option>
                          <?php
                        }else{
                          ?>
                          <option value="<?php echo $codeda->vcCOACode?>"><?php echo $codeda->vcCOAName?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
					<input type="text" class="form-control" id="namacoada" name="namacoada">
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Status</label><br>
                    <select type="text" class="form-control" id="tampil" name="tampil" style="height: 20%;" required="required">
                      <option value="">-----Pilih Status-----</option>
                      <?php
                      if($jpinjam->tampil == 'Y'){
                        ?>
                        <option selected="selected" value="Y">Ya</option>
                        <option value="T">Tidak</option>
                        <?php
                      }else{
                        ?>
                        <option value="Y">Ya</option>
                        <option selected="selected" value="T">Tidak</option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
				  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- looping modal end -->
        <?php
      }
      ?>
    </tbody>
  </table>
</div>


<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Pinjaman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('jenis_pinjaman/post_jenis_pinjam')?>" method="post">
        <div class="modal-body">
		<div class="form-group">
            <label for="recipient-name" class="col-form-label">Kode Jenis Pinjaman</label>
            <input type="text" class="form-control" id="kd_jns_pinjam2" name="kd_jns_pinjam2" style="height: 20%;" required="required" placeholder="Gunakan Huruf Besar, maximal 3 karakter" onChange="javascript:{this.value = this.value.toUpperCase();}" maxlength="3">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jenis Pinjaman</label>
            <input type="text" class="form-control" id="jns_pinjam2" name="jns_pinjam2" style="height: 20%;" required="required" value="" maxlength="30">
          </div>
          <div class="form-group">
            <label for="vcCOACode" class="col-form-label">Chart Of Account</label><br>
            <select type="text" class="form-control" id="vcCOACode2" name="vcCOACode2" style="height: 20%;" required="required">
              <option value="">-----Pilih COA-----</option>
              <?php
              foreach ($coa as $code) {
                ?>
                <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                <?php
              }
              ?>
            </select>
          </div>
		  <!--add-on by ysf (2019-07-11)-->
			<div class="form-group">
            <label for="coaPB class="col-form-label">Chart Of Account PB</label><br>
            <select type="text" class="form-control" id="coapb2" name="coapb2" style="height: 20%;" required="required" onclick="pilcoapb()">
              <option value="">-----Pilih COAPB-----</option>
              <?php
              foreach ($coa as $code) {
                ?>
                <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                <?php
              }
              ?>
            </select>
			<input type="text" class="form-control" id="namacoapb2" name="namacoapb2">
			</div>
		  <!-- end of add-on -->
		  <!--add-on by ysf (2019-07-11)-->
			<div class="form-group">
            <label for="coaPB class="col-form-label">Chart Of Account BA</label><br>
            <select type="text" class="form-control" id="coaba2" name="coaba2" style="height: 20%;" required="required" onclick="pilcoaba()">
              <option value="">-----Pilih COAPB-----</option>
              <?php
              foreach ($coa as $code) {
                ?>
                <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                <?php
              }
              ?>
            </select>
			<input type="text" class="form-control" id="namacoaba2" name="namacoaba2">
			</div>
		  <!-- end of add-on -->
		  <!--add-on by ysf (2019-08-06)-->
			<div class="form-group">
            <label for="coaDA class="col-form-label">Chart Of Account DENDA</label><br>
            <select type="text" class="form-control" id="coada2" name="coada2" style="height: 20%;" required="required" onclick="pilcoada()>
              <option value="">-----Pilih COADA-----</option>
              <?php
              foreach ($coa as $code) {
                ?>
                <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                <?php
              }
              ?>
            </select>
			<input type="text" class="form-control" id="namacoada2" name="namacoada2">
			</div>
		  <!-- end of add-on -->
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Status</label><br>
            <select type="text" class="form-control" id="tampil2" name="tampil2" style="height: 20%;" required="required">
              <option value="">-----Pilih Status-----</option>
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/vfs_fonts.js"  type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.html5.min.js"  type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.print.min.js"  type="text/javascript" ></script>




<script>
  $(document).ready(function() {
    $('#example').DataTable( {
      'ordering' : false,
      dom: 'Bfrtip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  } );
function pilcoapb(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coapb2').selectedIndex;
	 ddi=document.getElementById('coapb2').options;
	 document.getElementById('namacoapb2').value=ddi[ysf].text;
 }
 function pilcoaba(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coaba2').selectedIndex;
	 ddi=document.getElementById('coaba2').options;
	 document.getElementById('namacoaba2').value=ddi[ysf].text;
 }
 function pilcoada(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coada2').selectedIndex;
	 ddi=document.getElementById('coada2').options;
	 document.getElementById('namacoada2').value=ddi[ysf].text;
 }
 function editpilcoapb(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coapb').selectedIndex;
	 ddi=document.getElementById('coapb').options;
	 document.getElementById('namacoapb').value=ddi[ysf].text;
 }
 function editpilcoaba(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coaba').selectedIndex;
	 ddi=document.getElementById('coaba').options;
	 document.getElementById('namacoaba').value=ddi[ysf].text;
 }
 function editpilcoada(){
	 var ysf="";
	 var ddi="";
	 ysf=document.getElementById('coada').selectedIndex;
	 ddi=document.getElementById('coada').options;
	 document.getElementById('namacoada').value=ddi[ysf].text;
 }
</script>
