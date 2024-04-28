<?php
// $filelink="https://www.doodstream.com/d/8ad16ibzdrnm";
// $filelink="https://www.doodstream.com/e/8ad16ibzdrnm";

$filelink = isset($_GET['filelink']) ? $_GET['filelink'] : '';
$download_link = '';

if (!empty($filelink)) {
if (preg_match("/dood(stream)?\./",$filelink)) {
  function makePlay() {
   $a="";
   $t = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
   $n = strlen($t) - 1;
   for ($o = 0; 10>$o; $o++) {
    $a .= $t[rand(0,$n)];
   }
   return $a;
  }
  $filelink=str_replace("/f/","/e",$filelink);
  $filelink=str_replace("/d/","/e/",$filelink);
  $host=parse_url($filelink)['host'];
  /* prevent cloudflare captcha (PHP 7.x > */
 $DEFAULT_CIPHERS =array(
            "ECDHE+AESGCM",
            "ECDHE+CHACHA20",
            "DHE+AESGCM",
            "DHE+CHACHA20",
            "ECDH+AESGCM",
            "DH+AESGCM",
            "ECDH+AES",
            "DH+AES",
            "RSA+AESGCM",
            "RSA+AES",
            "!aNULL",
            "!eNULL",
            "!MD5",
            "!DSS",
            "!ECDHE+SHA",
            "!AES128-SHA",
            "!DHE"
        );
 if (defined('CURL_SSLVERSION_TLSv1_3'))
  $ssl_version=7;
 else
  $ssl_version=0;
  $ua="Mozilla/5.0 (Windows NT 10.0; rv:89.0) Gecko/20100101 Firefox/89.0";
  $ua="Mozilla/5.0";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $filelink);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch, CURLOPT_HEADER,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, implode(":", $DEFAULT_CIPHERS));
  curl_setopt($ch, CURLOPT_SSLVERSION,$ssl_version);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $h = curl_exec($ch);
  curl_close($ch);
  if (preg_match_all("/location\:\s+(http.+)/i",$h,$m)) {
    $filelink=trim($m[1][count($m[1])-1]);
    $host=parse_url(trim($m[1][count($m[1])-1]))['host'];
  }
  if (preg_match('/(\/\/[\.\d\w\-\.\/\\\:\?\&\#\%\_\,]*(\.(srt|vtt)))/', $h, $s))
  $srt="https:".$s[1];
  if (preg_match("/pass_md5/",$h)) {
  $t1=explode('token=',$h);
  $t2=explode('&',$t1[1]);
  $tok=$t2[0];
  $t1=explode("pass_md5/",$h);
  $t2=explode("'",$t1[1]);
  $l="https://".$host."/pass_md5/".$t2[0];
  $head=array('Accept: */*',
  'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
  'Accept-Encoding: deflate',
  'X-Requested-With: XMLHttpRequest',
  'Alt-Used: dood.to:443',
  'Connection: keep-alive',
  'Cookie: referer=',
  'Referer: '.$filelink);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, implode(":", $DEFAULT_CIPHERS));
  curl_setopt($ch, CURLOPT_SSLVERSION,$ssl_version);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  $h1 = curl_exec($ch);
  curl_close($ch);
  if (preg_match("/http/",$h1) && substr($h1, 0, 4)=="http")
   $link=$h1."?token=".$tok."&expiry=".(time()*1000);
  else
   $link="";
  } else {
   $link="";
  }
   if ( $link) $link =$link."|Referer=".urlencode("https://".$host);
}

 if (!empty($link)) {
            $download_link = $link;
        }
}else{
   $response['error'] = 'Parameter filelink tidak diberikan';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dood iklan</title>
    <!-- Include Fluid Player CSS -->
    <link href="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.css" rel="stylesheet">
    <!-- Include Fluid Player JavaScript -->
    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<?php if (!empty($download_link)) : ?>

    <!-- Inisialisasi Fluid Player -->
    <video id="my-video" controls style="width: 100%; height: 100vh;">
        <source src="<?php echo $download_link; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- Script untuk inisialisasi Fluid Player -->
    <script>
        // fluidPlayer('my-video');
    </script>
<?php else : ?>
    <p>File tidak ditemukan atau terjadi kesalahan.</p>
    <?php echo $filelink; ?>
<?php endif; ?>
</body>
</html>