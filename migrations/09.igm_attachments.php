<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `messages_attachments` (
  `message` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  KEY `message` (`board`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `messages_attachments`
  ADD CONSTRAINT `messages_attachments_ibfk_1` FOREIGN KEY (`message`) REFERENCES `messages` (`id`) ON DELETE CASCADE;';

?>