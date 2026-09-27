<?= view('Template/Header'); ?>
<?= view('Template/SideNav'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  * {
    box-sizing: border-box;
  }

  .content-area {
    padding: clamp(22px, 3vw, 42px);
    margin-left: 300px;
    margin-top: 58px;
    min-height: calc(100vh - 90px);
    background:
      radial-gradient(circle at 8% 10%, rgba(120, 170, 255, 0.35) 0%, rgba(120, 170, 255, 0) 45%),
      radial-gradient(circle at 92% 15%, rgba(160, 130, 255, 0.28) 0%, rgba(160, 130, 255, 0) 45%),
      radial-gradient(circle at 50% 100%, rgba(90, 200, 220, 0.25) 0%, rgba(90, 200, 220, 0) 50%),
      linear-gradient(160deg, #eaf2fd 0%, #dfeaf9 50%, #e7effc 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .content-area h4 {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
  }

  .content-area h4::before {
    content: "\f06b";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #a855f7, #7c3aed);
    color: #fff;
    font-size: 15px;
    box-shadow: 0 6px 16px rgba(168, 85, 247, 0.4);
    flex-shrink: 0;
  }

  .content-area h4 small {
    font-weight: 700;
    font-size: 20px;
    letter-spacing: 0.4px;
    color: #1f2937;
  }

  .content-area hr {
    border: none;
    height: 1px;
    background: linear-gradient(90deg, rgba(100, 130, 200, 0.35), rgba(100, 130, 200, 0));
    margin: 20px 0 26px 0;
  }

  /* ---------- Action buttons ---------- */
  .btn-primary,
  .btn-success {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.2px;
    border: none;
    text-decoration: none;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    margin-bottom: 20px;
  }

  .btn-primary {
    background: linear-gradient(135deg, #a855f7, #7c3aed);
    color: #fff;
  }

  .btn-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    margin-left: 10px;
  }

  .btn-primary:hover,
  .btn-success:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.18);
    color: #fff;
  }

  /* ---------- Table card (glassmorphism) ---------- */
  .table-card-wrapper {
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 20px;
    box-shadow:
      0 8px 24px rgba(31, 45, 90, 0.1),
      inset 0 1px 0 rgba(255, 255, 255, 0.7);
    padding: 22px;
  }

  #annivConTable {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
  }

  #annivConTable thead.table-dark th {
    background: linear-gradient(135deg, #2b3550, #1f2937);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 14px 12px;
    border: none;
  }

  #annivConTable thead.table-dark th:first-child {
    border-top-left-radius: 12px;
  }

  #annivConTable thead.table-dark th:last-child {
    border-top-right-radius: 12px;
  }

  #annivConTable tbody td {
    padding: 13px 12px;
    font-size: 14px;
    color: #334155;
    background: rgba(255, 255, 255, 0.7);
    border-bottom: 1px solid rgba(148, 163, 184, 0.2);
    vertical-align: middle;
  }

  #annivConTable tbody tr {
    transition: background 0.2s ease;
  }

  #annivConTable tbody tr:hover td {
    background: rgba(168, 85, 247, 0.06);
  }

  #annivConTable tbody td.text-center {
    text-align: center;
    color: #64748b;
    padding: 30px 0;
  }

  /* Receipt view/download links */
  #annivConTable td a {
    color: #7c3aed;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  #annivConTable td a:hover {
    text-decoration: underline;
  }

  .btn-warning,
  .btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 9px;
    font-weight: 600;
    font-size: 12.5px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    transition: transform 0.15s ease, filter 0.2s ease;
  }

  .btn-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #3b2900;
  }

  .btn-danger {
    background: linear-gradient(135deg, #f87171, #ef4444);
    color: #fff;
  }

  .btn-warning:hover,
  .btn-danger:hover {
    transform: translateY(-1px);
    filter: brightness(1.05);
  }

  .btn-sm {
    margin-right: 4px;
  }

  /* ---------- DataTables chrome ---------- */
  .dataTables_wrapper .dataTables_filter input,
  .dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
    border: 1px solid rgba(148, 163, 184, 0.4);
    padding: 5px 10px;
    background: rgba(255, 255, 255, 0.8);
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #a855f7, #7c3aed) !important;
    border: none !important;
    color: #fff !important;
    border-radius: 8px;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
  }

  @media (max-width: 900px) {
    .content-area {
      margin-left: 0;
      margin-top: 0;
      padding: 20px 16px 28px;
    }
  }
</style>

<div class="content-area">
  <h4><small>CHURCH ANNIVERSARY CONTRIBUTIONS</small></h4>
  <hr>

  <!-- Add Contribution Button with Icon -->
  <a class="btn btn-primary" href="<?= base_url("AnnivCon/AddContrib"); ?>" role="button">
    <span class="glyphicon glyphicon-plus"></span>  Add Contribution
  </a>

  <!-- Generate Report Button with Icon -->
  <button type="button" class="btn btn-success report-modal-btn" data-report-url="<?= base_url('AnnivCon/Reports/AnnivConReport') ?>">
    <span class="glyphicon glyphicon-print"></span> Generate Report
  </button>

  <div class="table-card-wrapper">
    <table id="annivConTable" class="display" style="width:100%">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Family Name</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Description</th>
          <th>Receipt</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!empty($AnnivContributions)): ?>
          <?php foreach ($AnnivContributions as $contribution): ?>
            <tr>
              <td><?= esc($contribution['annivcon_id']) ?></td>
              <td><?= esc($contribution['family_name']) ?></td>
              <td>₱<?= number_format($contribution['amount'], 2) ?></td>
              <td><?= esc($contribution['date']) ?></td>
              <td><?= esc($contribution['description']) ?></td>
              <td>
                <?php if ($contribution['receipt']): ?>
                  <!-- View and Download Icons -->
                  <a href="<?= base_url('uploads/anniv_receipts/' . $contribution['receipt']) ?>" target="_blank">
                    <span class="glyphicon glyphicon-eye-open"></span>  View
                  </a>
                  | 
                  <a href="<?= base_url('uploads/anniv_receipts/' . $contribution['receipt']) ?>" download>
                    <span class="glyphicon glyphicon-download"></span> Download
                  </a>
                <?php else: ?>
                  No receipt
                <?php endif; ?>
              </td>
              <td>
                <a href="<?= base_url('AnnivCon/EditAnnivCon/' . $contribution['annivcon_id']) ?>" class="btn btn-warning btn-sm">
                  <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
                <a href="<?= base_url('AnnivCon/DeleteAnnivCon/' . $contribution['annivcon_id']) ?>" class="btn btn-danger btn-sm">
                  <span class="glyphicon glyphicon-trash"></span> Delete
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-center">No records found.</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="reportModalLabel">Anniversary Contribution Report</h4>
      </div>
      <div class="modal-body" style="padding: 0; background: #f2f2f2;">
        <iframe id="reportFrame" src="" style="width: 100%; height: 75vh; border: none;"></iframe>
      </div>
      <div class="modal-footer">
        <a id="downloadReportBtn" class="btn btn-primary" href="#" download>Download PDF</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#annivConTable').DataTable({
      scrollCollapse: true,
      scrollX: true,
      scrollY: 300
    });

    $('.report-modal-btn').on('click', function () {
      const reportUrl = $(this).data('report-url');
      $('#reportFrame').attr('src', reportUrl);
      $('#downloadReportBtn').attr('href', reportUrl + '?download=1');
      $('#reportModal').modal('show');
    });
  });
</script>