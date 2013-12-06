<?php


/**

 * The Template for displaying a newsletter

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */









?><?php while ( have_posts() ) : the_post(); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo get_the_title(); ?></title>
</head>

<body style="margin: 0; padding: 0;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#000000" style="padding: 10px 15px 10px 15px;"><table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="227" align="left" valign="top" bgcolor="#000000"><br />          <img src="http://www.itavenues.co.uk/emailers/2013-07/ita.jpg" width="161" height="79" alt="ITA" /></td>
        <td width="373" align="right" valign="top" bgcolor="#000000" style="padding-right:15px;"><p><span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; font-weight:bold; color: #FFF;"><img src="http://itavenues.co.uk/emailers/fonts/text.jpg?color=white&align=right&width=300&font=100&rotate=2&text=<?php echo urlencode(get_the_title()); ?>" alt="<?php echo get_the_title(); ?>" width="300" /></span><br />
          <span style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color: #FFF;"><?php echo get_the_content(); ?></span></p></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php

$nlstories = get_posts( array('post_type' => 'newsletterstory', 'orderby' => 'menu_order') );

$colours = array(

"FFD300",

"FFEE9D",

"999999",  // #ffd300 cta

"CCCCCC",

"FFFFFF",// #ffd300 cta

);


$colours_ctas =  array(

"FFD300" => "ffffff",

"FFEE9D" => "ffffff",

"999999" => "ffd300",  // #ffd300 cta

"CCCCCC" => "ffffff",

"FFFFFF" => "ffd300",// #ffd300 cta

);

reset($colours);

$prev = "000000";

$x = 0;

		foreach( $nlstories as $story ):
		
		if ($x == 0)
		{
			// odd
			$rotate = '-3';
			$align = 'right';
			$x = 1;
		} else {
			$rotate = '3';
			$align = 'left';
			$x = 0;
		}
			
		$current = current($colours);
		
		$cta_colour = $colours_ctas[$current];
		
		$next = next($colours);
		if (!$next)
		{
			reset($colors);
			$next = current($colors);
		}
		
		?>

<?php

$cta_link = get_post_meta($story->ID,"_newsletter_story_cta_link",true);
$cta_text = get_post_meta($story->ID,"_newsletter_story_cta_text",true);
$imgcaption = urlencode(get_post_meta($story->ID,"_newsletter_story_imgcaption",true));

$imgurl = wp_get_attachment_url( get_post_thumbnail_id($story->ID) );
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top" bgcolor="#<?php echo $current; ?>" style="padding: 0px;"><img src="http://www.itavenues.co.uk/emailers/fonts/triangle.png?colour=<?php echo $prev; ?>&ddd" style="margin:0; padding:0; display:inline-block;" alt="" width="50" height="18" /></td>
  </tr><tr>
    <td align="center" valign="top" bgcolor="#<?php echo $current; ?>" style="padding: 20px 15px 20px 15px;"><table cellpadding="0" cellspacing="0" width="600" style="border:none;">
      <tr>
        <?php $prev = $current; ?>
        <?php 
		
		$content = '<td width="304" align="left" valign="top"  style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color: #333; padding:10px;"><p style="font-size: 16px; font-weight: bold;"><strong>
		' . $story->post_title . '</strong></p>
         ' . $story->post_content . '
         <br />
<br />
 <a href="' . $cta_link . '" style="text-decoration:none; color:#000000; font-size: 16px; font-family: Arial, Helvetica, sans-serif; font-weight: bold;"><table width="250" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="250" style="padding:0;" align="center" valign="middle"><img src="http://www.itavenues.co.uk/emailers/standard/top-' . $cta_colour . '.png" width="286" style="margin:0;display:block;border:none;" border="0"  height="18" alt=""/></td>
              </tr>
            <tr>
              <td style="padding:5px;" align="center" valign="middle" bgcolor="#' . $cta_colour . '">' . strtoupper($cta_text) . '</td>
            </tr>
            <tr>
              <td style="padding:0;" align="center" valign="middle"><img src="http://www.itavenues.co.uk/emailers/standard/bottom-' . $cta_colour . '.png" width="286" height="18" style="margin:0;display:block;border:none;" border="0" alt=""/></td>
            </tr>
          </table></a></td>
      '; 

