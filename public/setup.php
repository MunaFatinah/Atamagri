<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atamagri — Setup Wizard</title>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--green-dark:#1a3a1a;--green-mid:#2d6a2d;--green-light:#5cb85c;--green-pale:#e8f5e8;--green-mist:#f0f7f0;--white:#fff;--gray-200:#e8e8e4;--gray-500:#888884;--gray-700:#444440;--radius:12px;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;background:var(--green-mist);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem;}
.card{background:var(--white);border-radius:24px;padding:2.5rem;width:100%;max-width:560px;box-shadow:0 12px 48px rgba(26,58,26,.16);}
.logo{display:flex;align-items:center;gap:.6rem;margin-bottom:2rem;}
.logo-mark{width:40px;height:40px;background:var(--green-dark);border-radius:10px;display:flex;align-items:center;justify-content:center;}
.logo-mark svg{width:22px;height:22px;fill:#fff;}
.logo-text{font-family:'Fraunces',serif;font-size:1.4rem;font-weight:700;color:var(--green-dark);}
h2{font-family:'Fraunces',serif;font-size:1.6rem;color:var(--green-dark);margin-bottom:.4rem;}
.sub{color:var(--gray-500);font-size:.9rem;margin-bottom:2rem;line-height:1.6;}
.step{display:flex;align-items:center;gap:.75rem;background:var(--green-mist);border-radius:var(--radius);padding:1rem 1.25rem;margin-bottom:1rem;}
.step-num{width:28px;height:28px;background:var(--green-dark);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;flex-shrink:0;}
.step p{font-size:.85rem;color:var(--gray-700);line-height:1.5;}
.step a{color:var(--green-mid);font-weight:600;}
.divider{border:none;border-top:1px solid var(--gray-200);margin:1.5rem 0;}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:600;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input,.form-group select{width:100%;padding:.75rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;transition:border-color .2s;}
.form-group input:focus,.form-group select:focus{border-color:var(--green-light);}
.form-group .hint{font-size:.78rem;color:var(--gray-500);margin-top:.35rem;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:.4rem;width:100%;padding:.85rem;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:600;cursor:pointer;border:none;background:var(--green-dark);color:#fff;transition:background .2s;}
.btn:hover{background:var(--green-mid);}
.alert{border-radius:var(--radius);padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.88rem;}
.alert.success{background:#e8f5e8;color:#1a5c1a;border:1px solid var(--green-light);}
.alert.error{background:#ffebee;color:#c62828;border:1px solid #ef9a9a;}
.badge{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .6rem;border-radius:100px;font-size:.75rem;font-weight:600;}
.badge.ok{background:var(--green-pale);color:var(--green-mid);}
.badge.warn{background:#fff3cd;color:#856404;}
.status-row{display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--gray-200);font-size:.85rem;}
.status-row:last-child{border-bottom:none;}
</style>
</head>
<body>
<?php
$envPath = __DIR__ . '/../.env';
$envExample = __DIR__ . '/../.env.example';
$message = '';
$messageType = '';
$setupDone = false;

// Check if already configured
function getEnvValue($key, $envPath) {
    if (!file_exists($envPath)) return '';
    $content = file_get_contents($envPath);
    if (preg_match('/^' . $key . '=(.*)$/m', $content, $m)) {
        return trim($m[1]);
    }
    return '';
}

function isConfigured($envPath) {
    if (!file_exists($envPath)) return false;
    $appKey = getEnvValue('APP_KEY', $envPath);
    return !empty($appKey) && $appKey !== '';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'setup') {
        $owmKey     = trim($_POST['owm_key'] ?? '');
        $geminiKey  = trim($_POST['gemini_key'] ?? '');
        $dbHost     = trim($_POST['db_host'] ?? '127.0.0.1');
        $dbPort     = trim($_POST['db_port'] ?? '3306');
        $dbName     = trim($_POST['db_name'] ?? 'atamagri');
        $dbUser     = trim($_POST['db_user'] ?? 'root');
        $dbPass     = trim($_POST['db_pass'] ?? '');
        $appUrl     = trim($_POST['app_url'] ?? 'http://localhost:8000');

        // Read example or existing env
        $template = file_exists($envExample) ? file_get_contents($envExample) : '';
        if (empty($template)) {
            $template = "APP_NAME=Atamagri\nAPP_ENV=local\nAPP_KEY=\nAPP_DEBUG=true\nAPP_URL=http://localhost:8000\n\nDB_CONNECTION=mysql\nDB_HOST=127.0.0.1\nDB_PORT=3306\nDB_DATABASE=atamagri\nDB_USERNAME=root\nDB_PASSWORD=\n\nSESSION_DRIVER=file\nSESSION_LIFETIME=120\nCACHE_DRIVER=file\nQUEUE_CONNECTION=sync\n\nOWM_API_KEY=YOUR_OWM_API_KEY_HERE\nGEMINI_API_KEY=YOUR_GEMINI_API_KEY_HERE\n";
        }

        // Replace values
        $replacements = [
            'APP_URL'       => $appUrl,
            'DB_HOST'       => $dbHost,
            'DB_PORT'       => $dbPort,
            'DB_DATABASE'   => $dbName,
            'DB_USERNAME'   => $dbUser,
            'DB_PASSWORD'   => $dbPass,
            'OWM_API_KEY'   => $owmKey ?: 'YOUR_OWM_API_KEY_HERE',
            'GEMINI_API_KEY'=> $geminiKey ?: 'YOUR_GEMINI_API_KEY_HERE',
        ];

        $envContent = $template;
        foreach ($replacements as $key => $val) {
            if (preg_match('/^' . $key . '=/m', $envContent)) {
                $envContent = preg_replace('/^' . $key . '=.*/m', $key . '=' . $val, $envContent);
            } else {
                $envContent .= "\n" . $key . '=' . $val;
            }
        }

        // Write .env
        if (file_put_contents($envPath, $envContent) !== false) {
            // Generate app key via artisan if possible
            $artisan = __DIR__ . '/../artisan';
            if (file_exists($artisan)) {
                exec('php ' . escapeshellarg($artisan) . ' key:generate --force 2>&1', $out);
            }

            $message = '✅ File .env berhasil dibuat! Sekarang jalankan: <code>composer install</code> → <code>php artisan migrate --seed</code> → <code>php artisan serve</code>';
            $messageType = 'success';
            $setupDone = true;
        } else {
            $message = '❌ Gagal menulis file .env. Pastikan folder memiliki permission write.';
            $messageType = 'error';
        }
    }
}

// Read current values if .env exists
$currentOwm    = getEnvValue('OWM_API_KEY', $envPath);
$currentGemini = getEnvValue('GEMINI_API_KEY', $envPath);
$currentDb     = getEnvValue('DB_DATABASE', $envPath);
$envExists     = file_exists($envPath);
$appKeySet     = !empty(getEnvValue('APP_KEY', $envPath));
?>

<div class="card">
  <div class="logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
    </div>
    <span class="logo-text">Atamagri</span>
  </div>

  <h2>Setup Wizard 🛠️</h2>
  <p class="sub">Konfigurasi aplikasi Atamagri sekali klik. Isi form di bawah lalu klik <strong>Simpan & Generate .env</strong>.</p>

  <?php if ($message): ?>
  <div class="alert <?= $messageType ?>"><?= $message ?></div>
  <?php endif; ?>

  <?php if ($envExists): ?>
  <div style="margin-bottom:1.5rem;">
    <div style="font-size:.82rem;font-weight:600;color:var(--gray-700);margin-bottom:.75rem;">Status Konfigurasi Saat Ini:</div>
    <div style="background:var(--green-mist);border-radius:var(--radius);padding:.75rem 1rem;">
      <div class="status-row"><span>File .env</span><span class="badge ok">✅ Ada</span></div>
      <div class="status-row"><span>APP_KEY</span><span class="badge <?= $appKeySet ? 'ok' : 'warn' ?>"><?= $appKeySet ? '✅ Set' : '⚠️ Belum' ?></span></div>
      <div class="status-row"><span>OWM API Key</span><span class="badge <?= ($currentOwm && $currentOwm !== 'YOUR_OWM_API_KEY_HERE') ? 'ok' : 'warn' ?>"><?= ($currentOwm && $currentOwm !== 'YOUR_OWM_API_KEY_HERE') ? '✅ Terset' : '⚠️ Demo mode' ?></span></div>
      <div class="status-row"><span>Gemini API Key</span><span class="badge <?= ($currentGemini && $currentGemini !== 'YOUR_GEMINI_API_KEY_HERE') ? 'ok' : 'warn' ?>"><?= ($currentGemini && $currentGemini !== 'YOUR_GEMINI_API_KEY_HERE') ? '✅ Terset' : '⚠️ Fallback mode' ?></span></div>
      <div class="status-row"><span>Database</span><span class="badge ok"><?= htmlspecialchars($currentDb ?: 'atamagri') ?></span></div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Cara dapat API key -->
  <div style="margin-bottom:1.5rem;">
    <div style="font-size:.82rem;font-weight:600;color:var(--gray-700);margin-bottom:.75rem;">Cara Dapat API Key (Gratis):</div>
    <div class="step">
      <div class="step-num">1</div>
      <p><strong>OpenWeatherMap:</strong> Daftar di <a href="https://openweathermap.org/api" target="_blank">openweathermap.org/api</a> → My API Keys → copy key. Free 1000 call/hari.</p>
    </div>
    <div class="step">
      <div class="step-num">2</div>
      <p><strong>Google Gemini:</strong> Buka <a href="https://aistudio.google.com/" target="_blank">aistudio.google.com</a> → Get API Key → Create API Key. Gratis.</p>
    </div>
  </div>

  <hr class="divider">

  <form method="POST">
    <input type="hidden" name="action" value="setup">

    <div style="font-size:.88rem;font-weight:700;color:var(--green-dark);margin-bottom:1rem;">🔑 API Keys</div>

    <div class="form-group">
      <label>OpenWeatherMap API Key</label>
      <input type="text" name="owm_key" placeholder="Contoh: a1b2c3d4e5f6..." value="<?= htmlspecialchars(($currentOwm !== 'YOUR_OWM_API_KEY_HERE') ? $currentOwm : '') ?>"/>
      <div class="hint">Kosongkan = pakai data cuaca demo (tetap berjalan)</div>
    </div>

    <div class="form-group">
      <label>Google Gemini API Key</label>
      <input type="text" name="gemini_key" placeholder="Contoh: AIzaSy..." value="<?= htmlspecialchars(($currentGemini !== 'YOUR_GEMINI_API_KEY_HERE') ? $currentGemini : '') ?>"/>
      <div class="hint">Kosongkan = pakai rekomendasi rule-based (tetap berjalan)</div>
    </div>

    <hr class="divider">
    <div style="font-size:.88rem;font-weight:700;color:var(--green-dark);margin-bottom:1rem;">🗄️ Database MySQL</div>

    <div class="form-row">
      <div class="form-group">
        <label>Host</label>
        <input type="text" name="db_host" value="<?= htmlspecialchars(getEnvValue('DB_HOST', $envPath) ?: '127.0.0.1') ?>"/>
      </div>
      <div class="form-group">
        <label>Port</label>
        <input type="text" name="db_port" value="<?= htmlspecialchars(getEnvValue('DB_PORT', $envPath) ?: '3306') ?>"/>
      </div>
    </div>
    <div class="form-group">
      <label>Nama Database</label>
      <input type="text" name="db_name" value="<?= htmlspecialchars(getEnvValue('DB_DATABASE', $envPath) ?: 'atamagri') ?>"/>
      <div class="hint">Buat database ini dulu di MySQL: <code>CREATE DATABASE atamagri;</code></div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="db_user" value="<?= htmlspecialchars(getEnvValue('DB_USERNAME', $envPath) ?: 'root') ?>"/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="db_pass" placeholder="(kosong jika tanpa password)"/>
      </div>
    </div>

    <div class="form-group">
      <label>App URL</label>
      <input type="text" name="app_url" value="<?= htmlspecialchars(getEnvValue('APP_URL', $envPath) ?: 'http://localhost:8000') ?>"/>
    </div>

    <button type="submit" class="btn">⚡ Simpan & Generate .env</button>
  </form>

  <?php if ($setupDone): ?>
  <div style="margin-top:1.5rem;background:var(--green-mist);border-radius:var(--radius);padding:1.25rem;font-size:.85rem;">
    <div style="font-weight:700;color:var(--green-dark);margin-bottom:.75rem;">Langkah Selanjutnya:</div>
    <div style="display:grid;gap:.5rem;color:var(--gray-700);">
      <div>1. Buka terminal di folder <code>atamagri/</code></div>
      <div>2. <code>composer install</code></div>
      <div>3. <code>php artisan migrate --seed</code></div>
      <div>4. <code>php artisan serve</code></div>
      <div>5. Buka <strong>http://localhost:8000</strong></div>
      <div style="margin-top:.5rem;color:var(--gray-500);">Hapus file <code>public/setup.php</code> setelah selesai.</div>
    </div>
  </div>
  <?php endif; ?>

  <div style="margin-top:1.5rem;text-align:center;font-size:.78rem;color:var(--gray-500);">
    ⚠️ Hapus file <code>public/setup.php</code> setelah konfigurasi selesai.
  </div>
</div>
</body>
</html>
