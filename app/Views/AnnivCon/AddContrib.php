<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= esc($page_title ?? 'Add Anniversary Contribution') ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
      background: linear-gradient(135deg, #8b5cf6, #6d5efc);
      color: #fff;
      font-size: 15px;
      box-shadow: 0 6px 16px rgba(109, 94, 252, 0.35);
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

    .alert-danger {
      background: linear-gradient(135deg, rgba(255, 60, 60, 0.15), rgba(200, 0, 0, 0.1));
      border: 1px solid rgba(220, 38, 38, 0.35);
      color: #991b1b;
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 500;
    }

    form {
      max-width: 560px;
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(255, 255, 255, 0.6);
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(31, 45, 90, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.7);
      padding: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group:last-of-type {
      margin-bottom: 0;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      font-size: 13px;
      letter-spacing: 0.3px;
      text-transform: uppercase;
      color: #475569;
    }

    .form-control {
      width: 100%;
      padding: 12px 14px;
      border: 1px solid rgba(148, 163, 184, 0.45);
      border-radius: 10px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.8);
      color: #1e293b;
      transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .form-control::placeholder {
      color: #94a3b8;
    }

    .form-control:focus {
      outline: none;
      border-color: #8b5cf6;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }

    textarea.form-control {
      min-height: 96px;
      resize: vertical;
    }

    input[type="file"].form-control {
      padding: 9px 12px;
      cursor: pointer;
    }

    .current-file {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin: 10px 0 0;
      padding: 6px 12px;
      background: rgba(139, 92, 246, 0.1);
      border: 1px solid rgba(139, 92, 246, 0.25);
      border-radius: 20px;
      font-size: 12.5px;
      color: #6d28d9;
      font-weight: 500;
    }

    .submit-row {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      gap: 12px;
      margin-top: 16px;
    }

    button[type="submit"],
    .btn-secondary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 11px 22px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 14px;
      letter-spacing: 0.2px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    }

    button[type="submit"].btn-primary {
      background: linear-gradient(135deg, #8b5cf6, #6d5efc);
      color: #fff;
      box-shadow: 0 6px 16px rgba(107, 92, 255, 0.35);
    }

    button[type="submit"].btn-warning {
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      color: #3b2900;
      box-shadow: 0 6px 16px rgba(245, 158, 11, 0.35);
    }

    button[type="submit"]:hover {
      transform: translateY(-2px);
      filter: brightness(1.05);
    }

    .btn-secondary {
      background: #fff;
      color: #475569;
      border: 1px solid rgba(148, 163, 184, 0.5);
    }

    .btn-secondary:hover {
      background: #f8fafc;
      color: #1f2937;
      text-decoration: none;
    }

    @media (max-width: 900px) {
      .content-area {
        margin-left: 0;
        margin-top: 0;
        padding: 20px 16px 28px;
      }

      form {
        max-width: 100%;
        padding: 20px 16px;
      }

      .submit-row {
        flex-direction: column;
        align-items: stretch;
      }

      button[type="submit"],
      .btn-secondary {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="content-area">
    <h4><small><?= isset($AnnivInfo) ? 'EDIT CONTRIBUTION' : 'ADD CONTRIBUTION' ?></small></h4>
    <hr>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif ?>

    <?= \Config\Services::validation()->listErrors() ?>

    <form
      action="<?= isset($AnnivInfo)
          ? base_url("AnnivCon/updateAnnivCon/{$AnnivInfo['annivcon_id']}")
          : base_url('AnnivCon/insertAnnivCon') ?>"
      method="post"
      enctype="multipart/form-data"
    >
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="family_name">Family Name</label>
        <input
          type="text"
          class="form-control"
          name="family_name"
          id="family_name"
          placeholder="Enter Family Name"
          value="<?= isset($AnnivInfo) ? esc($AnnivInfo['family_name']) : set_value('family_name') ?>"
        >
      </div>

      <div class="form-group">
        <label for="amount">Amount</label>
        <input
          type="number"
          step="0.01"
          class="form-control"
          name="amount"
          id="amount"
          placeholder="Enter Amount"
          value="<?= isset($AnnivInfo) ? esc($AnnivInfo['amount']) : set_value('amount') ?>"
        >
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <input
          type="date"
          class="form-control"
          name="date"
          id="date"
          value="<?= isset($AnnivInfo) ? esc($AnnivInfo['date']) : set_value('date') ?>"
        >
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          class="form-control"
          name="description"
          id="description"
          placeholder="Enter Description"
        ><?= isset($AnnivInfo) ? esc($AnnivInfo['description']) : set_value('description') ?></textarea>
      </div>

      <div class="form-group">
        <label for="receipt">Receipt (Image/File)</label>
        <input
          type="file"
          class="form-control"
          name="receipt"
          id="receipt"
        >
        <?php if (isset($AnnivInfo['receipt']) && $AnnivInfo['receipt']): ?>
          <p class="current-file"><i class="fas fa-paperclip"></i> Current File: <?= esc($AnnivInfo['receipt']) ?></p>
        <?php endif; ?>
      </div>

      <div class="submit-row">
        <button type="submit" class="btn <?= isset($AnnivInfo) ? 'btn-warning' : 'btn-primary' ?>">
          <?= isset($AnnivInfo) ? 'Update Contribution' : 'Add Contribution' ?>
        </button>
        <a href="<?= base_url('AnnivCon') ?>" class="btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>