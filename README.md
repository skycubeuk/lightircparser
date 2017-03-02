## Synopsis

PHP parser for messages conforming to the IRC protocol including support for IRCv3.2 Message Tags

## Examples

##### Exmaple 1: 
Message without Message Tags.
```php
$msg = new IRCMessage(":test!test@test.my.irc.server JOIN #test");
$msg->phrase();
echo json_encode($msg,JSON_PRETTY_PRINT);
```
Output:
```json
{
    "ts": 1488459541399,
    "has_message_tags": false,
    "has_prefix": true,
    "message_tags": [],
    "prefix": {
        "nick": "test",
        "user": "test",
        "host": "test.my.irc.server"
    },
    "command": "JOIN",
    "params": [
        "#test"
    ],
    "raw": ":test!test@test.my.irc.server JOIN #test"
}
```

##### Exmaple 2:
Message with IRCv3.2 Message Tags.
```php
$msg = new IRCMessage("@display-name=TestUser;id=2362364236234634634;room-id=31462363463;sent-ts=1488375811149;admin=0;testp= :testuser!testuser@testuser.my.irc.server PRIVMSG #test :Hello! World");
$msg->phrase();
echo json_encode($msg,JSON_PRETTY_PRINT);
```
Output:
```json
{
    "ts": 1488460013762,
    "has_message_tags": true,
    "has_prefix": true,
    "message_tags": {
        "display-name": "TestUser",
        "id": "2362364236234634634",
        "room-id": "31462363463",
        "sent-ts": "1488375811149",
        "admin": "0",
        "testp": null
    },
    "prefix": {
        "nick": "testuser",
        "user": "testuser",
        "host": "testuser.my.irc.server"
    },
    "command": "PRIVMSG",
    "params": [
        "#test",
        "Hello! World"
    ],
    "raw": "@display-name=TestUser;id=2362364236234634634;room-id=31462363463;sent-ts=1488375811149;admin=0;testp= :testuser!testuser@testuser.my.irc.server PRIVMSG #test :Hello! World"
}
```
## Motivation

I could not find a parser for PHP with Message Tags support so I made one.

## Installation



## License

A short snippet describing the license (MIT, Apache, etc.)
