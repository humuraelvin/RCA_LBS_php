<style type="text/css">
table.maclars a {color: #fff}
table.maclars input[type="text"] {color: #333;}
td, th  {padding: 10px}
</style>
<form id="macDuzenleForm">
	<table class='maclars hesabim'>
		<?php $at = $db->query("select * from mac_oran where macid='$id' ")->fetch(); ?>	
		<tr>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<div align='right'>1. Oran:</div>
			</td>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<input   style='width:70px' value='<?php echo $at["1"]; ?>' name="1" class='adim input sonucs2 form-control'/>				
			</td>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<div align='right'>0. Oran:</div>
			</td>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<input   style='width:70px' value='<?php echo $at["0"]; ?>' name="0" class='adim input sonucs2 form-control'/>			
			</td>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<div align='right'>2. Oran:</div>
			</td>
			<td clasas='hesabim-td-baslik'  style="background:#D3BB8F; color: #fff;">
				<input   style='width:70px' value='<?php echo $at["2"]; ?>' name="2" class='adim input sonucs2 form-control orans	'/>				
			
			</td>
		</tr>

	</table>
<form>