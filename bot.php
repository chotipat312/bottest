$API_URL = 'https://api.line.me/v2/bot/message'
$ACCESS_TOKEN = '2zPSnuCBen6P2NKT1valm2LaxdclCKr52qhXj+Ey7OQQFJ6hUa7VLZB3pwhh+Gru49WDgaDZ7i6QmfPBwse3909SmDHC7qsCnhrrbQEpG+KdvPWjtNYflLFomcdg/SU5agtP7zml1ejKEUonC4mO2wdB04t89/1O/w1cDnyilFU='
$CHANNEL_SECRET = '3d3aec00ea9c95de93e902f4115a6502'
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN)
$request = file_get_contents('php://input')
$request_array = json_decode($request, true)
function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
if ( sizeof($request_array['events']) > 0 ) {
      foreach ($request_array['events'] as $event) {
      
      $reply_message = '';
      $reply_token = $event['replyToken'];
      $data = [
         'replyToken' => $reply_token,
         'messages' => [
            ['type' => 'text', 
             'text' => json_encode($request_array)]
         ]
      ];
      $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
      $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
      echo "Result: ".$send_result."\r\n";
   }
}
echo "OK";