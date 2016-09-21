<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Refund_Form_Report_CreditCard',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'Credit Card Reconciliation Report',
      'description' => 'Credit Card Reconciliation Report',
      'class_name' => 'CRM_Refund_Form_Report_CreditCard',
      'report_url' => 'creditcard',
      'component' => 'CiviContribute',
    ),
  ),
);