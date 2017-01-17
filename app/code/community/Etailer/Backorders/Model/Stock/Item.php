<?php

class Etailer_Backorders_Model_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item
{
    /**
     * Check quantity
     *
     * @param   decimal $qty
     * @exception Mage_Core_Exception
     * @return  bool
     */
    public function checkQty($qty)
    {
        if (!$this->getManageStock() || Mage::app()->getStore()->isAdmin()) {
            return true;
        }

		// Allow new bottom of $this->getMinQty() for backorder products only, normal freeze at 0
        if ($this->getBackorders()) {
			if ($this->getQty() - $this->getMinQty() - $qty < 0) {
				return false;
			}
		} else {
			if ($this->getQty() - $qty < 0) {
				return false;
			}	
		}
        return true;
    }
    
     /**
     * Check if item should be in stock or out of stock based on $qty param of existing item qty
     *
     * @param float|null $qty
     * @return bool true - item in stock | false - item out of stock
     */
    public function verifyStock($qty = null)
    {
        if ($qty === null) {
            $qty = $this->getQty();
        }
       // Allow new bottom of $this->getMinQty() for backorder products only, normal freeze at 0
        if ($this->getBackorders()) {
			if ($qty <= $this->getMinQty()) {
				return false;
			}
		} else {
			if ($qty <= 0) {
				return false;
			}
		}
        return true;
    }

}
