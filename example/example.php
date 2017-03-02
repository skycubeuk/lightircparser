<?php

require __DIR__ . './../vendor/autoload.php';

#Message without Tags
$msg = new Lightircparser\IRCMessage(":test!test@test.my.irc.server JOIN #test");
$msg->phrase();
echo json_encode($msg,JSON_PRETTY_PRINT);


#Message with Tags
$msg = new Lightircparser\IRCMessage("@display-name=TestUser;id=2362364236234634634;room-id=31462363463;sent-ts=1488375811149;admin=0;testp= :testuser!testuser@testuser.my.irc.server PRIVMSG #test :Hello! World");
$msg->phrase();
echo json_encode($msg,JSON_PRETTY_PRINT);


