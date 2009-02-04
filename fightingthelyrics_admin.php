<?php


if($_POST['update_options'] == 'Y') {
   
    $optionsupdated = FALSE;
    $updatedoptions = array();
    $ignoredoptions = array();
    foreach ($fightingthelyricsoptionsarr as $newfightingthelyricsoption) {
        if(isset($_POST[$newfightingthelyricsoption])) {
            $oldoption = get_option($newfightingthelyricsoption);
            if ($_POST[$newfightingthelyricsoption]!=$oldoption) {
                if (update_option($newfightingthelyricsoption,$_POST[$newfightingthelyricsoption])) {
                    $updatedoptions[$newfightingthelyricsoption] = TRUE;
                }
            }
            else $ignoredoptions[$newfightingthelyricsoption] = TRUE;
        }
    }
    $optionsupdated = TRUE;
}

$options = get_fightingthelyrics_options();
foreach($fightingthelyricsoptionsarr as $fightingthelyricsoption) {
    if (!$options[$fightingthelyricsoption]) $options[$fightingthelyricsoption] = $fightingthelyricsdefaultoptions[$fightingthelyricsoption];
}
?>
<div class="wrap">
<?php    echo "<h2>" . __( 'Fighting The Lyrics Options', '' ) . "</h2>"; ?> 
Valid CSS entries for the styles only. This form will let you make mistakes. If your
lyrics disappear, it probably has something to do with what you've done here.<br />
<br />
<?php
if ($optionsupdated) {
    if (count($updatedoptions)>0) {
        echo count($updatedoptions) . " options updated<br />";
    }
    if (count($ignoredoptions)>0) {
        echo count($ignoredoptions) . " options ignored (no changes)<br />";
    }
    echo "<br />";
}
?>


<form name="fightingthelyrics_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="update_options" value="Y">

<table>
<tr>
<td><?php _e('Position: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><select name="fightingthelyrics_position">
<option value="absolute"<?php if ($options['fightingthelyrics_position']=='absolute') echo " selected"; ?>>absolute (recommended)</option>
<option value="relative"<?php if ($options['fightingthelyrics_position']=='relative') echo " selected"; ?>>relative</option>
</select>
</td>
</tr>

<tr>
<td><?php _e('Top: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_top" value="<?php echo $options['fightingthelyrics_top']; ?>"></td>
</tr>


<tr>
<td><?php _e('Margin: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_margin" value="<?php echo $options['fightingthelyrics_margin']; ?>"></td>
</tr>

<tr>
<td><?php _e('Padding: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_padding" value="<?php echo $options['fightingthelyrics_padding']; ?>"></td>
</tr>

<tr>
<td><?php _e('Right: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_right" value="<?php echo $options['fightingthelyrics_right']; ?>"></td>
</tr>

<tr>
<td><?php _e('Font Size: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_font-size" value="<?php echo $options['fightingthelyrics_font-size']; ?>"></td>
</tr>

<tr>
<td><?php _e('Font Color: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="text" name="fightingthelyrics_color" value="<?php echo $options['fightingthelyrics_color']; ?>"></td>
</tr>

<tr>
<td><?php _e('Font Color: ', ''); ?></td>
<td>&nbsp;&nbsp;</td>
<td><input type="submit" name="submit" value="<?php _e('Update Options', '' ) ?>" /> </td>
</tr>


</table>



 
</form>
 
 
</div>