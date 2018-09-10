<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

define("BOT_TOKEN", "630788166:AAGJ0s62LlXbEOQmMOaUi-bRgVTYVZLPdEs");

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['from']['first_name']) ? $message['from']['first_name'] : "";
$lastname = isset($message['from']['last_name']) ? $message['from']['last_name'] : "";
$username = isset($message['from']['username']) ? $message['from']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

if($text == "/start") {
  // start bot esco e non inoltro
  exit;
}

if(isset($message['sticker'])) {
   // verifico lo stickers
   $setName = $message['sticker']['set_name'];
  
   if($setName != 'GoTest' || $setName != 'goeasytwitch') {
      $botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/deleteMessage";

      $postFieldsForDelete = array('chat_id' => $chatId, 'message_id' => $messageId);

      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
      curl_setopt($ch, CURLOPT_URL, $botUrl); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldsForDelete);
     
      // read curl response
      $output = curl_exec($ch);
     
      $textOut = $firstname . ' ' . $lastname . ' hai usato uno stikers non ammesso in questo gruppo (da $setName)! (cancellato)';

      header("Content-Type: application/json");
      $parameters = array('chat_id' => $chatId, 'text' => $textOut);
      $parameters["method"] = "sendMessage";
      echo json_encode($parameters);
   }
  
}
?>
