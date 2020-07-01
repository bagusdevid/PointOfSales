<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {

		function resi(x) {
            var baru = 'Proses Paking';
            var dikirim = 'Sudah Dikirim';
			
            if (x == '' || x == null) {
                return '<div class="text-center"><span class="sale_status label label-danger">'+baru+'</span></div>';
            }  else {
                return '<div class="text-center"><span class="sale_status label label-success">'+dikirim+'</span></div>';
            }
        }

        var table = $('#SLData').DataTable({

            'ajax' : { url: '<?=site_url('welcome/get_sales');?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true,
            exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "id", "visible": false },
            { "data": "date", "render": hrld },
            { "data": "customer_name" },
            { "data": "total", "render": currencyFormat },
            { "data": "total_discount", "render": currencyFormat },
            { "data": "grand_total", "render": currencyFormat },
			{ "data": "resi", "render": resi },
            { "data": "resi" },
            { "data": "Actions", "searchable": false, "orderable": false }
            ],
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
                nRow.id = aData.id;
                return nRow;
            },
			"footerCallback": function (  tfoot, data, start, end, display ) {
                var api = this.api(), data;
                $(api.column(3).footer()).html( cf(api.column(3).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
                $(api.column(4).footer()).html( cf(api.column(4).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
                $(api.column(5).footer()).html( cf(api.column(5).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
            }
        });

        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

        table.columns().every(function () {
            var self = this;
            $( 'input.datepicker', this.footer() ).on('dp.change', function (e) {
                self.search( this.value ).draw();
            });
            $( 'input:not(.datepicker)', this.footer() ).on('keyup change', function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (((code == 13 && self.search() !== this.value) || (self.search() !== '' && this.value === ''))) {
                    self.search( this.value ).draw();
                }
            });
            $( 'select', this.footer() ).on( 'change', function (e) {
                self.search( this.value ).draw();
            });
        });

    });
</script>

<script src="<?= $assets ?>plugins/highchart/highcharts.js"></script>

<?php
if ($chartData) {
    foreach ($chartData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $sales[] = $month_sale->total;
        $tax[] = $month_sale->tax;
        $discount[] = $month_sale->discount;
    }
} else {
    $months[] = '';
    $sales[] = '';
    $tax[] = '';
    $discount[] = '';
}
?>

<script type="text/javascript">

    $(document).ready(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        <?php if ($chartData) { ?>
        $('#chart').highcharts({
            chart: { },
            credits: { enabled: false },
            exporting: { enabled: false },
            title: { text: '' },
            xAxis: { categories: [<?php foreach($months as $month) { echo "'".$month."', "; } ?>] },
            yAxis: { min: 0, title: "" },
            tooltip: {
                shared: true,
                followPointer: true,
                headerFormat: '<div class="well well-sm" style="margin-bottom:0;"><span style="font-size:12px">{point.key}</span><table class="table table-striped" style="margin-bottom:0;">',
                pointFormat: '<tr><td style="color:{series.color};padding:4px">{series.name}: </td>' +
                '<td style="color:{series.color};padding:4px;text-align:right;"> <b>{point.y}</b></td></tr>',
                footerFormat: '</table></div>',
                useHTML: true, borderWidth: 0, shadow: false,
                style: {fontSize: '14px', padding: '0', color: '#000000'}
            },
            plotOptions: {
                series: { stacking: 'normal' }
            },
            series: [{
                type: 'column',
                name: '<?= $this->lang->line("tax"); ?>',
                data: [<?= implode(', ', $tax); ?>]
            },
            {
                type: 'column',
                name: '<?= $this->lang->line("discount"); ?>',
                data: [<?= implode(', ', $discount); ?>]
            },
            {
                type: 'column',
                name: '<?= $this->lang->line("sales"); ?>',
                data: [<?= implode(', ', $sales); ?>]
            }
            ]
        });
        <?php } ?>
        <?php if ($topProducts) { ?>
$('#chart2').highcharts({
    chart: { },
    title: { text: '' },
    credits: { enabled: false },
    exporting: { enabled: false },
    tooltip: {
        shared: true,
        followPointer: true,
        headerFormat: '<div class="well well-sm" style="margin-bottom:0;"><span style="font-size:12px">{point.key}</span><table class="table table-striped" style="margin-bottom:0;">',
        pointFormat: '<tr><td style="color:{series.color};padding:4px">{series.name}: </td>' +
        '<td style="color:{series.color};padding:4px;text-align:right;"> <b>{point.y}</b></td></tr>',
        footerFormat: '</table></div>',
        useHTML: true, borderWidth: 0, shadow: false,
        style: {fontSize: '14px', padding: '0', color: '#000000'}
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    },

    series: [{
        type: 'pie',
        name: '<?=$this->lang->line('total_sold')?>',
        data: [
        <?php
        foreach($topProducts as $tp) {
            echo "['".$tp->product_name." (".$tp->product_code.")', ".$tp->quantity."],";

        } ?>
        ]
    }]
});
<?php } ?>
});

</script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('quick_links'); ?></h3>
                </div>
                <div class="box-body">
                    <?php if ($this->session->userdata('store_id')) { ?>
                    <a class="btn btn-app" href="<?= site_url('pos'); ?>">
                        <i class="fa fa-th"></i> <?= lang('pos'); ?>
                    </a>
                    <?php } ?>
                    <a class="btn btn-app" href="<?= site_url('products'); ?>">
                        <i class="fa fa-barcode"></i> <?= lang('products'); ?>
                    </a>
                    <?php if ($this->session->userdata('store_id')) { ?>
                    <a class="btn btn-app" href="<?= site_url('sales'); ?>">
                        <i class="fa fa-shopping-cart"></i> <?= lang('sales'); ?>
                    </a>
                    <?php } ?>
                    <a class="btn btn-app" href="<?= site_url('categories'); ?>">
                        <i class="fa fa-folder-open"></i> <?= lang('categories'); ?>
                    </a>
                    <a class="btn btn-app" href="<?= site_url('customers'); ?>">
                        <i class="fa fa-users"></i> <?= lang('customers'); ?>
                    </a>
                    <?php if ($Admin) { ?>
                    <a class="btn btn-app" href="<?= site_url('settings'); ?>">
                        <i class="fa fa-cogs"></i> <?= lang('settings'); ?>
                    </a>
                    <a class="btn btn-app" href="<?= site_url('reports'); ?>">
                        <i class="fa fa-bar-chart-o"></i> <?= lang('reports'); ?>
                    </a>
                    <a class="btn btn-app" href="<?= site_url('users'); ?>">
                        <i class="fa fa-users"></i> <?= lang('users'); ?>
                    </a>
                    <?php if ($this->db->dbdriver != 'sqlite3') { ?>
                    <a class="btn btn-app" href="<?= site_url('settings/backups'); ?>">
                        <i class="fa fa-database"></i> <?= lang('backups'); ?>
                    </a>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-primary">
						<div class="box-body">
							<div class="table-responsive">
								<table id="SLData" class="table table-striped table-bordered table-condensed table-hover">
									<thead>
										<tr class="active">
											<th style="max-width:30px;"><?= lang("id"); ?></th>
											<th class="col-xs-2"><?= lang("date"); ?></th>
											<th><?= lang("customer"); ?></th>
											<th class="col-xs-1"><?= lang("total"); ?></th>
											<th class="col-xs-1"><?= lang("discount"); ?></th>
											<th class="col-xs-1"><?= lang("grand_total"); ?></th>
											<th class="col-xs-1"><?= lang("status"); ?></th>
											<th class="col-xs-1">Nomor Resi</th>
											<th style="min-width:115px; max-width:115px; text-align:center;"><?= lang("actions"); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										   <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
									   </tr>
								   </tbody>
								   <tfoot>
										<tr class="active">
											<th style="max-width:30px;"><input type="text" class="text_filter" placeholder="[<?= lang('id'); ?>]"></th>
											<th class="col-sm-2"><span class="datepickercon"><input type="text" class="text_filter datepicker" placeholder="[<?= lang('date'); ?>]"></span></th>
											<th class="col-sm-2"><input type="text" class="text_filter" placeholder="[<?= lang('customer'); ?>]"></th>
											<th class="col-sm-1"><?= lang("total"); ?></th>
											<th class="col-sm-1"><?= lang("discount"); ?></th>
											<th class="col-sm-2"><?= lang("grand_total"); ?></th>
											<th class="col-sm-1">
												<select class="select2 select_filter"><option value=""><?= lang("all"); ?></option><option value="Baru">Baru</option><option value="Dikirim">Dikirim</option></select>
											</th>
											<th class="col-sm-2"><input type="text" class="text_filter" placeholder="[Nomor Resi]"></th>
											<th class="col-sm-1"><?= lang("actions"); ?></th>
										</tr>
										<tr>
											<td colspan="10" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= lang('sales_chart'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div id="chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= lang('top_products').' ('.date('F Y').')'; ?></h3>
                        </div>
                        <div class="box-body">
                            <div id="chart2" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/moment.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datetimepicker({format: 'YYYY-MM-DD', showClear: true, showClose: true, useCurrent: false, widgetPositioning: {horizontal: 'auto', vertical: 'bottom'}, widgetParent: $('.dataTable tfoot')});
    });
</script>

