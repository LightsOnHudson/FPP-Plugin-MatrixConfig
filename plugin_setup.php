<?php
//$DEBUG=true;

include_once "/opt/fpp/www/common.php";
include_once "functions.inc.php";
$pluginName = "MatrixConfig";


$channelType = "RGBMatrix";

$CHANNEL_CONFIG = array();

$CHANNEL_CONFIG = getChannelConfigsOfType($channelType);

//print_r($CHANNEL_CONFIG);

$channelStart = $CHANNEL_CONFIG[2];
$channelCount = $CHANNEL_CONFIG[3];
$tmpchannelData = $CHANNEL_CONFIG[4];

$channelData = explode("|",$CHANNEL_CONFIG[4]);

//print_r($channelData);
$pos = strpos($channelData[0], "panels=");
$pos = $pos+strlen("panels=");
//echo "POS: ".$pos."<br/> \n";
$channelData[0] = substr($channelData[0],$pos);
//print_r($channelData);


//print_r($_POST);
print_r($pluginSettings);

echo "plugin settings total panels: ".$pluginSettings['totalPanels']."<br/> \n";



$logFile = $settings['logDirectory']."/".$pluginName.".log";


if(isset($_POST['submit']))
{
	print_r($_POST);
	
	WriteSettingToFile("startChannel",urlencode($_POST["startChannel"]),$pluginName);
	WriteSettingToFile("channelCount",urlencode($_POST["channelCount"]),$pluginName);
	WriteSettingToFile("channelType",urlencode($_POST["channelType"]),$pluginName);
	WriteSettingToFile("totalPanels",urlencode($_POST["totalPanels"]),$pluginName);
	WriteSettingToFile("ENABLED",urlencode($_POST["ENABLED"]),$pluginName);
	WriteSettingToFile("LAST_READ",urlencode($_POST["LAST_READ"]),$pluginName);

}

if($channelStart == "") {
	$startChannel = $pluginSettings['startChannel'];
} else {
	$startChannel = $channelStart;
}
if($channelCount == "") {
	

	$channelCount = $pluginSettings['channelCount'];
}	
	
	$ENABLED = $pluginSettings["ENABLED"];
	

	if(isset($_POST['submit']) && $ENABLED == 1 )
	{
		echo "writing config";
		writeChannelOutputLayout($startChannel,$channelCount,$pluginSettings['totalPanels'],$panelNumber,$capeConnector,$panelOrientation,$panelX,$panelY);
	}
echo "ENABLED: ".$ENABLED."<br/> \n";

function writeChannelOutputLayout($startChannel,$channelCount,$totalPanels,$panelNumber,$capeConnector,$panelOrientation,$panelX,$panelY)
 {
	echo "wirting channel outpus: <br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	echo "channel count: ".$channelCount."<br/> \n";
	echo "total pnanels: ".$totalPanels."<br/> \n";
	echo "panel number: ".print_r($panelNumber)."<br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	echo "startchannel: ".$startChannel."<br/> \n";
	
}
?>

<html>
<head>
</head>

<div id="<?echo $pluginName;?>" class="settings">
<fieldset>
<legend><?echo $pluginName;?> Support Instructions</legend>

<p>Known Issues:
<ul>
<li>NONE</li>
</ul>

<p>Configuration:
<ul>
<li>Configure your panels with the outline below</li>
<li>NOTE: The highest number panel is the one directly connected to the BBB or PI</li>
</ul>


<p>DISCLAIMER:
<ul>
<li>WIP (Work in progress)</li>
</ul>


<form method="post" action="http://<? echo $_SERVER['SERVER_NAME']?>/plugin.php?plugin=<?echo $pluginName;?>&page=plugin_setup.php">


<?
//will add a 'reset' to this later

echo "<input type=\"hidden\" name=\"LAST_READ\" value=\"".$LAST_READ."\"> \n";

echo "<input type=\"hidden\" name=\"startChannel\" value=\"".$startChannel."\"> \n";

echo "<input type=\"hidden\" name=\"channelCount\" value=\"".$channelCount."\"> \n";

$restart=0;
$reboot=0;

echo "ENABLE PLUGIN: ";

if($ENABLED== 1 || $ENABLED == "on") {
		echo "<input type=\"checkbox\" checked name=\"ENABLED\"> \n";
//PrintSettingCheckbox("Radio Station", "ENABLED", $restart = 0, $reboot = 0, "ON", "OFF", $pluginName = $pluginName, $callbackName = "");
	} else {
		echo "<input type=\"checkbox\"  name=\"ENABLED\"> \n";
}




echo "<p/> \n";

printMatrixLayout($channelType,$channelData);
?>
<p/>
<input id="submit_button" name="submit" type="submit" class="buttons" value="Save Config">

</form>


<p>To report a bug, please file it against the sms Control plugin project on Git: https://github.com/LightsOnHudson/FPP-SMS

</fieldset>
</div>
<br />
</html>
