<!DOCTYPE html> <html> <head> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Home sweet home</title>
<style> .button {
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white;
  color: black;
  border: 2px solid #4CAF50;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}

.button2 {
  background-color: white;
  color: black;
  border: 2px solid #008CBA;
}

.button2:hover {
  background-color: #008CBA;
  color: white;
}

</style>
</head>
<body>

<h1>Home sweet home</h1>
<a href="http://pi.lan:8000"><button class="button button1">Refresh me!</button></a>

<?php
$remote_addr = $_SERVER['REMOTE_ADDR'];
$remote_port = $_SERVER['REMOTE_PORT'];
$http_user_agent = $_SERVER['HTTP_USER_AGENT'];

//API to get ARP and queries
$url = "http://192.168.1.2:5000/client?ip={$remote_addr}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
if (curl_errno($ch)) { echo curl_error($ch); }
else {
  $decoded = json_decode($result, true);
}
$query_result = $decoded["query_result"];
$arp_result = $decoded["arp_result"];


//
$url = "https://www.timeapi.io/api/Time/current/coordinate?latitude=40.56&longitude=-74.46";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
if (curl_errno($ch)) { echo curl_error($ch); }
else {
  $decoded = json_decode($result, true);
}

//#print_r($decoded);

$date_us = $decoded["date"];
$timeZone_us = $decoded["timeZone"];
$time_us = $decoded["time"];
$dayOfWeek_us = $decoded["dayOfWeek"];

//#$decoded["dstActive"];


$url = "https://www.timeapi.io/api/Time/current/coordinate?latitude=-23.54&longitude=-46.63";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
if (curl_errno($ch)) { echo curl_error($ch); }
else {
  $decoded = json_decode($result, true);
}
//#print_r($decoded);
$date_br = $decoded["date"];
$timeZone_br = $decoded["timeZone"];
$time_br = $decoded["time"];
$dayOfWeek_br = $decoded["dayOfWeek"];

?>
<br>
<img src="kenobi.png" alt="Hello there">
<br>
Hello there! this looks like you... IP address <strong><?php echo $remote_addr?></strong>.
<br>
Browser and OS details: <strong><?php echo $http_user_agent?></strong>
<br>

<table>
  <tr>
    <th>Time Zone</th>
    <th>Time</th>
    <th>Date</th>
  </tr>
  <tr>
    <td><?php echo $timeZone_br?></td>
    <td><?php echo $time_br?></td>
    <td><?php echo $date_br; echo $dayOfWeek_br?></td>
  </tr>
  <tr>
    <td><?php echo $timeZone_us?></td>
    <td><?php echo $time_us?></td>
    <td><?php echo $date_us; echo $dayOfWeek_us?></td>
  </tr>
</table>


<br>
<strong>ARP Table</strong>
<br>
<?php echo $arp_result?>
<br>
<strong>Queries</strong>
<br>
<?php echo $query_result?>
<br>



<!--
<div id="ww_bf4f018527732" v='1.3' loc='id' a='{"t":"horizontal","lang":"en","sl_lpl":1,"ids":["wl729"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>Weather Data Source: <a href="https://sharpweather.com/weather_new_jersey/" id="ww_bf4f018527732_u" target="_blank">New Jersey weather forecast</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_bf4f018527732"></script>

<div id="ww_cca8ec76de7fa" v='1.3' loc='id' a='{"t":"responsive","lang":"en","sl_lpl":1,"ids":["wl729"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>Weather Data Source: <a href="https://sharpweather.com/weather_new_jersey/" id="ww_cca8ec76de7fa_u" target="_blank">New Jersey weather forecast</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_cca8ec76de7fa"></script>

<a class="weatherwidget-io" href="https://forecast7.com/en/n23d09n47d21/indaiatuba/" data-label_1="INDAIATUBA" data-label_2="WEATHER" data-theme="original" >INDAIATUBA WEATHER</a> <script> !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js'); </script>

<br>
<br>
<a href="http://pi.lan:3001/status/home" target="_blank" rel="noopener noreferrer"><button class="button button1">Go to Uptime status</button></a>
<a href="http://pi.lan/admin" target="_blank" rel="noopener noreferrer"><button class="button button2">Go to Pihole DNS sinkhole</button></a>
<a href="http://pi.lan:8000/server" target="_blank" rel="noopener noreferrer"><button class="button button2">Access Raspberry Pi</button></a>
<br>
<br>

<h1>NJ News12</h1>
<iframe src="https://newjersey.news12.com/" height="500" width="100%" title="njnews"></iframe>
<br>
<h1>NJ Weather Alerts</h1>
<iframe src="https://alerts.weather.gov/cap/nj.php?x=1" height="500" width="100%" title="weatheralerts"></iframe>
<br>
<h1>NJ Counties</h1>
<iframe src="https://www.nj.gov/state/archives/catctytable.html" height="500" width="100%" title="njcounty"></iframe>
<br>

<br>
<a href="https://www.globo.com/" target="_blank" rel="noopener noreferrer"><button class="button button2">Go to Globo.com</button></a>
<iframe src="https://www.globo.com/" height="500" width="100%" title="Globo"></iframe>
<br>


-->


</body>
</html>
