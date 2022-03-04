<?php

$query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
$results = $query
  ->condition('type', 'mvse_venue')
  ->execute();

$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($results);

foreach ($nodes as $node) {
  $this->output()->writeln('Updating: ' . $node->getTitle());

  $exclusions = [
    ['value' => 'entire_venue'],
    ['value' => 'total_gambling_ban'],
    ['value' => 'gaming_area'],
  ];
  $node->set('field_mvse_exclusion_types', $exclusions);

  $exclusionsNt = [
    ['value' => 'tab_only'],
    ['value' => 'keno_only'],
    ['value' => 'gaming_machine_only'],
    ['value' => 'table_game_only'],
  ];
  $node->set('field_mvse_exclusion_types_nt', $exclusionsNt);
  $node->save();
}

