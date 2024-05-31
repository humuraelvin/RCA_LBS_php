<!-- style -->
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style type="text/css">
	.timeline-item {
	  padding: 3em 2em 2em;
	  position: relative;
	  color: red;
	  border-left: 2px solid rgba(0, 0, 0, 0.3);
	}
	.timeline-item a {
	  font-size: 21px;
	  color: #333;
	}
	.timeline-item::before {
	  content: attr(date-is);
	  position: absolute;
	  left: 2em;
	  font-weight: bold;
	  top: 1em;
	  display: block;
	  font-family: 'Raleway', sans-serif;
	  font-weight: 700;
	  font-size: 1em;
	}
	.timeline-item::after {
	  width: 10px;
	  height: 10px;
	  display: block;
	  top: 1em;
	  position: absolute;
	  left: -7px;
	  border-radius: 10px;
	  content: '';
	  border: 2px solid rgba(0, 0, 0, 0.3);
	  background: white;
	}
	.timeline-item:last-child {
	  -o-border-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 60%, transparent) 1 100%;
		 border-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.3) 60%, transparent) 1 100%;
		 border-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 60%, transparent) 1 100%;
	}
</style>
<!-- #style -->

<!-- script -->
<script type="text/javascript">
$(function(){
	$.getIpUsers = function(Arr){
		$(".kullanicilar").html('<div class="fa fa-spinner fa-spin"></div>');
		$.ajax({
			type: "POST",
			url: SITE_URL + "/ajax/admin.ajax.php",
			dataType: "json",
			data: Arr,
			success: function(c) {
				$(".kullanicilar").html('');
				Object.keys(c.list).forEach(function(key, val) {
					// users
					var $ListContent = "<div class=\"timeline-item\" date-is='"+ key +"'>";
					for ( var $i = 0; $i < c.list[key].length; $i++ ) {
						if ( c.list[key][$i] ) {
							$ListContent += '<a target="_blank" href="'+ SITE_URL +'/profil/'+ c.list[key][$i]['id'] +'">'+ c.list[key][$i]['username'] +'</a><br />';
						}
					}
					$ListContent += "</div>";
					$(".kullanicilar").append( $ListContent );
					//console.log(c.list[key][1]);
				});
			}
		});
	}

	$.getIpUsers({
		"tip": "ipUsers",
		"date": [
			"<?php echo date('d-m-Y'); ?>",
			"<?php echo date('d-m-Y', strtotime("+1 day")); ?>"
		]
	});

	$(".getIpUserList").on('click', function(){
		$.getIpUsers({
			"tip": "ipUsers",
			"date": [
				$("input[name=baslangic]").val(),
				$("input[name=bitis]").val()
			]
		});
	});
});
</script>
<!-- #script -->

<header class="page-header">
	<h2><i class="fa fa-info" style="color: red"></i> Kullanıcı Yakala!</h2>
</header>

<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">

		<fieldset>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Başlangıç Tarihi: </label>
						<input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>" name="baslangic">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Bitiş Tarihi: </label>
						<input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d', strtotime("+1 day")); ?>" name="bitis">
					</div>
				</div>
			</div>
			<hr class="dotted short">
			<div class="row">
				<div class="col-md-3">
					<button class="btn btn-primary getIpUserList">Listele</button>
				</div>
			</div>
			<hr class="dotted short">
		</fieldset>
	
		<div class="kullanicilar"></div>

		<!-- <div class="timeline-item" date-is='20-07-1990'>
			<h1>Hello, 'Im a single div responsive timeline without mediaQueries!</h1>
			<p>
				I'm speaking with myself, number one, because I have a very good brain and I've said a lot of things. I write the best placeholder text, and I'm the biggest developer on the web by far... While that's mock-ups and this is politics, are they really so different? I think the only card she has is the Lorem card.
			</p>
		</div> -->
		
	</div>