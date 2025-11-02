// contoh kecil: klik Back balik ke halaman sebelumnya
document.addEventListener('DOMContentLoaded', function(){
  var back = document.querySelector('.back-btn');
  if(back){
    back.addEventListener('click', function(){
      // kalau ada riwayat, mundur; kalau tidak, ke halaman awal /myproject
      if(window.history.length > 1){ window.history.back(); }
      else{ window.location.href = '/myproject'; }
    });
  }
});
