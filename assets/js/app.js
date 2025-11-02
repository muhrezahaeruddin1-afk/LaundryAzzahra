(function () {
  'use strict';

  // --- bantu-bantu kecil ---
  const $ = s => document.querySelector(s);
  const formatRp = n => 'Rp ' + (n|0).toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.');

  // ambil URL API dari PHP (sudah kita tanam di langkah 2)
  const API_URL = window.API_STATS || ((window.APP_BASE||'') + '/api/dashboard/stats');

  // animasi angka biar hidup
  function anim(el, to, withRp=false){
    const from = +((el.dataset.val)||el.textContent.replace(/[^\d]/g,'')||0);
    const start = performance.now(), dur = 350;
    function step(t){
      const p = Math.min(1,(t-start)/dur);
      const val = Math.round(from + (to-from)*p);
      el.textContent = withRp ? formatRp(val) : val;
      if(p<1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
    el.dataset.val = to;
  }

  // tombol back
  function initBack(){
    const back = document.querySelector('.back-btn');
    if(!back) return;
    back.addEventListener('click', e=>{
      e.preventDefault();
      if(history.length>1) history.back(); else location.href = (window.APP_BASE || '/');
    });
  }

  // ambil data KPI tiap 20 detik
  async function getStats(){
    try {
      const r = await fetch(API_URL, {headers:{'Accept':'application/json'}});
      if(!r.ok) throw new Error(r.status);
      return await r.json();
    } catch(e){
      // kalau API belum ada, pakai angka acak sementara
      return {
        masuk: Math.floor(Math.random()*3),
        proses: Math.floor(Math.random()*2),
        selesai: Math.floor(Math.random()*2),
        pendapatan: 2000*(50+Math.floor(Math.random()*50))
      };
    }
  }

  async function updateKpi(){
    const s = await getStats();
    const eMasuk = $('#kpi-masuk');
    const eProses = $('#kpi-proses');
    const eSelesai = $('#kpi-selesai');
    const ePend = $('#kpi-pendapatan');
    eMasuk   && anim(eMasuk,   +s.masuk);
    eProses  && anim(eProses,  +s.proses);
    eSelesai && anim(eSelesai, +s.selesai);
    ePend    && anim(ePend,    +s.pendapatan, true);
  }

  document.addEventListener('DOMContentLoaded', ()=>{
    console.log('app.js LOADED'); // cek di Console
    initBack();
    updateKpi();                 // jalankan pertama kali
    setInterval(updateKpi,20000); // lalu setiap 20 detik
  });
})();
