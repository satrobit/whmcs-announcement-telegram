<?php

/**
 * whmcs-announcement-telegram
 * https://github.com/satrobit/whmcs-announcement-telegram
 *
 * Copyright (c) 2016 Amir Keshavarz
 * Licensed under the MIT license.
 */

define('TOKEN', 'bot_token_here');
define('CHANNEL', '@channel_name_here');


function sendMessage($text)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . TOKEN . '/sendMessage');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'text=' . $text . '&chat_id=' . CHANNEL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = json_decode(curl_exec($ch), true);
	curl_close($ch);

	return $result['ok'];
}

add_hook('AnnouncementAdd', 1, function ($vars) 
{
	$result = $vars['published'] ? sendMessage($vars['announcement']) : false;
	return $result;
});

?>