<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp;  <?= $title_web;?></li>
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
											<option value="<?= $isi['id_kategori'];?>" <?php if($isi['id_kategori'] == $motor->id_kategori){ echo 'selected';}?>><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Showroom / Lokasi</label>
                                    <select name="showroom" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih Showroom / Lokasi -- </option>
										<?php foreach($showroom as $isi){?>
											<option value="<?= $isi['id_showroom'];?>" <?php if($isi['id_showroom'] == $motor->id_showroom){ echo 'selected';}?>><?= $isi['nama_showroom'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No Rangka</label>
                                    <input type="text" class="form-control" value="<?= $motor->no_rangka;?>" name="no_rangka"  placeholder="Contoh No_rangka : 978-602-8123-35-8">
                                </div>
                                <div class="form-group">
                                    <label>Merk Motor</label>
                                    <input type="text" class="form-control" value="<?= $motor->merk;?>" name="merk" placeholder="Contoh : Ninja ZX-6R 636 SE">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pabrikan</label>
                                    <input type="text" class="form-control" value="<?= $motor->pabrikan;?>" name="pabrikan" placeholder="Nama Pabrikan">
                                </div>
                                <div class="form-group">
                                    <label>Penerbit</label>
                                    <input type="text" class="form-control" value="<?= $motor->penerbit;?>" name="penerbit" placeholder="Nama Penerbit">
                                </div>
                                <div class="form-group">
                                    <label>Tahun Motor</label>
                                    <input type="number" class="form-control" value="<?= $motor->thn_motor;?>" name="thn" placeholder="Tahun dibuat : 2019">
                                </div>
								
                            </div>
                            <div class="col-sm-6">
								
								<div class="form-group">
                                    <label>Jumlah Motor</label>
                                    <input type="number" class="form-control" value="<?= $motor->jml;?>" name="jml" placeholder="Jumlah motor : 12">
								</div>
                                <div class="form-group">
								<label>Foto <small style="color:green">(gambar) * opsional</small></label>
									<input type="file" accept="image/*" name="gambar">

									<?php if(!empty($motor->sampul !== "0")){?>
									<br/>
									<a href="<?= base_url('assets_style/image/buku/'.$motor->sampul);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/buku/'.$motor->sampul);?>" style="width:70px;height:70px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada Sampul</p>';}?>
								</div>
                                <div class="form-group">
								<label>Keterangan Motor <small style="color:green">(pdf) * ganti opsional</small></label>
                                    <input type="file" accept="application/pdf" name="lampiran">
                                    <br>
									<?php if(!empty($motor->lampiran !== "0")){?>
									<a href="<?= base_url('assets_style/image/buku/'.$motor->lampiran);?>" class="btn btn-primary btn-md" target="_blank">
										<i class="fa fa-download"></i> Sample Motor
									</a>
									<?php  }else{ echo '<br/><p style="color:red">* Tidak ada Keterangan</p>';}?>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Lainnya</label>
                                    <textarea class="form-control" name="ket" id="summernotehal" style="height:120px"><?= $motor->isi;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="gmbr" value="<?= $motor->sampul;?>">
							<input type="hidden" name="lamp" value="<?= $motor->lampiran;?>">
							<input type="hidden" name="edit" value="<?= $motor->id_motor;?>">
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
