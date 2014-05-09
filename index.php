<?php
// ************************************************************************** //
// Project: MyAnimeList Pictures                                              //
// Description: A solution to display pictures on MyAnimeList                 //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Up-to-date + copyright: https://github.com/db0company/MyAnimeList-pictures //
// ************************************************************************** //

header("Content-Type: text/css");

function        check_username() {
if (!preg_match("/^[A-Za-z0-9_-]+$/", ($user = $_GET['user']))) {
  echo '// Invalid username';
  exit;
 }
 return $user;
}

function        check_size() {
  if (empty($_GET['size'])
      || $_GET['size'] === 'big')
    return 'big';
  if ($_GET['size'] === 'small')
    return 'small';
  echo '// Invalid size';
  exit;
}

function        get_cache($user, $size, $check_time = true) {
  $timeout = 24 * 60 * 60;
  $filename = 'cache/'.$user.'_'.$size;
  if (file_exists($filename)
      && (!$check_time || (time() - filemtime($filename)) < $timeout)) {
    $cache = @file_get_contents($filename);
    return $cache;
  }
  return false;
}

function        get_from_api($user, $size) {
  $url = 'http://myanimelist.net/malappinfo.php?status=all&u='.$user;
  $content = @file_get_contents($url);
  if ($content === false
      || !($list = simplexml_load_string($content))
      || !($list = $list->anime)) {
    if (!($cache = get_cache($user, $size, false))) {
      echo '// Error with the API. Maybe the user does not exist.';
      exit;
    }
    return $cache; // an old version is still better than nothing :)
  }
  foreach ($list as $anime) {
    $result .= 'a[href^="/anime/'.$anime->series_animedb_id.'/"]:before {
  content: url('.($size == 'small' ? str_replace('.jpg', 't.jpg', $anime->series_image) : $anime->series_image).') " ";
}
';
  }
  return $result;
}

function        put_in_cache($user, $size, $content) {
  $filename = 'cache/'.$user.'_'.$size;
  @file_put_contents($filename, $content);
}

$user = check_username();
$size = check_size();
if (!($result = get_cache($user, $size))) {
  $result = get_from_api($user, $size);
  put_in_cache($user, $size, $result);
}
echo $result;
