<?php

require("inc/funcs.php");

html_init();
?>
<body>
<?php
	$ret=bbs_getwebmsg($srcid,$msgbuf,$srcutmpnum,$sndtime);
	if ($ret!=0)  {
		if ($currentuser['userdefine0'] & BBS_DEF_SOUNDMSG) {
			echo '<bgsound src="sound/msg.wav">';
		}
?> 
	<div id="msgcontent">
<div onkeydown="if(event.keyCode==13 && event.ctrlKey) { replyMsg('<?php echo $srcid; ?>'); };if(event.keyCode==13 && ! event.ctrlKey) { closeWindow(); } ">
	<table cellspacing=1 cellpadding=0 align=center width="100%" class=TableBorder1 >
	<thead>
	<TR><Th height=20 align=left id=TableTitleLink align="center">
<?php
	if($srcid == "վ���㲥") {
?>
	վ����(<?php echo strftime("%b %e %H:%M", $sndtime); ?>)�㲥��
<?php
	}
	else {
?>
	<a href="dispuser.php?id=><?php echo $srcid; ?>" target=_blank><?php echo $srcid; ?></a>��(<?php echo strftime("%b %e %H:%M", $sndtime); ?>)���͸����Ķ��ţ�
<?php
	}
?>
	</th></tr></thead>
	<tbody>
	  <tr>
		<td height=110 align="left" valign="top" class=TableBody1><?php echo htmlspecialchars($msgbuf); ?> </td>
	  </tr>
	  <tr>
		<td height=20 align="right" valign="top" nowrap="nowrap" class=TableBody2>
<?php
	if($srcid == "վ���㲥") {
?>
	<a href="#" onclick="closeWindow();">[�ر�]</a>
<?php
	}
	else {
?>
	<a  href="javascript:replyMsg('<?php 
	echo $srcid; ?>')" >[��ѶϢ]</a> <a href="#" onclick="closeWindow();">[����]</a>
<?php
	}
?>
	</td>
	  </tr>
	 </tbody>
	</table>
</div>
	</div>
	<script language="javascript">
	oFloater=getParentRawObject("floater");
	oMsg=getRawObject("msgcontent");
	oFloater.innerHTML=oMsg.innerHTML;
	show(oFloater);
	</script>
<?php
	}else {
?>
	<script language="javascript">
	parent.refreshWindow();
	</script>
<?php
	}
?>
</body>
</htmL>