<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-body">
          <?php echo form_open("customers/edit/".$customer->id);?>

          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label" for="code"><?= $this->lang->line("name"); ?></label>
              <?= form_input('name', set_value('name', $customer->name), 'class="form-control input-sm" id="name"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label">Alamat Konsumen</label>
			  <?= form_textarea('address', set_value('address', $customer->address), 'class="form-control" id="address" style="margin-top: 10px; height: 100px;"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="phone">No HP Konsumen</label>
              <?= form_input('phone', set_value('phone', $customer->phone), 'class="form-control input-sm" id="phone"');?>
            </div>

            <div class="form-group">
				<label class="control-label">Nama Pengirim</label>
				<?= form_input('nama_pengirim', set_value('nama_pengirim', $customer->nama_pengirim), 'class="form-control input-sm" id="nama_pengirim"'); ?>
			</div>

			<div class="form-group">
				<label class="control-label">No. Pengirim</label>
				<?= form_input('no_pengirim', set_value('no_pengirim', $customer->no_pengirim), 'class="form-control input-sm" id="no_pengirim"');?>
			</div>
			<div class="form-group">
				Nama Kurir
				<?php $opts = array('JNE' => 'JNE', 'J&T' => 'J&T', 'POS' => 'POS','WAHANA' => 'WAHANA','TIKI' => 'TIKI','INDAH CARGO' => 'INDAH CARGO','LAINNYA' => 'LAINNYA'); ?>
				<?= form_dropdown('kurir', $opts, $customer->kurir, 'class="form-control tip select2" id="kurir"  required="required" style="width:100%;"'); ?>
			</div>
			<div class="form-group">
				Input Nomor Resi
				<?= form_input('layanan', set_value('layanan', $customer->layanan), 'class="form-control input-sm" id="layanan"');?>
			</div>
            <div class="form-group">
              <?php echo form_submit('edit_customer', $this->lang->line("edit_customer"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
