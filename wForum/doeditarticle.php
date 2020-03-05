<?php

require("inc/funcs.php");
require("inc/user.inc.php");
require("inc/board.inc.php");

global $boardArr;
global $boardID;
global $boardName;
global $reID;
global $reArticles;

setStat("�༭����");

requireLoginok("�οͲ��ܱ༭���¡�");

preprocess();

show_nav(false);

showUserMailBoxOrBR();
board_head_var($boardArr['DESC'],$boardName,$boardArr['SECNUM']);
doPostAritcles($boardID,$boardName,$boardArr,$reID,$reArticles);

show_footer();

function preprocess(){
	global $boardID;
	global $boardName;
	global $currentuser;
	global $boardArr;
	global $reID;
	global $reArticles;
	if (!isset($_POST['board'])) {
		foundErr("δָ�����档");
	}
	$boardName=$_POST['board'];
	$brdArr=array();
	$boardID= bbs_getboard($boardName,$brdArr);
	$boardArr=$brdArr;
	$boardName=$brdArr['NAME'];
	if ($boardID==0) {
		foundErr("ָ���İ��治����");
	}
	$usernum = $currentuser["index"];
	if (bbs_checkreadperm($usernum, $boardID) == 0) {
		foundErr("����Ȩ�Ķ�����");
	}
	if (bbs_is_readonly_board($boardArr)) {
		foundErr("����Ϊֻ����������");
	}
	if (bbs_checkpostperm($usernum, $boardID) == 0) {
		foundErr("����Ȩ�Ķ�����");
	}
	if (!isset($_POST['Content'])) {
		foundErr("û��ָ���������ݣ�");
	}
	if (isset($_POST["reID"])) {
		$reID = $_POST["reID"];
	} else {
		foundErr("δָ���༭������.");
	}
	settype($reID, "integer");
	$articles = array();
	if ($reID > 0)	{
	$num = bbs_get_records_from_id($boardName, $reID,$dir_modes["NORMAL"],$articles);
		if ($num == 0)	{
			foundErr("����������ı��");
		}
	}
	$ret = bbs_article_deny_modify($boardName, $reID);
	if ($ret) foundErr(bbs_error_get_desc($ret));
	$reArticles=$articles;
	return true;
}

function doPostAritcles($boardID,$boardName,$boardArr,$reID,$reArticles){
	$ret=bbs_updatearticle($boardName,$reArticles[1]['FILENAME'],$_POST['Content']);
	switch ($ret) {
		case -1:
			foundErr("�޸�����ʧ�ܣ����¿��ܺ��в�ǡ������");
		case -10:
			foundErr("�Ҳ����ļ�!");
	}
?>
<table cellpadding=3 cellspacing=1 align=center class=TableBorder1 style="width: 75%;">
<tr align=center><th width="100%">���±༭�ɹ�</td>
</tr><tr><td width="100%" class=TableBody1>
��ҳ�潫��3����Զ����ذ��������б�<meta HTTP-EQUIV=REFRESH CONTENT='3; URL=board.php?name=<?php echo $boardName; ?>' >��<b>������ѡ�����²�����</b><br><ul>
<li><a href="index.php">������ҳ</a></li>
<li><a href="board.php?name=<?php   echo $boardName; ?>">����<?php   echo $boardArr['DESC']; ?></a></li>
</ul></td></tr></table>
<?php
}
?>