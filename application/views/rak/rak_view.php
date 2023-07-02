<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
	<div class="row">
	    <div class="col-md-12">
			<div class="row">
				<div class="col-sm-4">
					<div class="box box-primary">
						<div class="box-header with-border">
							<?php if(!empty($this->input->get('id'))){?>
							<h4> Edit Showroom</h4>
							<?php }else{?>
							<h4> Tambah Showroom</h4>
							<?php }?>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<?php if(!empty($this->input->get('id'))){?>
							<form method="post" action="<?= base_url('data/showroomproses');?>">
								<div class="form-group">
								<label for="">Nama Showroom / Lokasi</label>
								<input type="text" name="showroom"  value="<?=$showroom->id_showroom;?>" id="showroom" class="form-control" placeholder="Contoh : Showroom 1" >
								
								</div>
								<br/>
								<input type="hidden" name="edit" value="<?=$showroom->id_showroom;?>">
								<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Showroom</button>
							</form>
							<?php }else{?>

							<form method="post" action="<?= base_url('data/showroomproses');?>">
								<div class="form-group">
								<label for="">Nama Showroom / Lokasi</label>
								<input type="text" name="showroom" id="showroom" class="form-control" placeholder="Contoh : Showroom Motor 1" >
								
								</div>
								<br/>
								<input type="hidden" name="tambah" value="tambah">
								<button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Showroom</button>
							</form>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="box box-primary">
						<div class="box-header with-border">
						</div>
						<!-- /.box-header -->
						<div class="box-body">
						<div class="table-responsive">
							<table id="example1" class="table table-bordered table-striped table" width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Showroom Motor</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php $no=1;foreach($showroom_motor->result_array() as $isi){?>
									<tr>
										<td><?= $no;?></td>
										<td><?= $isi['nama_showroom'];?></td>
										<td style="width:20%;">
											<a href="<?= base_url('data/showroom?id='.$isi['id_showroom']);?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
											<a href="<?= base_url('data/showroomproses?showroom_id='.$isi['id_showroom']);?>" onclick="return confirm('Anda yakin Showroom Motor ini akan dihapus ?');">
											<button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
										</td>
									</tr>
								<?php $no++;}?>
								</tbody>
							</table>
						</div>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
</section>
</div>
