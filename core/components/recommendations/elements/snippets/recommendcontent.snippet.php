<?php
/**
 * RecommendContent snippet for recommendations extra
 *
 * Copyright 2016 by Danny Harding <http://stuntrocket.co>
 * Created on 02-22-2016
 *
 * recommendations is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * recommendations is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * recommendations; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package recommendations
 */

/**
 * Description
 * -----------
 * Description for RecommendContent
 *
 * Variables
 * ---------
 * @var $modx modX
 * @var $scriptProperties array
 *
 * @package recommendations
 **/
$output = "";
$row_output = "";

$data = array();
$used_ids = array();
$user_data = $profile_data = $extended_data = false;

$limit = $modx->getOption('limit', $scriptProperties, 2);
$related = $modx->getOption('related', $scriptProperties, false);
$tags = $modx->getOption('tags', $scriptProperties, false);
$expertise = $modx->getOption('expertise', $scriptProperties, "basic");
$sector = $modx->getOption('sector', $scriptProperties, false);
$profession = $modx->getOption('profession', $scriptProperties, false);
$engagement = $modx->getOption('engagement', $scriptProperties, 0);
$template_outer = $modx->getOption('tpl_outer', $scriptProperties, "RecommendedContentOuterTpl");
$template_row_main = $modx->getOption('tpl_row', $scriptProperties, "RecommendedContentRowTpl");
$template_row = $modx->getOption('tpl_row', $scriptProperties, "RecommendedContentRowTpl");
$notallowed = $modx->getOption('notallowed', $scriptProperties, "29,18,32,22,35,60,28,42,63,43,61,62,81,2");


// Does the currently viewed resource have any CMS recommended resources?
if(!empty($related)) {
  $related = explode(",", $related);
  if(!empty($related) && !empty($related[0])) {
    
    foreach($related as $rel) {
      $used_ids[] = $rel;
      /* 
      $document = $modx->getObject('modResource', $rel);
  
      if(!empty($document)) {
        $document_data = $document->toArray();
        $document_data['type'] = 'Next';
        $document_data['theme'] = 'article';
        $row_output .= $modx->getChunk($template_row_main, $document_data);
      }
      */
    }    
  }
} 



$id = $modx->resource->get('id');


/* 
// Do we have a logged in user?
$user_id = $modx->user->get('id');
if(!empty($user_id)) {
  
  $user = $modx->user;
  if(!empty($user)) {
    
    $user_data = $user->toArray();
    
    $profile = $user->getOne('Profile');    
    
    if(!empty($profile)) {
      $profile_data = $profile->toArray();
   
      $extended = $profile->get('extended');
      if(!empty($profile_data) && !empty($profile_data['extended'])) {
        $extended_data = $profile_data['extended'];
        
        if(empty($tags) && !empty($extended_data['tags'])) {
          $tags = $extended_data['tags'];
        }
        
        if(empty($sector) && isset($extended_data['custom_field']) && !empty($extended_data['custom_field'])) {
          $sector = $extended_data['custom_field'];
        }
        
        if(empty($profession) && isset($extended_data['custom_field2']) && !empty($extended_data['custom_field2'])) {
          $profession = $extended_data['custom_field2'];
        }
        
      }  
      
    }
      
  } else {
    // Error getting user object - possibly an admin user?
    // !TODO - log this. 
  }
  
}
*/







if(!$parent)  { $parent = $modx->resource->get('parent'); }
if(!$exclude) { $exclude = $modx->resource->get('id'); }

$children = $modx->getChildIds($parent, 1);
$key = array_search($exclude, $children);
$next_id = $children[$key + 1];

// Don't allow these...
$not_allowed = explode(",", $notallowed);
if(in_array($next_id, $not_allowed)) {
  $next_id = false;
}

if(!empty($next_id)) {
  $used_ids[] = $next_id;
}



if($used_ids < $limit) {
  
  // if(!$parent)  { $parent = $modx->resource->get('parent'); }
  // if(!$exclude) { $exclude = $modx->resource->get('id'); }
  
  $children = $modx->getChildIds($parent, 2);
  $key = array_search($exclude, $children);
  $next_id = $children[$key + 1];
  
  // Don't allow these...
  $not_allowed = explode(",", $notallowed);
  if(in_array($next_id, $not_allowed)) {
    $next_id = false;
  }
  
  if(!empty($next_id)) {
    $used_ids[] = $next_id;
  }
  
}






$mytotal = count($used_ids); 
if($mytotal > 0) {
  $c = 0;
  foreach($used_ids as $rid) {

    if($c == $limit) {
      break;
    }

    $document = $modx->getObject('modResource', $rid);
  
    if(!empty($document)) {
      $banner_image = $document->getTVValue('BannerImage');
      $thumbnail_image = $document->getTVValue('ResourceIcon');

      $document_data = $document->toArray();
      $document_data['type'] = 'Next';
      $document_data['theme'] = 'article';
      $document_data['BannerImage'] = $banner_image;
      $document_data['ResourceIcon'] = $thumbnail_image;
      $row_output .= $modx->getChunk($template_row_main, $document_data);
    }

    $c++;
  }
}


if(empty($used_ids) || count($used_ids) < 1) { return "<!-- No Recommendations Were Found. -->"; }


// SLOT 3
/* 
$row_data = array();
$row_data['type'] = 'Popular';
$row_data['theme'] = 'event';
$row_output .= $modx->getChunk($template_row, $row_data);
*/


$data['rows'] = $row_output;



$output .= $modx->getChunk($template_outer, $data);

$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, '' );

if(!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

return $output;