<table class="table" id="talepDetayForm">
	<tr>
		<td>Tarih: </td>
		<td><?php echo $talep['tarih']; ?></td>
	</tr>
	<tr>
		<td>Üye: </td>
		<td><?php echo $kullanici['username']; ?></td>
	</tr>
	<tr>
		<td>Ad Soyad: </td>
		<td><?php echo $kullanici['name']; ?></td>
	</tr>
	<tr>
		<td>TC: </td>
		<td><?php echo $kullanici['tc']; ?></td>
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
		<td>İşlem No: </td>
		<td><?php echo $talep['islemno']; ?></td>
	</tr>
	<tr>
		<td>Tür: </td>
		<td><?php echo $talep['tur']; ?></td>
	</tr>
	<tr>
		<td>Açıklama: </td>
		<td><?php echo $talep['aciklama']; ?></td>
	</tr>
	<tr>
		<td>Müşteri Notu: </td>
		<td><?php echo $talep['note']; ?></td>
	</tr>
</table>