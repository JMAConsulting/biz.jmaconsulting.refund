<?php
define('EXT_NAME', basename(__DIR__));

require_once 'refund.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function refund_civicrm_config(&$config) {
  _refund_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function refund_civicrm_xmlMenu(&$files) {
  _refund_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function refund_civicrm_install() {
  _refund_civix_civicrm_install();
  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, CRM_Core_Config::singleton()->extensionsDir . EXT_NAME . '/sql/refund_install.sql');
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function refund_civicrm_uninstall() {
  _refund_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function refund_civicrm_enable() {
  _refund_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function refund_civicrm_disable() {
  _refund_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function refund_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _refund_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function refund_civicrm_managed(&$entities) {
  _refund_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function refund_civicrm_caseTypes(&$caseTypes) {
  _refund_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function refund_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _refund_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * @param string $formName
 * @param array $fields
 * @param array $files
 * @param CRM_Core_Form $form
 * @param array $errors
 */
function refund_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if ($formName == 'CRM_Contribute_Form_Contribution' && CRM_Utils_Array::value('_qf_Contribution_upload_revert', $fields)) {
    if (CRM_Contribute_BAO_Contribution::checkAccountsPayable($form->_id, TRUE)) {
      $errors['refund_amount'] = ts('No Accounts Payable account has been configured for a financial type used in this contribution. Please add it at Administer > CiviContribute > Financial Types, Accounts link. Or change the financial type to one that has this relation defined.');
    }
    return $errors;
  }
}

function refund_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_Contribution') {
    $contributionStatuses = CRM_Contribute_PseudoConstant::contributionStatus(NULL, 'name');
    $pendingRefundStatus = array_search('Pending refund', $contributionStatuses);
    $partialRefundStatus = array_search('Partially refunded', $contributionStatuses);
    if (($form->_action & CRM_Core_Action::REVERT) && $pendingRefundStatus == $form->_values['contribution_status_id']) {
      $ft = CRM_Core_BAO_FinancialTrxn::getFinancialTrxnId($form->_id, 'DESC', FALSE, " AND cft.status_id = {$pendingRefundStatus}");
      if ($ft['amount'] < $form->_values['total_amount']) {
        CRM_Core_DAO::setFieldValue('CRM_Contribute_DAO_Contribution', $form->_id, 'contribution_status_id', $partialRefundStatus);
        $amount = $form->_values['total_amount'] - $ft['amount'];
        CRM_Core_DAO::setFieldValue('CRM_Contribute_DAO_Contribution', $form->_id, 'total_amount', $amount);
      }
    }
  }
}