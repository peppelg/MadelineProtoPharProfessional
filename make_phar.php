<?php 
#Bienvenudos a la cripta!
chdir(__DIR__);
define('SRC_DIR', __DIR__.'/vendor');
define('PHAR_NAME', 'madeline.phar');
if (strtolower(readline('Desidera composer updates? ? ? [Y/n]: ')) == 'y') passthru('composer update');
if (file_exists(SRC_DIR.'/autoload.php') and strtolower(readline('Penzo che si e composer update. Desidera procedere al phar generamendo? [Y/n]: ')) === 'y') { #esiste u file? continuar?
  unlink(PHAR_NAME); #pulizia
  //passthru("find vendor/danog/madelineproto/ -name '*.php' -exec sed -i -e 's/continue;/continue 1;/g' {} \;"); #fix x php 7.3 EDIT: adesso nun c'è bisogno uso nuova versione va
  echo 'Working in progression 🔨';
  $phar = new Phar(__DIR__.'/'.PHAR_NAME, 0, PHAR_NAME);
  echo ' 🔨';
  $phar->startBuffering();
  echo ' 🔨';
  $phar->buildFromDirectory(realpath(SRC_DIR), '/^((?!tests).)*(\.php|\.py|\.tl|\.json)$/i');
  echo ' 🔨';
  echo ' 🔨';
  $phar->setStub('<?php Phar::mapPhar(); require("phar://".__FILE__."/autoload.php"); __HALT_COMPILER(); ?>');
  echo ' 🔨';
  $phar->stopBuffering();
  file_put_contents('version', json_encode(['md5' => md5_file(PHAR_NAME)]));
  echo PHP_EOL.'AI: Il madeline.phar è stato sfornato... Avvio dei testings . . . '.PHP_EOL;
  require_once PHAR_NAME;
  $MadelineProto = new \danog\MadelineProto\API('boll_labs.madeline', ['app_info' => ['api_id' => 6, 'api_hash' => 'eb06d4abfb49dc3eeb1aeb98ae0f581e', 'lang_code' => 'it', 'app_version' => '4.9.0', 'device_model' => 'Asus ASUS_Z00ED', 'system_version' => 'Android Nougat MR1 (25)']]);
  $MadelineProto->session = NULL;
  unset($MadelineProto);
  if (file_exists('boll_labs.madeline'))  unlink('boll_labs.madeline');
  echo 'AI: Se ha funzionato fino a qui,,significa che boll test è passato.'.PHP_EOL;
  if (strtolower(readline('Desidera pushings? [Y/n]: ')) == 'y') {
    $commit = readline('Inserisca commit messaggio: ');
    passthru('git add madeline.phar version make_phar.php composer.json composer_old.json README.md');
    passthru('git commit -m '.escapeshellarg($commit));
    passthru('git push');
  }
}
