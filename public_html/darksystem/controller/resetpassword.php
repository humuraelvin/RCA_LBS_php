<?php



class resetpassword extends controller {



	function __construct() {

        parent::controller();

        $this->admin = $this->load->model("admin");

		$this->user = $this->load->library("user");

		$this->cookie = $this->load->library("cookie");



   

    }



    function forget() {

    	

        $user = $this->admin->getinfo();

        $login = $this->admin->is_login();

        $userid = $this->admin->user_id();

        $bilgi = $this->db->aresult("select * from admin where id='$userid'");

        $this->view->display("fargot.tpl", get_defined_vars());

    }



    function password($token) {



        $user = $this->admin->getinfo();

        $login = $this->admin->is_login();

        $userid = $this->admin->user_id();

        $bilgi = $this->db->aresult("select * from admin where id='$userid'");

        $this->view->display("sifirla.tpl", get_defined_vars());

    	

    }

    function sifirla ()

    {

    	 $token = security($_POST['token']);

    	 $password = security($_POST['password']);

    	 $password2 = security($_POST['password2']);



    	 if ($password != $password2) die("Parolalar eşleşmiyor.");



    	 if (strlen($password) > 10) die("Şifreniz 10 Karakterden Uzun Olamaz");



    	 $bilgi = $this->db->aresult("select password, id from admin where token='$token'");



    	 $newpassword = md5($password);



    	 $id =  $bilgi['id'];



    	 if (empty($id)) die("Geçersiz Token.");



    	$tokenz = '';

    	$length = '70';

	    $keys = array_merge(range(0, 9), range('a', 'z'));

	    for ($i = 0; $i < $length; $i++) {

	        $tokenz .= $keys[array_rand($keys)];

	    }



		$update = $this->db->query("update admin set password = '$newpassword', token = '$tokenz' where id='$id' ");	



		if ($update) {

		 	echo "Şifreniz Güncellenmiştir. Giriş Yapabilirsiniz.";

		}

		else { echo "Bir Hata Oluştu"; }

    }



    function reset() {



    $alicimail = security($_POST['mail']); 



    $username = security($_POST['username']); 



    $bilgi = $this->db->aresult("select token, id from admin where email='$alicimail' && username = '$username' ");



   	$tokencik =  $bilgi['token'];   	



	$id =  $bilgi['id'];



	if (empty($tokencik)) die("Kullanıcı Bulunamadı.");

		

    $token = '';$length = '70';

    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {

        $token .= $keys[array_rand($keys)];

    }



   	$this->db->query("update admin set token = '$token' where id='$id'");



	$url = "http://".$_SERVER["HTTP_HOST"]."/resetpassword/password/".$token;

	$mesaj = "Şifre değiştirme talebiniz kabul edilmiştir. </br>Yeni şifremi girmek için gösterilen linke tıklayınız.Linke tıklayamıyorsanız linki kopyalayarak tarayıcınızın adres çubuğuna yapıştırınız. </br> ".$url;



	function HTMLMail($gidecekMail,$gonderenAd,$gonderenMail,$konu,$mesaj) {

		$headers  = "MIME-Version: 1.0\n";

		$headers .= "Content-type: text/html; charset=UTF-8\n";

		$headers .= "X-Mailer: PHP\n";

		$headers .= "X-Sender: PHP\n";

		$headers .= "From: $gonderenAd<$gonderenMail>\n";

		$headers .= "Reply-To: $gonderenAd<$gonderenMail>\n";

		$headers .= "Return-Path: $gonderenAd<$gonderenMail>\n";

		mail($gidecekMail,$konu,$mesaj,$headers);

		}



		HTMLMail("$alicimail", SITE_NAME, SITE_MAIL, "Yeni Sifre Talimatlari", "$mesaj");



		echo "Şifre Sıfırlama Maili Gönderildi.";



	}



}



?>