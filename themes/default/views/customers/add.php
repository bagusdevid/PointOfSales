<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-body">
					<?php echo form_open("customers/add");?>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="code"><?= $this->lang->line("name"); ?></label>
							<?= form_input('name', set_value('name'), 'class="form-control input-sm" id="name"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label">Alamat Konsumen</label>
							<?= form_textarea('address', set_value('address'), 'class="form-control" id="address" style="margin-top: 10px; height: 100px;"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="phone">No HP Konsumen</label>
							<?= form_input('phone', set_value('phone'), 'class="form-control input-sm" id="phone"');?>
						</div>

						<div class="form-group">
							<label class="control-label">Nama Pengirim</label>
							<?= form_input('nama_pengirim', $Settings->site_name, 'class="form-control input-sm" id="nama_pengirim"'); ?>
						</div>

						<div class="form-group">
							<label class="control-label">No. Pengirim</label>
							<?= form_input('no_pengirim', $Settings->tel, 'class="form-control input-sm" id="no_pengirim"');?>
						</div>

						<div class="form-group">
							<?php echo form_submit('add_customer', $this->lang->line("add_customer"), 'class="btn btn-primary"');?>
						</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</section>
