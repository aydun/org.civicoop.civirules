<?php

class CRM_CivirulesPostTrigger_LineItem extends CRM_Civirules_Trigger_Post {

  /**
   * LineItem has no contact_id, so get it from the contribution and
   * add contribution for later use
   */
  public function alterTriggerData(CRM_Civirules_TriggerData_TriggerData &$triggerData) {
    $lineItem = $triggerData->getEntityData('LineItem');
    $contribution = civicrm_api3('Contribution', 'getsingle', array('id' => $lineItem['contribution_id']));
    $triggerData->setEntityData('Contribution', $contribution);
    $triggerData->setContactId( $contribution['contact_id'] );
  }
}
