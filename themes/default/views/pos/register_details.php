<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <button type="button" class="close mr10" onclick="window.print();"><i class="fa fa-print"></i></button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('register_details').' ('.lang('opened_at').': '.$this->izi->hrld($this->session->userdata('register_open_time')).')'; ?></h4>
        </div>
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

                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><strong><?= lang('total_cash'); ?></strong>:</h4>
                    </td>
                    <td style="text-align:right;"><h4>
                            <span><strong><?= $cashsales->paid ? $this->izi->formatMoney($cashsales->paid + ($this->session->userdata('cash_in_hand')) - ($expenses->total ? $expenses->total : 0.00)) : $this->izi->formatMoney($this->session->userdata('cash_in_hand') - ($expenses->total ? $expenses->total : 0.00)); ?></strong></span>
                        </h4></td>
                </tr>
            </table>
        </div>
    </div>

</div>
