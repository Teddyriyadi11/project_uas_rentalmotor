<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-plus" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form action="<?php echo base_url('data/prosesmotor');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
								<div class="form-group">
									<label>Kategori</label>
									<select class="form-control select2" required="required"  name="kategori">
										<option disabled selected value> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>"><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Showroom / Lokasi</label>
                                    <select name="showroom" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih Showroom / Lokasi -- </option>
										<?php foreach($showroom as $isi){?>
											<option value="<?= $isi['id_showroom'];?>"><?= $isi['nama_showroom'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No Rangka</label>
                                    <input type="text" class="form-control" name="no_rangka"  placeholder="Contoh : 978-602-8123-35-8">
                                </div>
                                <div class="form-group">
                                    <label>Merk Motor</label>
                                    <input type="text" class="form-control" name="merk" placeholder="Contoh : Kawasaki">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pabrikan</label>
                                    <input type="text" class="form-control" name="pabrikan" placeholder="Kawasaki Jepang">
                                </div>
                                <div class="form-group">
                                    <label>Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" placeholder="AHM">
                                </div>
                                <div class="form-group">
                                    <label>Tahun Motor</label>
                                    <input type="number" class="form-control" name="thn" placeholder="Tahun Motor : 2019">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jumlah Motor</label>
                                    <input type="number" class="form-control" name="jml" placeholder="Jumlah Motor : 12">
                                </div>
								
                                <div class="form-group">
                                    <label>Foto <small style="color:green">(gambar) * opsional</small></label>
                                    <input type="file" accept="image/*" name="gambar">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Motor <small style="color:green">(pdf) * opsional</small></label>
                                    <input type="file" accept="application/pdf" name="lampiran">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Lainnya</label>
                                    <textarea class="form-control" name="ket" id="summernotehal" style="height:120px"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="tambah" value="tambah">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                    </form>
                            <a href="<?= base_url('data');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
