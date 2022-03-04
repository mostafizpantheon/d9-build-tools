<?php

$query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();

$or = $query->orConditionGroup();
$or->condition('type', 'mvse_exclusion');
$or->condition('type', 'mvse_breach');
$query->condition($or);
$results = $query->execute();

$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($results);

foreach ($nodes as $node) {
  $patron = $node->get('field_mvse_patron')->entity;
  if (empty($patron)) {
    $this->output()->writeln('Archiving ' . $node->id());
    $node->set('field_mvse_archived', 1);
    $node->save();
  }
  else {
    if ($patron->get('field_mvse_archived')->value == '1') {
      $node->set('field_mvse_archived', 1);
      $node->save();
    }
  }
}
