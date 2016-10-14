ALTER TABLE `civicrm_financial_trxn` ADD `credit_card_number` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Last 4 digits of credit card.' AFTER check_number;
ALTER TABLE `civicrm_financial_trxn` ADD `credit_card_type` INT( 10 ) UNSIGNED NULL DEFAULT NULL COMMENT 'FK to accept_creditcard option group values';
