<?php
/**
 * @package Fighting_The_Lyrics
 * @author Mike Robinson
 * @version 1.06
 */
/*
Plugin Name: Fighting The Lyrics
Plugin URI: http://wordpress.org/#
Description: Got tired of Hello Dolly lyrics, and being a Peter Gabriel fan, wrote this instead.
Author: Mike Robinson
Version: 1.06
Author URI: http://rile.ca/
License: GPL
*/

$fightingthelyricsdefaultoptions = array(
'fightingthelyrics_position'=>'absolute',
'fightingthelyrics_top'=>'3.5em',
'fightingthelyrics_margin'=>'0px 0px 0px 0px',
'fightingthelyrics_padding'=>'0px 0px 0px 0px',
'fightingthelyrics_right'=>'15px',
'fightingthelyrics_font-size'=>'12px',
'fightingthelyrics_color'=>'#FFFFFF'
);

$fightingthelyricsoptionsarr = array_keys($fightingthelyricsdefaultoptions);

function get_lyric() {
     // file naming convention is "Artist_Name-Album_Name-Song_Name.txt";
     // files should contain only lines with lyrics on them, no blank lines between verses etc
     $filespath = ABSPATH . "wp-content/plugins/fightingthelyrics/";
     $dirhandle = opendir($filespath);
     while (false !== ($file = readdir($dirhandle))) {
        if (($file != "." && $file != ".." && $file != 'readme.txt') && (substr($file,-4)=='.txt')) {
            $lyricsfiles[] = $file;
        }
     }
     if (count($lyricsfiles)==0) $lyrics = "You don't have any lyrics txt files in the directory " . $filespath;
     else {
        $lyricsfile = $lyricsfiles[mt_rand(0,count($lyricsfiles)-1)];
        $lyricsdataarr = explode("-",$lyricsfile);
        $group = str_replace("_"," ",$lyricsdataarr[0]);
        $album = str_replace("_"," ",$lyricsdataarr[1]);
        $song = str_replace("_"," ",substr($lyricsdataarr[2],0,-4));
        $filecontents = file_get_contents($filespath . $lyricsfile);
        $lyricslinesarr = explode("\n",$filecontents);
        $lyrics = $group . " - " . $album . " - " . $song . ": ";
        $lyrics .= trim($lyricslinesarr[mt_rand(0,count($lyricslinesarr)-1)]);
     }
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
	echo "<style type='text/css'>\n";
    echo "  #fightingthelyric {\n";
    $options = get_fightingthelyrics_options();
    foreach ($options as $optionname=>$optionval) {
        $optionname = str_replace("fightingthelyrics_","",$optionname);
        echo $optionname . ": " . $optionval . ";\n";
    }
    echo "    }\n";
	echo "</style>\n";
}

function fightingthelyrics_admin_actions() {  
    add_options_page("Fighting The Lyrics", "Fighting The Lyrics", 1, "Fighting The Lyrics", "fightingthelyrics_admin");
}

function fightingthelyrics_admin() {
    global $fightingthelyricsdefaultoptions, $fightingthelyricsoptionsarr;
    include('fightingthelyrics_admin.php');
}

function get_fightingthelyrics_options() {
    global $fightingthelyricsdefaultoptions, $fightingthelyricsoptionsarr;
    $fightingthelyricsoptions = array();
    foreach ($fightingthelyricsoptionsarr as $fightingthelyricsoption) {
        if (!$fightingthelyricsoptions[$fightingthelyricsoption] = get_option($fightingthelyricsoption)) {
            add_option($fightingthelyricsoption,$fightingthelyricsoptionsarr[$fightingthelyricsoption],'','yes');
            $fightingthelyricsoptions[$fightingthelyricsoption] = $fightingthelyricsoptionsarr[$fightingthelyricsoption];
        }
    }
	return $fightingthelyricsoptions;

}

add_action('admin_head', 'lyrics_css');
add_action('admin_menu', 'fightingthelyrics_admin_actions'); 
?>
