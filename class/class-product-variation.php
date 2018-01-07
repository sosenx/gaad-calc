<?php 
namespace gcalc;

class product_variation extends \WC_Product_Variation{


	 /**
     * Save data (either create or update depending on if we are working on an existing product).
     *
     * @since 3.0.0
     */
    public function save() {
        $this->validate_props();

        if ( $this->data_store ) {
            // Trigger action before saving to the DB. Use a pointer to adjust object props before save.
            do_action( 'woocommerce_before_' . $this->object_type . '_object_save', $this, $this->data_store );

            if ( $this->get_id() ) {
                $this->data_store->update( $this );
            } else {
                $this->data_store->create( $this );
            }
            if ( $this->get_parent_id() ) {
                wp_schedule_single_event( time(), 'woocommerce_deferred_product_sync', array( 'product_id' => $this->get_parent_id() ) );
            }
            return $this->get_id();
        }
    }


}

 ?>