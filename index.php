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

function        get_cache($user, $size) {
  $timeout = 24 * 60 * 60;
  $filename = 'cache/'.$user.'_'.$size;
  if (file_exists($filename)
      && (time() - filemtime($filename)) < $timeout) {
    $cache = @file_get_contents($filename);
    return $cache;
  }
  return false;
}

function        get_from_api($user, $size) {
  $content = @file_get_contents('http://mal-api.com/animelist/'.$user);
  if ($content === false) {
    echo '// Error with the API. Maybe the user does not exist.';
    exit;
  }
  $list = json_decode($content);
  foreach ($list->anime as $anime) {
    $result .= 'a[href^="http://myanimelist.net/anime/'.$anime->id.'/"]:before {
  content: url('.($size == 'small' ? str_replace('.jpg', 't.jpg', $anime->image_url) : $anime->image_url).') " ";
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
