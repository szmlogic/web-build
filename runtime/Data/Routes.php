<?php
return array(
':l/Tags/:model/:tag/:p' => 'Home/Tags/index',
':l/Tags/:tag/:p' => 'Home/Tags/index',
':l/Tags/:model/:tag' => 'Home/Tags/index',
':l/Tags/:p\d' => 'Home/Tags/index',
':l/Tags/:tag' => 'Home/Tags/index',
':l/Tags' => 'Home/Tags/index',
'Tags/:model/:tag/:p' => 'Home/Tags/index',
'Tags/:tag/:p' => 'Home/Tags/index',
'Tags/:model/:tag' => 'Home/Tags/index',
'Tags/:p\d' => 'Home/Tags/index',
'Tags/:tag' => 'Home/Tags/index',
'Tags' => 'Home/Tags/index',
'/^([\w^_]+)\/-(\d+)-(\d+)-(\d+)$/' => 'Urlrule/detail?catdir=:1&catid=:2&id=:3&p=:4&',
'/^([\w^_]+)\/(\d+)-(\d+)$/' => 'Urlrule/detail?catdir=:1&catid=:2&id=:3&',
'/^([\w^_]+)-(\d+)-(\d+)$/' => 'Urlrule/index?catdir=:1&catid=:2&p=:3&',
'/^([\w^_]+)$/' => 'Urlrule/index?catdir=:1&'
);
?>