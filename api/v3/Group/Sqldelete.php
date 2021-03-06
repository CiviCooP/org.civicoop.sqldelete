<?php

/**
 * Group.sqldelete API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_group_sqldelete_spec(&$spec) {
  $spec['group_id']['api.required'] = 1;
}

/**
 * Group.sqldelete API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_group_sqldelete($params) {
  try {
    // check if param group_id is specified
    if (!array_key_exists('group_id', $params)) {
      throw new Exception('group_id is a required parameter. Can be a single id or a comma separated list of id\'s.');
    }

    $returnValues = '';
    $i = 0;

    // get the id's
    $groupIDs = explode(',', $params['group_id']);

    foreach ($groupIDs as $g) {
      // check if it's an integer
      $groupID = trim($g);
      if (!is_numeric($groupID)) {
        // skip record
        $returnValues .= "skipped group $g: not an integer, ";
        continue;
      }

      // delete the group
      _delete_group_by_id($groupID);
      $i++;
    }

    $returnValues .= "$i group(s) deleted.";
    return civicrm_api3_create_success(array($returnValues), $params, NULL, NULL);
  }
  catch (Exception $e) {
    throw new API_Exception($e->getMessage(), 999);
  }
}

function _delete_group_by_id($groupID) {
  // get the saved search id of this group (the code below is duplicated in the pre hook because when
  // a group is deleted using the interface, the group is already gone by the time we are here)
  $sql = "select saved_search_id from civicrm_group where id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  $savedSearchID = CRM_Core_DAO::singleValueQuery($sql, $sqlParams);

  // delete saved search (if available)
  if ($savedSearchID) {
    $sql = "delete from civicrm_saved_search where id = %1";
    $sqlParams = array(
      1 => array($savedSearchID, 'Integer'),
    );
    CRM_Core_DAO::executeQuery($sql, $sqlParams);
  }

  // delete the group contacts
  $sql = "delete from civicrm_group_contact where group_id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  CRM_Core_DAO::executeQuery($sql, $sqlParams);

  // delete the group contact cache
  $sql = "delete from civicrm_group_contact_cache where group_id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  CRM_Core_DAO::executeQuery($sql, $sqlParams);

  // delete the group organization
  $sql = "delete from civicrm_group_organization where group_id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  CRM_Core_DAO::executeQuery($sql, $sqlParams);

  // delete the subscription history
  $sql = "delete from civicrm_subscription_history where group_id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  CRM_Core_DAO::executeQuery($sql, $sqlParams);

  // last but not least, delete the group
  $sql = "delete from civicrm_group where id = %1";
  $sqlParams = array(
    1 => array($groupID, 'Integer'),
  );
  CRM_Core_DAO::executeQuery($sql, $sqlParams);
}

