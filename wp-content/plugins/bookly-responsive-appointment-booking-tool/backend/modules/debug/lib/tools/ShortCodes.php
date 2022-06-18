<?php
namespace Bookly\Backend\Modules\Debug\Lib\Tools;

/**
 * Class ShortCodes
 * @package Bookly\Backend\Modules\Debug\Lib\Tools
 */
class ShortCodes extends Base
{
    protected $name = 'Shortcodes';
    protected $type = 'tools';

    /**
     * @inheritDoc
     */
    public function getMenu()
    {
        return sprintf( '<a href="#" data-tool="%s" data-action="%s" class="dropdown-item">%s</a>', $this->tool, 'render', $this->name );
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        global $wpdb;

        switch ( $this->data['action'] ) {
            case 'render':
                $shortcodes = array(
                    array( 'name' => 'Booking form', 'code' => '[bookly-form' ),
                    array( 'name' => 'Appointments list', 'code' => '[bookly-appointments-list' ),
                    array( 'name' => 'Calendar', 'code' => '[bookly-calendar' ),
                    array( 'name' => 'Cancellation confirmation', 'code' => '[bookly-cancellation-confirmation' ),
                    array( 'name' => 'Customer Cabinet', 'code' => '[bookly-customer-cabinet' ),
                    array( 'name' => 'Packages list', 'code' => '[bookly-packages-list' ),
                    array( 'name' => 'Search form', 'code' => '[bookly-search-form' ),
                    array( 'name' => 'Staff Cabinet - Advanced', 'code' => '[bookly-staff-advanced' ),
                    array( 'name' => 'Staff Cabinet - Calendar', 'code' => '[bookly-staff-calendar' ),
                    array( 'name' => 'Staff Cabinet - Days off', 'code' => '[bookly-staff-days-off' ),
                    array( 'name' => 'Staff Cabinet - Details', 'code' => '[bookly-staff-details' ),
                    array( 'name' => 'Staff Cabinet - Schedule', 'code' => '[bookly-staff-schedule' ),
                    array( 'name' => 'Staff Cabinet - Services', 'code' => '[bookly-staff-services' ),
                    array( 'name' => 'Staff Cabinet - Special days', 'code' => '[bookly-staff-special-days' ),
                    array( 'name' => 'Staff ratings', 'code' => '[bookly-staff-rating' ),
                );

                $options = '';
                foreach ( $shortcodes as $item ) {
                    $options .= '<option value="' . esc_attr( $item['code'] ) . '">' . esc_html( $item['name'] ) . '</option>';
                }
                $this->result = '<div class="input-group">
                    <select id="bookly_shortcode" class="form-control custom-select">' . $options . '</select>
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary ladda-button" id="bookly-js-find-shortcode-and-open" data-spinner-size="40" data-style="zoom-in" data-spinner-color="rgb(62, 66, 74)"><span class="ladda-label"><i class="fas fa-external-link-alt fa-sm"></i></span></button>
                    </div>
                    </div><small class="form-text text-muted mt-0">Open page with shortcode</small>';
                break;
            case 'find_shortcode':
                $row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->posts . ' WHERE post_content LIKE \'%%%s%\' AND post_type IN (\'page\',\'post\') AND post_status = \'publish\' ORDER BY ID DESC LIMIT 1', $this->data['shortcode'] ) );
                if ( $row ) {
                    $this->result = get_permalink( $row );
                } else {
                    $this->addInfo( 'Shortcode not found' );

                    return false;
                }
        }

        return true;
    }

}