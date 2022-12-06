<?php
require_once("session.php");
$title = "The Bowl Challenge Trophy";

$useragent=$_SERVER['HTTP_USER_AGENT'];

// Check to see if this is a mobile device
$mobile = false;
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	$mobile = true;
}
?>
<html>
        <head>
                <title><?php echo $title;?></title>
                <link rel="stylesheet" href="/~jason/BowlManager/pure-release-0.5.0/pure-min.css">
                <link rel="stylesheet" type="text/css" href="manager_style.css">
        </head>

        <link rel="shortcut icon" href="icon.ico" />

	<body style="background-color:gray">

	<div id="wrapper">

	<h2 style="background-color:gray" <?php if ($mobile){ echo "style=\"font-size:450%\""; } ?> >The Bowl Challenge Trophy</h2>

	<IMG SRC="Trophy.png" ALT="Spongebob Trophy" TITLE="He's ready! Are you?" WIDTH=300 HEIGHT=400>

	<p <?php if ($mobile){ echo "style=\"font-size:26px\""; } ?> >
	The Family Bowl Challenge has gone on for over a decade,<br>and this Spongebob is the trophy awarded each year to the winner.<br>
	When the Challenge is over, the one with the most points<br>is presented the Trophy to keep until the next year.
	<br><br>
	<b><u>Previous Winners</b></u><br>
	2007-08 - Eric the Red & Jason *<br>
	2008-09 - Eric the Red<br>
	2009-10 - Jason<br>
	2010-11 - Sparky (a/k/a Alicia)<br>
	2011-12 - Grandpa Fritz<br>
	2012-13 - Charmaine<br>
	2013-14 - Alicia & Tim *<br>
	2014-15 - Eric the Red<br>
	2015-16 - Grandpa Fritz<br>
	2016-17 - Eric the Red<br>
	2017-18 - Eric the Red & Jason *<br>
	2018-19 - Alicia<br>
        2019-20 - Eric the Red<br>
	2020-21 - Grandpa Fritz<br></p>


	<p <?php if ($mobile){ echo "style=\"font-size:20px\""; } else { echo "style=\"font-size:11px\""; } ?> >
	* - Marks a year with a tie for first place </p>

	<br><br>
	<p  <?php if ($mobile){ echo "style=\"font-size:22px\""; }else{ "style=\"font-size:11px\"";} ?> >(To look at complete results from previous years, <a href="archives/index.html">click here</a>).</p>
	<br><br>

	<?php require_once("footer.php"); ?>

	</div>

	</body>
</html>

