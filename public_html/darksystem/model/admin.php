<?php
class  admin extends model{
  function __construct(){
      parent::model();
	  $this->cookie=$this->load->library("cookie");
	  $this->user=$this->load->library("user");



  }
  function logout(){
	$this->cookie->set("username","");
	$this->cookie->set("password","");
	unset($_SESSION["altim_id"]);
	session_destroy();
	$this->user_id=0;
  }

  function user_info(){

        $NewDatabase = new NewDatabase();
        $pdo = $NewDatabase->getConnection();

        $users = explode("__",security(@$_SESSION['username']));

        $user_find = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        $user_find->execute([@$users[1],@$users[2]]);

        if ($user_find->rowCount() > 0) {
            return $user_find->fetch(PDO::FETCH_OBJ);
        } else {
            setcookie("username", "");
            session_destroy();
            return false;
        }
  }



  function is_login(){

	 // cookie aliyoruz
	 $giren = @$_SESSION['username'];

      $giren = security($giren);

      // parcaliyoruz
	 $users	=	explode("__",$giren);
	 $password=$users[2];
	 if(isset($users[1]) and isset($password)){
		 // db ariyoruz
		  @$count = end($this->db->aresult("select count(id) from admin where username='$users[1]' and password='$password'"));
		  if ($count == 0) {
				// yoksa cookie temizliyoruz + yonlendiriyoruz.
				setcookie("username", "");
				session_destroy();
				echo '<script>window.location.assign("/sports/logout");</script>';
		  } else {


			  $session = $this->db->aresult("select * from admin_session where id='".$users[0]."'");
			  $user = $this->db->aresult("select * from admin where username='$users[1]' and password='$password'");

			  if ( $user['durum'] == 0 ) {
				//$this->db->update("admin_session",array("last_active"=>time()),array("id"=>$session["id"]));

				  $this->user_id=$user["id"];
				  $this->session_id=$user["id"];
				  $this->type=$user["type"];
				  $this->userinfo=$user;

				  $error="0";
			  } else {
				 setcookie("username", "");
				 session_destroy();
				 $error = "0";
				 echo '<script>window.location.assign("/sports/logout");</script>';
			  }

		 }
	 }else{
		$error=1;
	 }
	return $error;

  }
  function canlibot($id=null){


       $id = security($id);


       if($id==null){$id=$this->user_id;$this->canlibot="";}
	$ids=$this->db->aresult("select parent,canlibot from admin where id='".$id."'");
	if($ids["canlibot"]){
		return $ids["canlibot"];
	}else{
		 if($ids["parent"]==0){
			return "";
		 }else{
			return $this->canlibot($ids["parent"]);
		 }
	 }
  }
  function log($baslik,$tutar,$user=false){
	if($user==false){
		$user=$this->user_id();
	}else{
		if(isset($this->userinfo["username"])){
			$baslik=$baslik." ( İşlemi Yapan : ".$this->userinfo["username"].")";
		}
	}
	$bilgi=$this->db->aresult("select * from admin where id='".$user."'");
	$this->db->insert("log",array("userid"=>$user,"tarih"=>date("Y-m-d H:i:s"),"tutar"=>$tutar,"islemad"=>$baslik,"oncekibakiye"=>$bilgi["bakiye"]-$tutar,"sonrakibakiye"=>$bilgi["bakiye"]));
  }
  function user_id(){
	return $this->user_id;
  }
  function session_id(){
	return $this->session_id;
  }
  function ustum($id=null,$bosalt=null){
	if($this->user_id()==false && $id==NULL){$this->ustum=array(0);return $this->ustum;}
	if($id==null){$id=$this->user_id();$this->ustum=array($id);}
	if($bosalt==1){$this->ustum=array($id);}
	$ids=$this->db->aresult("select parent from admin where id='".$id."' and sil=0");
	 if($ids["parent"] || $ids["parent"]=="0") $this->ustum[]=$ids["parent"];
	 if($ids["parent"]==0){
		return $this->ustum;
	 }else{
		return $this->ustum($ids["parent"]);
	 }
  }
  function altim($id=null,$bosalt=null){
	if($id==null){
		if($_SESSION["altim_id"]) return $_SESSION["altim_id"];
		$id=$this->user_id();
		$this->altim=array($id);
		$cache=1;
	}
	if($bosalt==1){$this->altim=array($id);}
	$ids=$this->db->result("select id from admin where parent='".$id."' and sil=0");
	foreach($ids as $z){
	    $this->altim[]=$z["id"];
		$this->altim($z["id"]);
	 }
	if($cache==1) $_SESSION["altim_id"]=$this->altim;
	return $this->altim;
  }
  function tumaltim($id=null,$bosalt=null){
	if($id==null){$id=$this->user_id();$this->tumaltim=array($id);}
	if($bosalt==1){$this->tumaltim=array($id);}
	$ids=$this->db->result("select id from admin where parent='".$id."'");
	foreach($ids as $z){
	    $this->tumaltim[]=$z["id"];
		$this->tumaltim($z["id"]);
	 }
	return $this->tumaltim;
  }
  function get_type(){
	return $this->type;
  }
  function getinfo($name=false){
	if($name==false){
		return	$this->userinfo;
	}else{
		return	$this->userinfo[$name];
	}
  }
}
?>