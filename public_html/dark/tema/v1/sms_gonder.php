<header class="page-header">
	<h2><i class="fa fa-mobile-phone"></i> SMS Gönder</h2>
</header>

<div class="row">
	<fieldset>
		<div class="form-group">
			<label for="">Kullanıcı: </label>
			<input type="text" class="form-control" id="autoComplete_user" />
			<input type="hidden" name="kullanici" id="kullanici" />
		</div>
		<div class="form-group">
			<div class="wizard-progress wizard-progress-lg">
				<div class="steps-progress">
					<div class="progress-indicator" style="width: 0%;"></div>
				</div>
				<ul class="wizard-steps">
					<li></li>
					<li class="active">
						<a href="#w4-profile" data-toggle="tab"><span style="font-size: 12px">Ya da</span>Manuel</a>
					</li>
					<li></li>
				</ul>
			</div>
		</div>
		<div class="form-group">
			<label for="">Telefon: </label>
			<input id="phone" data-plugin-masked-input="" data-input-mask="(9999) 999-99-99" placeholder="(0999) 999-99-99" class="form-control">
		</div>
		<div class="form-group">
			<label for="">Mesaj: </label>
			<textarea name="mesaj" id="mesaj" cols="30" rows="5" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-success admin-action" data-action="adminBakiyeGonder" data-id="23329"><i class="fa fa-send"></i> Yolla</button>
		</div>
	</fieldset>
</div>