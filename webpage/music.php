<?php
  $playlist = $_REQUEST["playlist"];
  $play_list = array();
  if(isset($playlist)){
    $music_list = file("songs/$playlist");
  }
  else{
    $music_list = glob('songs/*.mp3');
    $play_list = glob('songs/*.txt');
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="viewer.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="header">
			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
		</div>
		<div id="listarea">
			<ul id="musiclist">
        <?php
        for($i=0; $i<count($music_list); $i++){?>
          <li class="mp3item">
  					<a href="songs/<?=$music_list[$i]?>"><?= basename($music_list[$i])?></a>
  				</li>
        <?php } ?>
        <?php
        for($i=0; $i<count($play_list); $i++){?>
          <li class="playlistitem">
  					<a href="songs/<?=$play_list[$i]?>"><?= basename($play_list[$i])?></a>
  				</li>
        <?php } ?>
			</ul>
		</div>
	</body>
</html>
