<?php
print "Hello, Worldmmmmmmmmmmmmmmmmmmmmm222222222222222222222222222222mmmmmmmmmmmmmmmmm! php version is " . PHP_VERSION . "\n";

$a=  preg_replace('~.*?\?~', '', $_SERVER['REQUEST_URI']);
parse_str($a, $output);

echo "<head><meta http-equiv=\"refresh\" content=\"60\"><link rel=\"stylesheet\" media=\"all\" href=\"./style.css\" /></head><body><div class=\"header\"><img src=\"./logo2x.png\" /></div>";

$dt = new DateTime("now", new DateTimeZone('Europe/Minsk'));

system("curl --verbose --request GET --header \"Version: 4\" --header \"Content-Type: application/xml\" --header \"Accept: application/json\" http://172.20.194.21:8081/tsm4rhev/api/queryoperations | jq '.[] | .[] | .[] | select(.guid==\"" . $output['guid'] . "\")' | sed \"s/:/|/\" | sed '\$d' | sed '1d' | awk -F \"|\" '{ print \"<div class=\\\"log2\\\"><span class=\\\"green\\\">\"$1\"</span><span class=\\\"red\\\">\"$2\"</span></div>\" }' " ); 
system("curl --verbose --request GET --header \"Version: 4\" --header \"Content-Type: application/xml\" --header \"Accept: application/json\"  http://172.20.194.21:8081/tsm4rhev/api/queryoperationreport?guid=" . $output['guid'] ."  | jq '.[]|.[]|.[]|.[]| del(.disk_array)' | grep ':' | sed \"s/:/|/\" | grep 'name\|duration' | awk -F \"|\" '{ print \"<div class=\\\"log2\\\"><span class=\\\"green\\\">\"$1\"</span><span class=\\\"red\\\">\"$2\"</span></div>\" }' " ); 
echo "<br />";
system("curl --verbose --request GET --header \"Version: 4\" --header \"Content-Type: application/xml\" --header \"Accept: application/json\" http://172.20.194.21:8081/tsm4rhev/api/querylog?guid=" . $output['guid'] . "  | jq -r '.[] | .[] | .[]' | sed 's/$/<\/div>/' | sed 's/^/<div class=\"log\">/' " ); 
echo "<div class=\"footer\">Page refreshed: ".$dt->format('m/d/Y, H:i:s')."</div>";
echo "</body>";


/* echo  "Your request queued. Wait for the message."; */
?>
