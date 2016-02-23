<?php
$criteria = array();
// $criteria['parent'] = (int) $parent;
$criteria['deleted'] = '0';
$criteria['published'] = '1';
$criteria['hidemenu'] = '0';
 
$query = $modx->newQuery('modResource', $criteria);
// id's that should not be included on root level
// $query->where(array('id:NOT IN' => array(186,26,119)));
$reso = $modx->getCollection('modResource', $query);

// $parent = $modx->getOption('parent',$scriptProperties,1);
// $parentObj = $modx->getObject('modResource',$parent);

// if (!($parentObj instanceof modResource)) { return ''; }

// $resArray = $parentObj->getMany('Children');
// $resources = array();
foreach($reso as $res) {
  if ($res instanceof modResource) {
    $resources[] = $res->get('pagetitle') . '==' . $res->get('id');
  }
}

$out = implode("||",$resources);
return $out;