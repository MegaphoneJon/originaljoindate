<?php

require_once 'originaljoindate.civix.php';
//If the Original Join Date is empty, set it with the join date when creating a membership.
function originaljoindate_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if($op == 'create' && $objectName == 'Membership'){
    //look up "Original Join Date" to see if it's empty
    $params = array(
      'version' => 3,
      'sequential' => 1,
      'return' => 'custom_79',
      'id' => $objectRef->contact_id,
    );
    $result = civicrm_api('Contact', 'getvalue', $params);

    //if no result, set the value with this object's join date.
    if(!$result){
      unset($params);
      $params = array(
        'version' => 3,
        'sequential' => 1,
        'custom_79' => $objectRef->join_date,
        'id' => $objectRef->contact_id,
      );
      $result = civicrm_api('Contact', 'create', $params);
    }
  }
}

