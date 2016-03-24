<?php
/**
 * Class for CiviRule Condition LastLineItem
 *
 * @author Aidan Saunders <aidan.saunders@squiffle.uk>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_CivirulesConditions_Contribution_LastLineItem extends CRM_Civirules_Condition {

  /**
   * Method is mandatory and checks if the condition is met
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return bool
   * @access public
   */
  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData)
  {
    $lineItem = $triggerData->getEntityData('LineItem');

    // TRUE if the total of all lineitems for this contribution matches the contribution amount
    $allLineItems = civicrm_api3('LineItem', 'get', array('contribution_id' => $lineItem['contribution_id']));
    $liTotal = 0;
    foreach ($allLineItems['values'] as $li) {
        $liTotal += (float) $li['line_total'];
    }
    $contribution = civicrm_api3('Contribution', 'Getsingle', array('contribution_id' => $lineItem['contribution_id']));
    if (round((float) $contribution['total_amount'], 2) == round($liTotal, 2)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Method is mandatory, in this case no additional data input is required
   * so it returns FALSE
   *
   * @param int $ruleConditionId
   * @return bool
   * @access public
   */
  public function getExtraDataInputUrl($ruleConditionId) {
    return FALSE;
  }

  /**
   * Returns an array with required entity names
   *
   * @return array
   * @access public
   */
  public function requiredEntities() {
    return array('LineItem');
  }
}
