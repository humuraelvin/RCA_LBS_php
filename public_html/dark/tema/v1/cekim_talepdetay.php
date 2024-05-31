<table class="table">
	<tr>
		<td>Açıklama: </td>
		<td><?php echo $talep['aciklama']; ?></td>
	</tr>
</table>
<table class="table" id="talepDetayForm">
	<tr>
		<td>No: </td>
		<td><input class="form-control input-sm" readonly type="text" value="<?php echo $talep['id']; ?>" /></td>
	</tr>
	<tr>
		<td>Ad Soyad: </td>
		<td><input class="form-control input-sm" readonly type="text" value="<?php echo $kullanici['name']; ?>" /></td>
	</tr>
	<tr>
		<td>TC: </td>
		<td><input class="form-control input-sm" readonly type="text" value="<?php echo $kullanici['tc']; ?>" /></td>
	</tr>
	<tr>
		<td>Miktar: </td>
		<td><?php echo $talep['miktar']; ?></td>
	</tr>
	<tr>
		<td>Banka: </td>
		<td><?php echo $talep['banka']; ?></td>
	</tr>
	<tr>
		<td>Tür: </td>
		<td><?php echo $talep['turu']; ?></td>
	</tr>
	<tr>
		<td>Hesap NO: </td>
		<td><?php echo $talep['hesap']; ?></td>
	</tr>
	<tr>
		<td>Şube: </td>
		<td><?php echo $talep['sube']; ?></td>
	</tr>
	<tr>
		<td>IBANN: </td>
		<td><?php echo (empty($talep['iban'])) ? 'IBANN bulunmamaktadir.' : $talep['iban']; ?></td>
	</tr>
	<tr>
		<td>Not: </td>
		<td><textarea name="notttttt" id="notttttt" cols="30" rows="10" class="form-control"><?php echo $talep['notttttt']; ?></textarea></td>
	</tr>
</table>