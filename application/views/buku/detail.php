<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php
	$idkat = $motor->id_kategori;
	$idrak = $motor->id_showroom;

	$kat = $this->M_Admin->get_tableid_edit('tbl_kategori','id_kategori',$idkat);
	$rak = $this->M_Admin->get_tableid_edit('tbl_showroom','id_showroom',$idrak);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-book" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-book"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<h4><?= $motor->merk;?></h4>
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
					<table class="table table-striped table-bordered">
						<tr>
							<td style="width:20%">No Rangka</td>
							<td><?= $motor->no_rangka;?></td>
						</tr>
						<tr>
							<td>Foto Motor</td>
							<td><?php if(!empty($motor->sampul !== "0")){?>
									<a href="<?= base_url('assets_style/image/buku/'.$motor->sampul);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/buku/'.$motor->sampul);?>" style="width:170px;height:170px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada Foto</p>';}?>
								</td>
						</tr>
						<tr>
							<td>Merk Motor</td>
							<td><?= $motor->merk;?></td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td><?= $kat->nama_kategori;?></td>
						</tr>
						<tr>
							<td>Penerbit</td>
							<td><?= $motor->penerbit;?></td>
						</tr>
						<tr>
							<td>Pabrikan</td>
							<td><?= $motor->pabrikan;?></td>
						</tr>
						<tr>
							<td>Tahun Terbit</td>
							<td><?= $motor->thn_motor;?></td>
						</tr>
						<tr>
							<td>Jumlah Motor</td>
							<td><?= $motor->jml;?></td>
						</tr>
						<tr>
							<td>Jumlah Pinjam</td>
							<td>
								<?php
									$id = $motor->motor_id;
									$dd = $this->db->query("SELECT * FROM tbl_pinjam WHERE motor_id= '$id' AND status = 'Dipinjam'");
									if($dd->num_rows() > 0 )
									{
										echo $dd->num_rows();
									}else{
										echo '0';
									}
								?> 
								<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary btn-xs" style="margin-left:1pc;">
									<i class="fa fa-sign-in"></i> Detail Pinjam</a>
							</td>
						</tr>
						<tr>
							<td>Keterangan Lainnya</td>
							<td><?= $motor->isi;?></td>
						</tr>
						<tr>
							<td>Showroom / Lokasi</td>
							<td><?= $motor->id_showroom;?></td>
						</tr>
						<tr>
							<td>Lampiran</td>
							<td><?php if(!empty($motor->lampiran !== "0")){?>
									<a href="<?= base_url('assets_style/image/buku/'.$motor->lampiran);?>" class="btn btn-primary btn-md" target="_blank">
										<i class="fa fa-download"></i> Sample Motor
									</a>
								<?php  }else{ echo '<br/><p style="color:red">* Tidak ada Lampiran</p>';}?>
                               </td>
						</tr>
						<tr>
							<td>Tanggal Masuk</td>
							<td><?= $motor->tgl_masuk;?></td>
						</tr>
					</table>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

 <!--modal import -->
<div class="modal fade" id="TableAnggota">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"> Anggota Yang Sedang Pinjam</h4>
</div>
<div id="modal_body" class="modal-body fileSelection1">
<table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>ID</th>
			<th>Nama</th>
			<th>Jenkel</th>
			<th>Telepon</th>
			<th>Tgl Pinjam</th>
			<th>Lama Pinjam</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 1;
	$motorid = $motor->motor_id;
	$pin = $this->db->query("SELECT * FROM tbl_pinjam WHERE motor_id ='$motorid' AND status = 'Dipinjam'")->result_array();
	foreach($pin as $si)
	{
		$isi = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$si['anggota_id']);
		if($isi->level == 'Anggota'){
		?>
		<tr>
			<td><?= $no;?></td>
			<td><?= $isi->anggota_id;?></td>
			<td><?= $isi->nama;?></td>
			<td><?= $isi->jenkel;?></td>
			<td><?= $isi->telepon;?></td>
			<td><?= $si['tgl_pinjam'];?></td>
			<td><?= $si['lama_pinjam'];?> Hari</td>
		</tr>
	<?php $no++;}}?>
	</tbody>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
