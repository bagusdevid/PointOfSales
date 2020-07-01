<html>
<head>
	<title>No Resi</title>
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
<body>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
				<th>Nama</th>
			
				<th>Checkout</th>
				<th>Expedisi</th>
                <th>Nomor Resi</th>
                <th>Tgl Input</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 1;
				foreach ($resi as $data):                     
			?>
			<tr id='row_<?php echo $data['id'];?>'>
				<td><?php echo $sl++;?></td>
				<td><strong><?php echo $data['customer_name'];?></strong></td>
			
				<td align="center"><?php echo $data['date'];?></td>
				<td align="center"><?php echo $data['kurir'];?></td>
				<td align="center"><?php echo $data['resi'];?></td>
				<td align="center"><?php echo $data['tgl_input'];?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
    </table>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 50
    });
} );
</script>
</body>
</html>