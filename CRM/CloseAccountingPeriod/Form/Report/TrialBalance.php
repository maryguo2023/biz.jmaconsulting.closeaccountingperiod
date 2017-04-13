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
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2016
 * $Id$
 *
 */
class CRM_CloseAccountingPeriod_Form_Report_TrialBalance extends CRM_Report_Form {

  /**
   */
  public function __construct() {
    list($months, $years) = CRM_CloseAccountingPeriod_BAO_CloseAccountingPeriod::getDates();
    $this->_columns = array(
      'civicrm_financial_account' => array(
        'dao' => 'CRM_Financial_DAO_FinancialAccount',
        'fields' => array(
          'name' => array(
            'title' => ts('Account'),
            'required' => TRUE,
          ),
          'accounting_code' => array(
            'title' => ts('Accounting Code'),
            'required' => TRUE,
          ),
        ),
        'filters' => array(
          'contact_id' => array(
            'title' => ts('Organization Name'),
            'operatorType' => CRM_Report_Form::OP_SELECT,
            'options' => array('' => '- Select Organization -') + CRM_CloseAccountingPeriod_BAO_CloseAccountingPeriod::getOrganizationNames(),
            'type' => CRM_Utils_Type::T_INT,
          ),
        ),
      ),
      'civicrm_financial_trxn' => array(
        'dao' => 'CRM_Financial_DAO_FinancialTrxn',
        'fields' => array(
          'debit' => array(
            'title' => ts('Debit'),
            'required' => TRUE,
            'dbAlias' => 'SUM(debit)',
          ),
          'credit' => array(
            'title' => ts('Credit'),
            'required' => TRUE,
            'dbAlias' => 'SUM(credit)',
          ),
        ),
        'filters' => array(
          'trxn_date_month' => array(
            'title' => ts('Financial Period End Month'),
            'operatorType' => CRM_Report_Form::OP_SELECT,
            'options' => $months,
            'type' => CRM_Utils_Type::T_INT,
            'pseudofield' => TRUE,
            'default' => 0,
          ),
          'trxn_date_year' => array(
            'title' => ts('Financial Period End Year'),
            'operatorType' => CRM_Report_Form::OP_SELECT,
            'options' => $years,
            'type' => CRM_Utils_Type::T_INT,
            'pseudofield' => TRUE,
            'default' => 0,
          ),
        ),
      ),
    );
    parent::__construct();
  }

  public function preProcess() {
    parent::preProcess();
  }


  public function from() {
    $endDate = NULL;
    $contactID = $this->_params['contact_id_value'];
    if (!empty($this->_params['trxn_date_month_value']) && !empty($this->_params['trxn_date_year_value'])) {
      $endDate = date('Y-m-t', mktime(0, 0, 0, $this->_params['trxn_date_month_value'], 1, $this->_params['trxn_date_year_value']));
    }
    $this->_from = CRM_CloseAccountingPeriod_BAO_CloseAccountingPeriod::getTrialBalanceQuery($this->_aliases, TRUE, $contactID, $endDate);
  }

  public function orderBy() {
    $this->_orderBy = " ORDER BY {$this->_aliases['civicrm_financial_account']}.name ";
  }

 /**
   * Set limit.
   *
   * @param int $rowCount
   *
   * @return array
   */
  public function limit($rowCount = self::ROW_COUNT_LIMIT) {
    $this->_limit = NULL;
  }

  /**
   * Post process function.
   */
  public function postProcess() {
    parent::postProcess();
  }

  public function groupBy() {
    $this->_groupBy = " GROUP BY {$this->_aliases['civicrm_financial_account']}.id ";
  }

  /**
   * Alter display of rows.
   *
   * Iterate through the rows retrieved via SQL and make changes for display purposes,
   * such as rendering contacts as links.
   *
   * @param array $rows
   *   Rows generated by SQL, with an array for each row.
   */
  public function alterDisplay(&$rows) {
    if (empty($rows)) {
      return NULL;
    }
    $creditAmount = $debitAmount = 0;
    foreach ($rows as &$row) {
      $creditAmount += $row['civicrm_financial_trxn_credit'];
      $debitAmount += $row['civicrm_financial_trxn_debit'];
      $row['civicrm_financial_trxn_credit'] = CRM_Utils_Money::format($row['civicrm_financial_trxn_credit']);
      $row['civicrm_financial_trxn_debit'] = CRM_Utils_Money::format($row['civicrm_financial_trxn_debit']);    
    }
    $rows[] = array(
      'civicrm_financial_account_accounting_code' => ts('<b>Total Amount</b>'),
      'civicrm_financial_trxn_debit' => '<b>' . CRM_Utils_Money::format($debitAmount) . '</b>',
      'civicrm_financial_trxn_credit' => '<b>' . CRM_Utils_Money::format($creditAmount) . '</b>',
    );
  }

  /**
   * Filter statistics.
   *
   * @param array $statistics
   */
  public function filterStat(&$statistics) {
    parent::filterStat($statistics);
    $statisticsPriorPeriodDate = CRM_Core_Session::singleton()->get('statisticsPriorPeriodDate');
    if ($statisticsPriorPeriodDate) {
      $statistics['filters'][] = array(
        'title' => ts('Trial Balance report for the period'),
        'value' => $statisticsPriorPeriodDate,
      );
    }
  }

}
