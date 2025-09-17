<?php
// simulator.php
// SAFE simulator: TIDAK menjalankan perintah shell.
// Hanya menampilkan perintah (sanitasi) dan memberikan simulated output.

function simulate_command($cmd) {
    $c = trim($cmd);
    if ($c === '') {
        return "";
    }

    $lc = strtolower($c);

    // beberapa simulasi sederhana
    if ($lc === 'date' || strpos($lc, 'date ') === 0) {
        return date('Y-m-d H:i:s');
    }

    if ($lc === 'uptime' || strpos($lc, 'uptime ') === 0) {
        // contoh keluaran uptime (simulasi)
        return " 10:23:45 up 3 days,  2:12,  1 user,  load average: 0.00, 0.01, 0.05";
    }

    if (preg_match('/^echo\s+(.+)/i', $c, $m)) {
        // echo -> tampilkan argumen setelah echo
        return $m[1];
    }

    if ($lc === 'whoami') {
        return "www-data (simulated)";
    }

    if ($lc === 'ls' || preg_match('/^ls\s+(.+)/i', $c)) {
        // simulasi daftar file sederhana
        return "index.php\nconfig.php\nuploads/\nREADME.md";
    }

    // default: beri tanda bahwa ini hanya simulasi
    return "[SIMULATED] Command received but NOT executed: " . $cmd;
}

// tangani form
$cmd_input = '';
$sim_output = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil input dan bersihkan untuk ditampilkan (prevent XSS)
    $cmd_input = isset($_POST['cmd']) ? (string) $_POST['cmd'] : '';
    $sim_output = simulate_command($cmd_input);
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Command Simulator (SAFE)</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; padding: 20px; background:#f6f8fa; }
    .box { background:white; padding:16px; border-radius:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); max-width:900px; margin:auto;}
    input[type=text] { width:80%; padding:8px; font-family:monospace }
    button { padding:8px 12px; }
    pre { background:#111; color:#cfcfcf; padding:12px; border-radius:6px; overflow:auto; }
    .note { font-size:0.9em; color:#555; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Command Simulator — <small>SAFE (no shell execution)</small></h2>
    <p class="note">
      Aplikasi ini <strong>tidak</strong> menjalankan perintah shell apa pun. 
      Ini hanya <em>mensimulasikan</em> keluaran untuk beberapa perintah umum untuk tujuan pembelajaran.
      Jalankan hanya di lingkungan lokal / VM untuk latihan.
    </p>

    <form method="post" action="">
      <label for="cmd">Masukkan perintah (simulasi):</label><br>
      <input id="cmd" name="cmd" type="text" value="<?php echo h($cmd_input); ?>" placeholder="contoh: date, uptime, echo hello" autocomplete="off" />
      <button type="submit">Kirim</button>
    </form>

    <?php if ($cmd_input !== ''): ?>
      <h3>Perintah (sanitized):</h3>
      <pre><?php echo h($cmd_input); ?></pre>

      <h3>Simulasi Output:</h3>
      <pre><?php echo h($sim_output); ?></pre>

      <h4>Catatan Keamanan</h4>
      <ul>
        <li>Aplikasi ini <strong>tidak</strong> mengeksekusi perintah apapun pada server.</li>
        <li>Contoh kerentanan nyata: jika aplikasi mengeksekusi input user (mis. <code>system($_GET['cmd'])</code>), maka bisa menjadi webshell.</li>
        <li>Praktik aman: validasi/whitelist input, simpan upload di luar webroot, nonaktifkan fungsi eksekusi berbahaya di PHP.</li>
      </ul>
    <?php endif; ?>

    <hr/>
    <h4>Daftar perintah yang disimulasikan</h4>
    <pre>
date
uptime
echo anything
whoami
ls
    </pre>
  </div>
</body>
</html>
