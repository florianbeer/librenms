<?php

global $valid_sensor;

if ($device['os'] == 'ies')
{

  echo("ZyXEL IES ");
  
  $oids = array();  
  
  $oids = snmpwalk_cache_multi_oid($device, "accessSwitchSysTempCurValue", $oids, "ZYXEL-AS-MIB");
  $oids = snmpwalk_cache_multi_oid($device, "accessSwitchSysTempHighThresh", $oids, "ZYXEL-AS-MIB");
  
  if(is_array($oids[$device['device_id']]))
  {
    foreach($oids[$device[device_id]] as $index => $entry)
    {
      $entPhysicalIndex = $index;
      $descr = trim(snmp_get($device, "accessSwitchSysTempDescr.".$index, "-Oqv", "ZYXEL-AS-MIB"),'"');
      $oid = ".1.3.6.1.4.1.890.1.5.1.1.6.1.2.".$index;
      $current = $entry['accessSwitchSysTempCurValue'];
      $divisor = '1';
      discover_sensor($valid_sensor, 'temperature', $device, $oid, $index, 'zyxel-ies', $descr, '1', '1', NULL, $entry['accessSwitchSysTempHighThresh'], NULL, NULL, $current); 
    }
  }
}
?>
