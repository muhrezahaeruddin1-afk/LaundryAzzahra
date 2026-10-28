    </div> <!-- /.container-fluid -->
  </section>
</div> <!-- /.content-wrapper -->

<footer style="background:#fff; border-top:1px solid #e9eef5; padding:8px 0; color:#555; text-align:center; width:100%;">
  <strong>© <?= date('Y'); ?> Kelompok 4</strong>
</footer>


</div> <!-- /.wrapper -->

<!-- ===== JS CDN (urutannya penting) ===== -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- Optional libs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>

<script>
  // ===== Global Search (Enter untuk cari) =====
  (function () {
    var qs = document.getElementById('qsearch');
    if (!qs) return;
    qs.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var q = this.value.trim();
        if (q) window.location = "<?= site_url('search?q='); ?>" + encodeURIComponent(q);
      }
    });
  })();

  // ===== Chart 7 hari terakhir (jalan kalau elemen & data ada) =====
  (function () {
    var el = document.getElementById('chartPesanan');
    if (!el) return;

    var labels = <?= isset($chart_labels) ? json_encode($chart_labels) : '[]' ?>;
    var dataCount = <?= isset($chart_counts) ? json_encode($chart_counts) : '[]' ?>;
    var dataOmzet = <?= isset($chart_omzets) ? json_encode($chart_omzets) : '[]' ?>;

    // Guard kalau data kosong
    if (!labels.length) return;

    new Chart(el, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          { label: 'Pesanan', data: dataCount, fill: false, tension: .35, borderWidth: 2 },
          { label: 'Omzet (Rp)', data: dataOmzet, fill: false, tension: .35, borderWidth: 2, yAxisID: 'y1' }
        ]
      },
      options: {
        plugins: { legend: { display: true } },
        scales: {
          y:  { beginAtZero: true, ticks: { stepSize: 1 } },
          y1: { beginAtZero: true, position: 'right' }
        }
      }
    });
  })();

  // ===== Toastr flash message (jika ada) =====
  (function () {
    <?php $ci =& get_instance(); ?>
    <?php if (!empty($ci->session) && $ci->session->flashdata('ok')): ?>
      toastr.success("<?= $ci->session->flashdata('ok'); ?>");
    <?php endif; ?>
    <?php if (!empty($ci->session) && $ci->session->flashdata('err')): ?>
      toastr.error("<?= $ci->session->flashdata('err'); ?>");
    <?php endif; ?>
  })();
</script>

</body>
</html>
