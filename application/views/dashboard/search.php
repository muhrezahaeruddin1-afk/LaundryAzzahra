<div class="container">
    <div class="card">
        <h3>Hasil Pencarian: "<?php echo htmlspecialchars($keyword); ?>"</h3>
        
        <?php if (empty($results)): ?>
            <p style="padding: 20px; text-align: center; color: #666;">
                Tidak ditemukan hasil untuk pencarian Anda.
            </p>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Kode</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Pelanggan</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Telp</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Status</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Total</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $item): ?>
                        <tr>
                            <td style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $item->kode; ?></td>
                            <td style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $item->nama_pelanggan; ?></td>
                            <td style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $item->telp; ?></td>
                            <td style="padding: 12px; border: 1px solid #dee2e6;">
                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; 
                                    background: <?php 
                                        echo $item->status == 'SELESAI' ? '#d4edda' : 
                                               ($item->status == 'PROSES' ? '#fff3cd' : '#e2e3e5'); 
                                    ?>; 
                                    color: <?php 
                                        echo $item->status == 'SELESAI' ? '#155724' : 
                                               ($item->status == 'PROSES' ? '#856404' : '#383d41'); 
                                    ?>;">
                                    <?php echo $item->status; ?>
                                </span>
                            </td>
                            <td style="padding: 12px; border: 1px solid #dee2e6;">Rp <?php echo number_format($item->grand_total, 0, ',', '.'); ?></td>
                            <td style="padding: 12px; border: 1px solid #dee2e6;">
                                <a href="<?php echo site_url('pesanan/detail/'.$item->id); ?>" 
                                   style="background: #007bff; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo site_url('dashboard'); ?>" 
               style="background: #6c757d; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block;">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>