<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $page_title . " No " . $inv->id; ?></title>
	<base href="<?= base_url() ?>"/>
	<meta http-equiv="cache-control" content="max-age=0"/>
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta http-equiv="expires" content="0"/>
	<meta http-equiv="pragma" content="no-cache"/>
	<link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
	<link href="<?= $assets ?>dist/css/kirim.css" rel="stylesheet" type="text/css" />
	
	<link href="<?= $assets ?>dist/css/print.css" rel="stylesheet" type="text/css" />
	<style type="text/css" media="all">
                        body { color: #000; }
                        #page-wrap { max-width: 470px; margin: 0 auto; padding-top: 20px; }
                        .btn { margin-bottom: 5px; }
                        .table { border-radius: 3px; }
                        .table th { background: #f5f5f5; }
                        .table th, .table td { vertical-align: middle !important; }
                        h3 { margin: 5px 0; }

                        @media print {
                            .no-print { display: none; }
                            #page-wrap { max-width: 470px; width: 100%; min-width: 250px; margin: 0 auto; }
							#atas { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }
                        }
                    </style>
</head>

<body>
	<div id="page-wrap">
		<!--<div id="atas">AIKOGAMIS</div>-->
		<div id="customer">
            <div id="customer-title"><?= $customer->nama_pengirim; ?><br><?= $customer->no_pengirim; ?></div>
            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td>000<?= $inv->id; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Tanggal</td>
                    <td><textarea id="date"><?= $this->izi->hrld($inv->date); ?></textarea></td>
                </tr>
            </table>
		</div>
		
		<table id="items">
			<tr>
				<th>Alamat Tujuan</th>
			</tr>
			<tr class="item-row">
				<td class="item-name">
					<strong><?= $customer->name; ?></strong><br>
					<?= nl2br($customer->address); ?><br>
					Telepon: <strong><?= $customer->phone; ?></strong><br><br>
				</td>
			</tr>
		</table>
		
		<table id="items">
			<tr>
				<th>Daftar Produk</th>
			</tr>
			<tr class="item-row">
				<td class="item-name">
				<?php
                foreach ($rows as $row) {
					echo '('.$this->izi->formatQuantity($row->quantity).') '. $row->product_name .'<br>';
                }
                ?>
				</td>
			</tr>
		</table>
		<table id="items">
			<tr>
				<th>Pengiriman</th>
			</tr>
			<tr class="item-row">
				<td class="item-name">
				<strong><?= $customer->kurir; ?> - <?= $customer->layanan; ?></strong>
				</td>
			</tr>
		</table>
		
		<div id="terms">
		  <h5></h5>
		  Terima kasih atas kepercayaan Anda berbelanja di toko kami.
		</div>
		<div id="buttons" style="padding-top:30px; text-align:center; text-transform:uppercase;" class="no-print">
		<a onclick="window.print();" class="button">Cetak Pengiriman</a>
		<a class="button" href="<?= site_url('pos'); ?>"><?= lang("back_to_pos"); ?></a>
		<div style="clear:both;"></div>
		</div>
	</div>
	
	
</body>
</html>