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
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

if($text == "/start") {
  // start bot esco e non inoltro
  exit;
} 

$botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/deleteMessage";

$postFieldsForDelete = array('chat_id' => $chatId, 'message_id' => $messageId);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
curl_setopt($ch, CURLOPT_URL, $botUrl); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldsForDelete);

// read curl response
$output = curl_exec($ch);

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $message . " - " . $output);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);

?>
