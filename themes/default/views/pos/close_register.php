<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <button type="button" class="close mr10" onclick="window.print();"><i class="fa fa-print"></i></button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('register_details').' ('.lang('opened_at').': '.$this->izi->hrld($this->session->userdata('register_open_time')).')'; ?></h4>
        </div>
        <?= form_open("pos/close_register/" . $user_id); ?>
        <div class="modal-body">
            <table width="100%" class="stable">
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('cash_in_hand'); ?>:</h4></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->izi->formatMoney($this->session->userdata('cash_in_hand')); ?></span></h4>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('cash_sale'); ?>:</h4></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->izi->formatMoney($cashsales->paid ? $cashsales->paid : '0.00') . ' (' . $this->izi->formatMoney($cashsales->total ? $cashsales->total : '0.00') . ')'; ?></span>
                        </h4></td>
                </tr>

                <?php if (isset($Settings->stripe)) { ?>
                    <tr>
                        <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('stripe'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                                <span><?= $this->izi->formatMoney($stripesales->paid ? $stripesales->paid : '0.00') . ' (' . $this->izi->formatMoney($stripesales->total ? $stripesales->total : '0.00') . ')'; ?></span>
                            </h4></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td style="border-bottom: 1px solid #008d4c;"><h4><?= lang('other_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #008d4c;"><h4>
                            <span><?= $this->izi->formatMoney($other_sales->paid ? $other_sales->paid : '0.00') . ' (' . $this->izi->formatMoney($other_sales->total ? $other_sales->total : '0.00') . ')'; ?></span>
                        </h4></td>
                </tr>

                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><?= lang('total_sales'); ?>:</h4></td>
                    <td width="200px;" style="font-weight:bold;text-align:right;"><h4>
                            <span><?= $this->izi->formatMoney($totalsales->paid ? $totalsales->paid : '0.00') . ' (' . $this->izi->formatMoney($totalsales->total ? $totalsales->total : '0.00') . ')'; ?></span>
                        </h4></td>
                </tr>

                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><?= lang('expenses'); ?>:</h4></td>
                    <td width="200px;" style="font-weight:bold;text-align:right;"><h4>
                            <span><?= $this->izi->formatMoney($expenses->total ? $expenses->total : '0.00'); ?></span>
                        </h4></td>
                </tr>
                <?php $total_cash = ($cashsales->paid ? $cashsales->paid + ($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')) : (($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand'))));
                $total_cash -= ($expenses->total ? $expenses->total : 0.00);
                ?>
                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><strong><?= lang('total_cash'); ?></strong>:</h4>
                    </td>
                    <td style="text-align:right;"><h4>
                            <span><strong><?= $this->izi->formatMoney($total_cash); ?></strong></span>
                        </h4></td>
                </tr>
            </table>

                <hr>
                <?php 
				$total_cash = ($cashsales->paid ? $cashsales->paid + ($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')) : (($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand'))));
                $total_cash -= ($expenses->total ? $expenses->total : 0.00);
                ?>
			
				<?= form_hidden('total_cash', $total_cash); ?>
				<?= form_hidden('total_cash_submitted', (isset($_POST['total_cash_submitted']) ? $_POST['total_cash_submitted'] : $total_cash), 'class="form-control input-tip" id="total_cash_submitted" required="required"'); ?>
				<?= form_hidden('total_cheques', $chsales->total_cheques); ?>
				<?= form_hidden('total_cheques_submitted', (isset($_POST['total_cheques_submitted']) ? $_POST['total_cheques_submitted'] : $chsales->total_cheques), 'class="form-control input-tip" id="total_cheques_submitted" required="required"'); ?>
				<?= form_hidden('total_cc_slips', $ccsales->total_cc_slips); ?>
				<?= form_hidden('total_cc_slips_submitted', (isset($_POST['total_cc_slips_submitted']) ? $_POST['total_cc_slips_submitted'] : $ccsales->total_cc_slips), 'class="form-control input-tip" id="total_cc_slips_submitted" required="required"'); ?>
                
                <div class="form-group">
                    <label for="note"><?= lang("note"); ?></label>
                    <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control redactor" id="note" style="margin-top: 10px; height: 100px;"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=lang('close')?></button>
                <?php
                if ( ! $Settings->remote_printing) {
                    echo '<a href="'.site_url('pos/print_register').'" class="btn btn-default" data-toggle="ajax2">'.lang("print").'</a>';
                } elseif ($Settings->remote_printing == 2) {
                    echo '<button id="print-register-details" class="btn btn-default">'.lang("print").'</button>';
                } else {
                    echo '<button type="button" onclick="window.print();" class="btn btn-default">'.lang('print').'</button>';
                }
                ?>
                <?= form_submit('close_register', lang('close_register'), 'class="btn btn-primary"'); ?>
            </div>
        </div>
        <?= form_close(); ?>
    </div>

</div>

<?php
if ($Settings->remote_printing == 2) {
?>
<script type="text/javascript">
    var socket = null;
    $(document).ready(function() {
        try {
            socket = new WebSocket('ws://127.0.0.1:6441');
            socket.onopen = function () {
                console.log('Connected');
                return;
            };
            socket.onclose = function () {
                console.log('Connection closed');
                return;
            };
        } catch (e) {
            console.log(e);
        }
        function printRegister(data) {
            if (socket.readyState == 1) {
                socket.send(JSON.stringify({
                    type: 'print-data',
                    data: data
                }));
                return false;
            } else {
                bootbox.alert('<?= lang('pos_print_error'); ?>');
                return false;
            }
        }
        $('#print-register-details').click(function(e) {
            e.preventDefault();
            $.get('<?= site_url('pos/print_register/2'); ?>', function(regData) {
                printRegister(regData);
                return false;
            });
            return false;
        });
    });
</script>
<?php
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2({minimumResultsForSearch:6});
    });
</script>
