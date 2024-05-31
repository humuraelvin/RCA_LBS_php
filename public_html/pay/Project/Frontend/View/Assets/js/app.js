function logIn(){
  if (phone_status == 1 || passport_status == 1) {
    $('.loginSteps #step_1').addClass('dnone');
    $('.loginSteps #step_2').removeClass('dnone');
    phone_status = 0;
    passport_status = 0;
  }else{
    $.ajax({
      type: 'POST',
      url: '../request.php?q=login',
      data: $('#form').serialize(),
      success: (response) => {
        if (response == 'error') {
          $('.loginSteps #step_1').removeClass('dnone');
          $('.loginSteps #step_2').addClass('dnone');
          Swal.fire('Hata!','Kullanıcı adı ve ya şifre hatalı.','error')
        }else if(response == 'error_phone'){
          Swal.fire('Hata!','Telefon numarasını yanlış girdiniz.','error')
        }else{
          if (locate == 0) {
            window.location.reload();
          }else{
            window.location.href = 'deposit';
          }
        }
      }
    })
  }
}

function signUp(){
  $.ajax({
    type: 'POST',
    url: '../request.php?q=signup',
    data: $('#form').serialize(),
    success: (response) => {
      if (response == 'error') {
        Swal.fire('Hata!','Bilgileri doğru girdiğinizden emin olun','error');
      }else{
        if (locate == 0) {
          window.location.reload();
        }else{
          window.location.href = 'deposit';
        }
      }
    }
  })
}

function logout(){
  $.ajax({
    type:'POST',
    url:'../request.php?q=logout',
    success: () => {window.location.href='/m'}
  })
}

function loginorpay(){
  if(logged){window.location.href='/m/deposit';}
  else{window.location.href='/m/login';}
}

function openzopim(){
  $zopim.livechat.window.openPopout();
}
