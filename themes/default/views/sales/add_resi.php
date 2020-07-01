<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title" id="myModalLabel">Input Nomor Resi</h4>
        </div>
        <?= form_open_multipart("sales/add_resi/" . $inv->id."/"); ?>
		<input type="hidden" value="<?= $inv->id; ?>" id="sale_id" name="sale_id" />
        <div class="modal-body">
            <div class="form-group">
				Nama Kurir
				<?php $opts = array('JNE' => 'JNE', 'J&T' => 'J&T', 'POS' => 'POS','WAHANA' => 'WAHANA','TIKI' => 'TIKI','INDAH CARGO' => 'INDAH CARGO','LAINNYA' => 'LAINNYA'); ?>
					<?= form_dropdown('kurir', $opts, set_value('kurir', 'JNE'), 'class="form-control tip select2" id="kurir"  required="required" style="width:100%;"'); ?>
			</div>
			<div class="form-group">
				Input Nomor Resi
				<?= form_input('resi', set_value('resi'), 'class="form-control tip" id="resi"'); ?>
			</div>
		</div>
		<div class="modal-footer">
			<?php echo form_submit('add_resi', 'Simpan', 'class="btn btn-primary"'); ?>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>