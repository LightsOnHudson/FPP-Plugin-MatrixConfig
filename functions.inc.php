<?php
function getChannelConfigsOfType($channelType,$channelData) {

	global $settings;
	$CHANNEL_OUTPUTS_DATA = file_get_contents($settings['channelOutputsFile']);

	//echo "Getting channel config for type: ".$channelType."<br/> \n";
	//echo $CHANNEL_OUTPUTS_DATA."<br/> \n";
	$CHANNEL_CONFIGS = explode("\n",$CHANNEL_OUTPUTS_DATA);

	//print_r($CHANNEL_CONFIGS);
	
	for($i=0;$i<count($CHANNEL_CONFIGS);$i++) {
		$configParts="";
		//echo "index: ".$i."<br/> \n";
		$configParts = explode(",",$CHANNEL_CONFIGS[$i]);
		
		//print_r($configParts);
		
		if($configParts[1]==$channelType) {
		//	echo "CHANNEL TYPE FOUND <br/> \n";
			
			
			return $configParts;
		}
	}

}

function printMatrixLayout($channelType,$channelData) {
	
	global $pluginSettings;
	
	echo "<input type=\"hidden\" name=\"channelType\" value=\"".$channelType."\"> \n";
	
	//$hostType="ADAFRUIT_HAT";
	$hostType="OCTOSCROLLER";
	
	switch($hostType) {
		
		case "ADAFRUIT_HAT":
			$capeConnectors=1;
			break;
			
		case "OCTOSCROLLER":
			$capeConnectors=8;
			break;
	}
	
	$panelNumbers=8;
	
//	print_r($pluginSetings);
	
	$MAXPANELS = 65;
	//echo "pluginSettings total panels: ".$pluginSettings['totalPanels']."<br/> \n";
	
	
	if($pluginSettings['totalPanels'] > 0 ) {
		$totalPanels = $pluginSettings['totalPanels'];
	} elseif($channelData != "" ){
		$totalPanels = count($channelData);
		
	} else {
		$totalPanels=1;
	}
	
	echo "Panel count: \n";
	printCapeConnectorSelection($MAXPANELS,$totalPanels,"totalPanels");
	//echo "panel count: ".count($channelData);
	echo "<br/> \n";
	
	echo "<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"> \n";
	
	
	echo "<tr> \n";
	echo "<td> \n";
	echo "Panel \n";
	echo "</td> \n";
	
	echo "<td> \n";
	echo "Connector  \n";
	echo "</td> \n";
	
	
	echo "<td> \n";
	echo "Panel Orientation <br/> Arrow Direction  \n";
	echo "</td> \n";
	
	
	echo "<td> \n";
	echo "Upper Left X \n";
	echo "</td> \n";
	
	echo "<td> \n";
	echo "Upper Left Y \n";
	echo "</td> \n";
	echo "</tr> \n";
	
	//echo "<tr> \n";
	//should we try to put the panels in the proper order???
	
	for($i=0;$i<=$totalPanels-1;$i++) {
		echo "<tr> \n";
		
		if($channelData[$i] != "") {
		$panelConfig = explode(":",$channelData[$i]);
		
		for($d=0;$d<=count($channelData[$i])-1;$d++) {
			
			echo "<td> \n";
			echo printCapeConnectorSelection($totalPanels,$panelConfig[1],"panelNumber[]");
			echo "</td> \n";
			
		echo "<td> \n";
			//echo "Device Connector position: ";
			printCapeConnectorSelection($capeConnectors,$panelConfig[0],"capeConnector[]");
		
		echo "</td> \n";
		//print_r($panelConfig);
		}
		} else {
			echo "<td> \n";
			echo printCapeConnectorSelection($totalPanels,"0","panelNumber[]");
			echo "</td> \n";
				
			echo "<td> \n";
			//echo "Device Connector position: ";
			printCapeConnectorSelection($capeConnectors,"0","capeConnector[]");
			
			echo "</td> \n";
			
		}
		echo "<td> \n";
			printPanelOrientation($panelConfig[2]);
			
		echo "</td> \n";
		
		echo "<td> \n";
			echo "<input type=\"text\" name=\"panelX[]\" value=\"".$panelConfig[3]."\"> \n";
			
		echo "</td> \n";
		
		echo "<td> \n";
		echo "<input type=\"text\" name=\"panelY[]\" value=\"".$panelConfig[4]."\"> \n";
		echo "</td> \n";
		
		
		echo "</tr> \n";
	}
	
	echo "</table> \n";
}
function printPanelOrientation($selectedValue) {
	
	$panelDirections  = array("N","U","L","R");
	
	echo "<select name=\"panelOrientation[]\"> \n";
	
	for($i=0;$i<=count($panelDirections)-1;$i++) {
		if($panelDirections[$i] == $selectedValue) {
			echo "<option selected value=\"".$selectedValue."\">".$selectedValue."</option> \n";
		} else {
			echo "<option  value=\"".$panelDirections[$i]."\">".$panelDirections[$i]."</option> \n";
		}
	}
	
	echo "</select> \n";
}
function printCapeConnectorSelection($capeConnectors,$selectedValue,$selectedName) {
	
	echo "<select name=\"".$selectedName."\"> \n";
	
	for($i=0;$i<$capeConnectors;$i++) {
		if($i == $selectedValue) {
			echo "<option selected value=\"".$selectedValue."\">".$selectedValue."</option> \n";
		} else {
			echo "<option value=\"".$i."\">".$i."</option> \n";
		}
	}
	echo "</select> \n";
}