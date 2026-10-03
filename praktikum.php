<?php

// A fixed local profile; never reads database credentials from the main .env.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$action = $argv[1] ?? 'help';
$commands = [
    'prepare' => ['migrate', '--force'],
    'serve' => ['serve', '--host=127.0.0.1', '--port=8010', '--no-reload'],
    'reset' => ['praktikum:reset-registration'],
];
if (! isset($commands[$action]) || count($argv) !== 2) {
    echo "Pemakaian: php praktikum.php prepare|serve|reset\n";
    exit($action === 'help' ? 0 : 1);
}
$directory = __DIR__.'/storage/praktikum';
if (is_link($directory)) {
    fwrite(STDERR, "Folder praktikum tidak boleh berupa symlink.\n");
    exit(1);
}
if (! is_dir($directory)) {
    mkdir($directory, 0700, true);
}
foreach (['database.sqlite', 'app.key'] as $file) {
    $path = $directory.'/'.$file;
    if (is_link($path) || (file_exists($path) && stat($path)['nlink'] !== 1)) {
        fwrite(STDERR, "File praktikum tidak boleh berupa link.\n");
        exit(1);
    }
    if (! file_exists($path)) {
        $handle = fopen($path, 'x');
        if ($handle === false) {
            exit(1);
        }
        if ($file === 'app.key') {
            fwrite($handle, 'base64:'.base64_encode(random_bytes(32)));
        }
        fclose($handle);
        chmod($path, 0600);
    }
}
$profile = [
    'APP_ENV' => 'praktikum', 'APP_NAME' => 'RaabShoes Praktikum',
    'APP_KEY' => trim(file_get_contents($directory.'/app.key')),
    'APP_DEBUG' => 'true', 'APP_URL' => 'http://127.0.0.1:8010',
    'APP_CONFIG_CACHE' => $directory.'/unused-config.php',
    'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $directory.'/database.sqlite', 'DB_URL' => '',
    'SESSION_DRIVER' => 'database', 'SESSION_CONNECTION' => 'sqlite', 'SESSION_TABLE' => 'sessions',
    'SESSION_COOKIE' => 'raabshoes_praktikum_session', 'SESSION_DOMAIN' => 'null',
    'SESSION_SECURE_COOKIE' => 'false', 'SESSION_PATH' => '/',
    'CACHE_STORE' => 'array', 'QUEUE_CONNECTION' => 'sync', 'MAIL_MAILER' => 'log',
    'GOOGLE_CLIENT_ID' => '', 'GOOGLE_CLIENT_SECRET' => '', 'GOOGLE_REDIRECT_URI' => '',
];
if (file_exists($profile['APP_CONFIG_CACHE'])) {
    fwrite(STDERR, "Profil praktikum tidak menerima config cache.\n");
    exit(1);
}
foreach ($profile as $key => $value) {
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
$_SERVER['argv'] = $argv = array_merge([__DIR__.'/artisan'], $commands[$action]);
$_SERVER['argc'] = $argc = count($argv);
require __DIR__.'/artisan';
