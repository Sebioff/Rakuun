<?php

$groupsContainer = $self->getContainerGroupsTableName();

$queries[] = 'ALTER TABLE `'.$groupsContainer.'`
  ADD `alliance` smallint(5) unsigned DEFAULT NULL,
  ADD KEY `alliance` (`alliance`),
  ADD CONSTRAINT `'.$groupsContainer.'_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

?>