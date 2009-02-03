<?php
/**
 * @package Fighting_The_Lyrics
 * @author Mike Robinson
 * @version 1.01
 */
/*
Plugin Name: Fighting The Lyrics
Plugin URI: http://wordpress.org/#
Description: Got tired of Hello Dolly lyrics, and being a Peter Gabriel fan, wrote this instead.
Author: Mike Robinson
Version: 1.01
Author URI: http://rile.ca/
License: GPL
*/

function get_lyric() {
     // file naming convention is "Artist_Name-Album_Name-Song_Name.txt";
     // files should contain only lines with lyrics on them, no blank lines between verses etc
     $filespath = ABSPATH . "wp-content/plugins/fightingthelyrics/*.txt";
     $lyricsfiles = glob($filespath);
     if (count($lyricsfiles)==0) $lyrics = "You don't have any lyrics txt files in the directory " . $filespath;
     else {
        $lyricsfile = $lyricsfiles[mt_rand(0,count($lyricsfiles)-1)];
        $lyricsfilename = substr($lyricsfile,strrpos($lyricsfile, '/')+1);
        $lyricsdataarr = explode("-",$lyricsfilename);
        $group = str_replace("_"," ",$lyricsdataarr[0]);
        $album = str_replace("_"," ",$lyricsdataarr[1]);
        $song = str_replace("_"," ",substr($lyricsdataarr[2],0,-4));
        $filecontents = file_get_contents($lyricsfile);
        $lyricslinesarr = explode("\n",$filecontents);
        $lyrics = $group . " - " . $album . " - " . $song . ": ";
        $lyrics .= trim($lyricslinesarr[mt_rand(0,count($lyricslinesarr)-1)]);
     }

	// Here we split it into lines
	//$lyrics = explode("\n", $lyrics);

	// And then randomly choose a line
	return wptexturize($lyrics);
}

// This just echoes the chosen line, we'll position it later
function show_lyrics() {
	$chosen = get_lyric();
	echo "<p id=\"fightingthelyric\">" . $chosen . "</p>";
}

// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'show_lyrics');

// We need some CSS to position the paragraph
function lyrics_css() {
	echo "
	<style type='text/css'>
	#fightingthelyric {
		position: absolute;
		top: 3.5em;
		margin: 0;
		padding: 0;
		right: 15px;
		font-size: 12px;
        color: #FFFFFF;
	}
	</style>
	";
}

add_action('admin_head', 'lyrics_css');

?>
