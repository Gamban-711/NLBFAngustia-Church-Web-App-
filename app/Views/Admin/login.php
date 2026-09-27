<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('<?= base_url('assets/church.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Balanced multi-stop gradient overlay, softer and more even than a single top fade */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                rgba(10, 20, 40, 0.55) 0%,
                rgba(15, 35, 70, 0.35) 45%,
                rgba(33, 150, 237, 0.55) 100%);
            pointer-events: none;
            z-index: 0;
        }

        /* Soft radial glow behind the card for depth */
        body::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 700px;
            height: 700px;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(33, 196, 237, 0.35) 0%, rgba(33, 196, 237, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .login-wrapper {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.08));
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 48px 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            min-height: 420px;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
            position: relative;
            z-index: 1;
            transition: box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .login-form h2 {
            text-align: center;
            margin: 0 0 28px 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            max-width: 155px;
            height: auto;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.35));
        }

        .form-group {
            margin-bottom: 18px;
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
            color: rgba(255, 255, 255, 0.9);
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 10px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(33, 196, 237, 0.9);
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 0 0 3px rgba(33, 196, 237, 0.25);
        }

        .btn-primary {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #2196f3, #6a11cb);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.3px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 4px 14px rgba(33, 150, 243, 0.4);
            transition: transform 0.15s ease, box-shadow 0.2s ease, background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1976d2, #4a0e9e);
            box-shadow: 0 6px 18px rgba(33, 150, 243, 0.5);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(33, 150, 243, 0.4);
        }

        .login-error {
            background: linear-gradient(135deg, rgba(255, 60, 60, 0.7), rgba(200, 0, 0, 0.6));
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 0 0 20px 0;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(200, 0, 0, 0.35);
        }

        @media (max-width: 768px) {
            body {
                justify-content: center;
            }

            .login-wrapper {
                margin: 20px;
                min-height: auto;
                padding: 36px 28px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-form">
        <img src="<?= base_url('assets/nlbflogo.png') ?>" alt="NLBF Logo" class="logo">
        <h2>Admin Login</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="login-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('admin/auth') ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Admin Username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>
</div>

</body>
</html>