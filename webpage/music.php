<?php
  $play_list = array();
  $is_playlist = FALSE;
  $music_list = array();
  if(isset($_REQUEST["playlist"])){
    $playlist = $_REQUEST["playlist"];
    $music_tmp_list = file("songs/$playlist");
    foreach ($music_tmp_list as $music){
      if($music[0] != "#"){
        $music_list[] = $music;
      }
    }
    $is_playlist = TRUE;
  }
  else{
    $music_list = glob('songs/*.mp3');
    $play_list = glob('songs/*.txt');
  }
  if(isset($_REQUEST["shuffle"])){
    if($_REQUEST["shuffle"] == "on"){
      shuffle($music_list);
    }
  }
  function merge_sort($my_array){
	if(count($my_array) == 1 ) return $my_array;
	$mid = count($my_array) / 2;
    $left = array_slice($my_array, 0, $mid);
    $right = array_slice($my_array, $mid);
	$left = merge_sort($left);
	$right = merge_sort($right);
	return merge($left, $right);
}
function merge($left, $right){
	$res = array();
	while (count($left) > 0 && count($right) > 0){
		if(filesize($left[0]) > filesize($right[0])){
			$res[] = $right[0];
			$right = array_slice($right , 1);
		}else{
			$res[] = $left[0];
			$left = array_slice($left, 1);
		}
	}
	while (count($left) > 0){
		$res[] = $left[0];
		$left = array_slice($left, 1);
	}
	while (count($right) > 0){
		$res[] = $right[0];
		$right = array_slice($right, 1);
	}
	return $res;
}
  if(isset($_REQUEST["bysize"]) and !$is_playlist){
    if($_REQUEST["bysize"] == "on"){
      $music_list = merge_sort($music_list);
    }
  }
  function fileSizeConverter($bytes){
    $bytes = floatval($bytes);
    $arr_values = array(
      0 => array(
        "UNIT" => "TR",
        "VALUE" => pow(1024, 4)
      ),
      1 => array(
        "UNIT" => "GB",
        "VALUE" => pow(1024, 3)
      ),
      2 => array(
        "UNIT" => "MB",
        "VALUE" => pow(1024, 2)
      ),
      3 => array(
        "UNIT" => "KB",
        "VALUE" => 1024
      ),
      4 => array(
        "UNIT" => "B",
        "VALUE" => 1
      ),
    );
    foreach($arr_values as $arr_value)
    {
      if($bytes > $arr_value["VALUE"]){
        $result = $bytes/$arr_value["VALUE"];
        $result = str_replace(".", ",", strval(round($result, 2)))." ".$arr_value["UNIT"];
        break;
      }
    }
    return $result;
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="viewer.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript">
      function myFunc(){
        var add = window.location.href;
        var list_tmp = add.split("?");
        window.location.href = list_tmp[0];
      }
    </script>
	</head>
	<body>
		<div id="header">
			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
      <button type="button" name="button" onclick="myFunc()">Go to Main!</button>
		</div>
		<div id="listarea">
			<ul id="musiclist">
        <?php
        for($i=0; $i<count($music_list); $i++){?>
          <li class="mp3item">
  					<a href="songs/<?=$music_list[$i]?>"><?= basename($music_list[$i])?></a>
            <?php if (!$is_playlist) echo "(".fileSizeConverter(filesize($music_list[$i])).")" ?>
  				</li>
        <?php } ?>
        <?php
        for($i=0; $i<count($play_list); $i++){?>
          <li class="playlistitem">
  					<a href="<?= "music.php?playlist=".basename($play_list[$i]) ?>"><?= basename($play_list[$i])?></a>
  				</li>
        <?php } ?>
			</ul>
		</div>
	</body>
</html>
