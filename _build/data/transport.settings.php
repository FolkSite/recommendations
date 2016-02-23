<?php
/**
 * systemSettings transport file for recommendations extra
 *
 * Copyright 2016 by Danny Harding <http://stuntrocket.co>
 * Created on 02-22-2016
 *
 * @package recommendations
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'recommendations.core_path',
  'value' => '/home/www/assets/mycomponents/recommendations/core/components/recommendations/',
  'xtype' => 'textfield',
  'namespace' => 'recommendations',
  'area' => 'recommendations',
  'name' => 'recommendations.core_path',
  'description' => 'Description for recommendations.core_path',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'resourcealert.assets_url',
  'value' => '/home/www/assets/mycomponents/recommendations/assets/components/recommendations/',
  'xtype' => 'textfield',
  'namespace' => 'recommendations',
  'area' => 'recommendations',
  'name' => 'resourcealert.assets_url',
  'description' => 'Description for resourcealert.assets_url',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'resourcealert.assets_fronturl',
  'value' => '/assets/mycomponents/recommendations/assets/components/recommendations/',
  'xtype' => 'textfield',
  'namespace' => 'recommendations',
  'area' => 'recommendations',
  'name' => 'resourcealert.assets_fronturl',
  'description' => 'Description for resourcealert.assets_fronturl',
), '', true, true);
return $systemSettings;
