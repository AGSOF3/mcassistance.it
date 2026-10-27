<!DOCTYPE html>
<html>
	<head>
		<style>
			table {
				border-collapse: collapse;
				width: 100%;
				color: #1f5380;
				font-family: monospace;
				font-size: 20px;
				text-align: left;
			} 
			th {
				background-color: #1f5380;
				color: white;
			}
			tr:nth-child(even) {background-color: #f2f2f2}
		</style>
	</head>
	<body>
	<h1 onclick="document.getElementById('timbrature').style.display= 'block';">TIMBRATURE</h1>
		<table id="timbrature" style="display: none">
			<tr>
				<th>ID_AZIENDA</th>
				<th>ID_UTENTE</th>
				<th>DTA_TIMBRATURA</th>
				<th>ORA_ARRIVO</th>
				<th>ORA_USCITA</th>
				<th>ORE_TOTALI</th>
			</tr>	
			<?php
    			include 'src/it/caddit/base/connessioni/database/ConnessioneDB.php';
				$table = mysqli_query($mysqli, "SELECT * FROM timbrature ORDER BY ID_UTENTE,DTA_TIMBRATURA DESC"); 
				while($row = mysqli_fetch_array($table))
				{
			?>
			<tr>
				<td><?php echo $row["ID_AZIENDA"]; ?></td>
				<td><?php echo $row["ID_UTENTE"]; ?></td>
				<td><?php echo $row["DTA_TIMBRATURA"]; ?></td>
				<td><?php echo $row["ORA_ARRIVO"]; ?></td>
				<td><?php echo $row["ORA_USCITA"]; ?></td>
				<td><?php echo $row["ORE_TOTALI"]; ?></td>
			</tr>
			<?php
				}
			?>
		</table>
		<br><br>
		<h1>UID SCONOSCIUTI</h1>
		<table>
			<tr>
				<th>ID_AZIENDA</th>
				<th>PROGRESSIVO</th>
				<th>UID</th>
				<th>TIMESTAMP</th>
			</tr>	
			<?php
				$table = mysqli_query($mysqli, "SELECT * FROM uid_sconosciuti ORDER BY PROGRESSIVO DESC"); 
				while($row = mysqli_fetch_array($table))
				{
			?>
			<tr>
				<td><?php echo $row["ID_AZIENDA"]; ?></td>
				<td><?php echo $row["PROGRESSIVO"]; ?></td>
				<td><?php echo $row["UID"]; ?></td>
				<td><?php echo $row["TIMESTAMP_CRZ"]; ?></td>
			</tr>
			<?php
				}
			?>
		</table>
	</body>
</html>