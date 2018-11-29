<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

define("BOT_TOKEN", "798642437:AAExbOeROBQnIS6zJWT31BjaKQkOlih2-3E");

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
   // $setName = $message['sticker']['set_name'];
  
     
    // $textOut = $firstname . ' ' . $lastname . ' hai usato uno stikers non ammesso in questo gruppo (da ' . $setName . ')! (cancellato)';

      header("Content-Type: application/json");
      $parameters = array('chat_id' => $chatId, 'text' => $message['sticker']);
      $parameters["method"] = "sendMessage";
      echo json_encode($parameters);
   
  
}
?>
