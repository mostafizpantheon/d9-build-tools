<?php

$query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
$results = $query
  ->condition('type', 'mvse_patron')
  ->execute();

$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($results);

$patronService = \Drupal::service('mvse_patron.patron_service');
foreach ($nodes as $node) {
  $pid = $patronService->addPatronPassword($node);
  if (empty($pid) || $pid == FALSE) {
    $this->output()->writeln('Could not add password for ' . $node->id());
  }
}

