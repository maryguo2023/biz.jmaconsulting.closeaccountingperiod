<?php
/*
+--------------------------------------------------------------------+
| Close Accounting Period Extension                                  |
+--------------------------------------------------------------------+
| Copyright (C) 2016-2017 JMA Consulting                             |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2016
 *
 * Generated from xml/schema/CRM/Financial/FinancialAccountBalance.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:d8a177b6c824223db3342f42f034de84)
 */
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Financial_DAO_FinancialAccountBalance extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   */
  static $_tableName = 'civicrm_financial_accounts_balance';
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   */
  static $_log = true;
  /**
   *
   * @var int unsigned
   */
  public $id;
  /**
   * FK to civicrm_financial_account
   *
   * @var int unsigned
   */
  public $financial_account_id;
  /**
   * Contains the opening balance for this financial account
   *
   * @var float
   */
  public $opening_balance;
  /**
   * Contains the opening balance for the current period for this financial account
   *
   * @var float
   */
  public $current_period_opening_balance;
  /**
   * class constructor
   *
   * @return civicrm_financial_accounts_balance
   */
  function __construct() {
    $this->__table = 'civicrm_financial_accounts_balance';
    parent::__construct();
  }
  /**
   * Returns foreign keys and entity references
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName() , 'financial_account_id', 'civicrm_financial_account', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }
  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Financial Account Balance ID') ,
          'required' => true,
        ) ,
        'financial_account_id' => array(
          'name' => 'financial_account_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Financial Account ID') ,
          'description' => 'FK to civicrm_financial_account',
          'required' => true,
          'FKClassName' => 'CRM_Financial_DAO_FinancialAccount',
          'html' => array(
            'type' => 'Select',
          ) ,
          'pseudoconstant' => array(
            'table' => 'civicrm_financial_account',
            'keyColumn' => 'id',
            'labelColumn' => 'name',
          )
        ) ,
        'opening_balance' => array(
          'name' => 'opening_balance',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => ts('Opening Balance') ,
          'description' => 'Contains the opening balance for this financial account',
          'required' => true,
          'precision' => array(
            20,
            2
          ) ,
          'default' => '0.00',
        ) ,
        'current_period_opening_balance' => array(
          'name' => 'current_period_opening_balance',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => ts('Current Period Opening Balance') ,
          'description' => 'Contains the opening balance for the current period for this financial account',
          'required' => true,
          'precision' => array(
            20,
            2
          ) ,
          'default' => '0.00',
        ) ,
      );
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }
  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }
  /**
   * Returns the names of this table
   *
   * @return string
   */
  static function getTableName() {
    return self::$_tableName;
  }
  /**
   * Returns if this table needs to be logged
   *
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }
  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &import($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'financial_accounts_balance', $prefix, array());
    return $r;
  }
  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &export($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'financial_accounts_balance', $prefix, array());
    return $r;
  }
}
