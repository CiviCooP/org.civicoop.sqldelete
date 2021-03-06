<?php

require_once 'sqlgroupdelete.civix.php';

function sqlgroupdelete_civicrm_pre($op, $objectName, $id, &$params) {
  // delete the saved search
  if ($op == 'delete' && $objectName == 'Group') {
    // get the saved search id of this group
    $sql = "select saved_search_id from civicrm_group where id = %1";
    $sqlParams = array(
      1 => array($id, 'Integer'),
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
  }
}

function sqlgroupdelete_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($op == 'delete' && $objectName == 'Group') {
    // call our api to make sure everything of the group is deleted
    $params = array(
      'group_id' => $objectId,
    );
    civicrm_api3('group', 'sqldelete', $params);

    CRM_Core_Session::setStatus('Groep opgeschoond.', ts('Warning'), 'warning');
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function sqlgroupdelete_civicrm_config(&$config) {
  _sqlgroupdelete_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function sqlgroupdelete_civicrm_xmlMenu(&$files) {
  _sqlgroupdelete_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function sqlgroupdelete_civicrm_install() {
  _sqlgroupdelete_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function sqlgroupdelete_civicrm_uninstall() {
  _sqlgroupdelete_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function sqlgroupdelete_civicrm_enable() {
  _sqlgroupdelete_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function sqlgroupdelete_civicrm_disable() {
  _sqlgroupdelete_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function sqlgroupdelete_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _sqlgroupdelete_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function sqlgroupdelete_civicrm_managed(&$entities) {
  _sqlgroupdelete_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function sqlgroupdelete_civicrm_caseTypes(&$caseTypes) {
  _sqlgroupdelete_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function sqlgroupdelete_civicrm_angularModules(&$angularModules) {
_sqlgroupdelete_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function sqlgroupdelete_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _sqlgroupdelete_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function sqlgroupdelete_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function sqlgroupdelete_civicrm_navigationMenu(&$menu) {
  _sqlgroupdelete_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'org.civicoop.sqlgroupdelete')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _sqlgroupdelete_civix_navigationMenu($menu);
} // */
