<?php
namespace Bookly\Backend\Modules\Debug\Lib\Tools;

use Bookly\Lib\Session;

/**
 * Class FormsData
 *
 * @package Bookly\Backend\Modules\Debug\Lib\Tools
 */
class FormsData extends Base
{
    protected $name = 'Forms data';
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
        switch ( $this->data['action'] ) {
            case 'render':
                $li = '';
                $all_forms_data = Session::getAllFormsData();
                $last_touched_form_id = 0;
                $last_touched = 0;
                foreach ( $all_forms_data as $form_id => $data ) {
                    if ( isset( $data['last_touched'] ) && $last_touched < $data['last_touched'] ) {
                        $last_touched = $data['last_touched'];
                        $last_touched_form_id = $form_id;
                    }
                }

                foreach ( $all_forms_data as $form_id => $data ) {
                    $active = $last_touched_form_id == $form_id ? 'list-group-item-primary' : '';
                    $li .= sprintf( '<li class="list-group-item list-group-item-action %1$s py-1 text-monospace" data-form_id="%2$s">%2$s<button class="btn btn-sm ml-2 p-0 my-0" data-action="copy"><i class="far fa-copy fa-fw"></i></button><div class="float-right"><button class="btn btn-sm p-0 m-0" data-action="destroy"><i class="fas fa-times fa-fw"></i></button></span></li>', $active, esc_attr( $form_id ) );
                }
                if ( $li == '' ) {
                    $li = 'Data for [booking-form] is missing in the session';
                }
                $this->result = '<ul class="list-group" id="bookly-js-booking-forms">' . $li . '</ul>';
                break;
            case 'get_data':
                $form_id = $this->data['form_id'];
                $data = Session::getAllFormsData();
                if ( array_key_exists( $form_id, $data ) ) {
                    $this->result = json_encode( $data[ $form_id ] );
                }
                break;
            case 'destroy':
                $form_id = $this->data['form_id'];
                Session::destroyFormData( $form_id );
        }

        return true;
    }

}