$imagepart = '<td width="291" align="left" valign="top"  style="border-bottom:none; border-right:none; padding: 10px;"><a href="' . $cta_link . '"><img src="http://www.itavenues.co.uk/emailers/fonts/polaroid.png?url=' . $imgurl . '&width=500&rotate=' . $rotate . '" alt="" width="324" height="198" border="0" style="display:block; border:none;"/></a><img src="http://www.itavenues.co.uk/emailers/fonts/text.png?color=black&align=' . $align . '&width=648&font=120&rotate=' . $rotate . '&text=' . $imgcaption . '" alt="' .  $imgcaption . '"  border="0" style="display:block; border:none;width:326px;height:auto;"/></td>';

if ($align == "right")
{

	echo $content;
	echo $imagepart;
} else {
	
	echo $imagepart;
	echo $content;
}



 ?>
</tr>
    </table></td>
</tr>
</table>

<?php endforeach; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top" bgcolor="#000000" style="padding: 0px;"><img src="http://www.itavenues.co.uk/emailers/fonts/triangle.png?colour=<?php echo $prev; ?>&ddd" style="margin:0; padding:0; display:inline-block;" alt="" width="50" height="18" /></td>
  </tr>
  
  <tr>
    <td align="center" valign="middle" bgcolor="#000000" style="padding: 30px 15px 0px 15px;"><table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="24" bgcolor="#000000" style="font-size: 1px; line-height: 1px;"><img style='display:block;margin:0;' border="0" src="http://www.itavenues.co.uk/emailers/standard/images/spacer.gif" width="1" height="1" /></td>
        <td align="right" bgcolor="#000000"><a href="http://www.itavenues.co.uk"><img src="http://www.itavenues.co.uk/emailers/standard/images/ita-top.jpg?3hh3" alt="ITA" width="226" height="199" border="0" style="display:block;margin:0;"  /></a></td>
        <td width="10" bgcolor="#000000"></td>
        <td width="315" bgcolor="#000000"><a href="http://www.facebook.com/itavenues"><img src="http://www.itavenues.co.uk/emailers/standard/images/facebook.jpg" alt="Facebook.com/itavenues" width="315" height="60" border="0" style="display:block;margin:0;"  /></a><br />
          <a href="http://www.twitter.com/itavenues"><img src="http://www.itavenues.co.uk/emailers/standard/images/twitter.jpg" alt="twitter.com/itavenues" width="315" height="66" border="0" style="display:block;margin:0;"  /></a><br /></td>
      </tr>
    </table>
      <table width="600" cellpadding="0" cellspacing="0" style="#ffd300" >
        <tr>
          <td width="46" bgcolor="#000000"><img style='display:block;margin:0;' border="0" src="http://www.itavenues.co.uk/emailers/standard/images/spacer.gif" width="46" height="1"  /></td>
          <td width="554" bgcolor="#000000"><img style='display:block;margin:0;' border="0" src="http://www.itavenues.co.uk/emailers/standard/images/bubble-top.jpg" width="554" height="45" /></td>
        </tr>
      </table>
      <table width="600" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000"><img style='display:block;margin:0;' border="0" src="http://www.itavenues.co.uk/emailers/standard/images/spacer.gif" width="46" height="1" /></td>
          <td width="126"><a href="http://www.itavenues.co.uk/emailers/Temp/*|UNSUB|*"><img src="http://www.itavenues.co.uk/emailers/standard/images/unsubscribe.jpg" alt="unsubscribe" width="126" height="47" border="0" style='display:block;margin:0;' /></a></td>
          <td width="140"><a href="http://www.itavenues.co.uk/emailers/Temp/*|FORWARD|*"><img src="http://www.itavenues.co.uk/emailers/standard/images/send-to-a-friend.jpg" alt="send to a friend" width="140" height="47" border="0" style='display:block;margin:0;' /></a></td>
          <td width="145"><a href="http://www.itavenues.co.uk/"><img src="http://www.itavenues.co.uk/emailers/standard/images/visit-our-website.jpg" alt="visit our website" width="145" height="47" border="0" style='display:block;margin:0;' /></a></td>
          <td width="143"><a href="mailto:sales@itavenues.co.uk"><img src="http://www.itavenues.co.uk/emailers/standard/images/contact-us.jpg" alt="contact us" width="143" height="47" border="0" style='display:block;margin:0;' /></a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php endwhile; // end of the loop. ?>
</body>
</html>
