<?php
namespace Bookly\Backend\Modules\Debug\Lib\Tools;

use Bookly\Lib;

/**
 * Class Cloud
 * @package Bookly\Backend\Modules\Debug\Lib\Tools
 */
class Cloud extends Base
{
    protected $name = 'Cloud feedback';
    protected $type = 'tools';

    /**
     * @inheritDoc
     */
    public function getMenu()
    {
        return sprintf( '<a href="#" data-tool="%s" data-action="%s" class="dropdown-item">%s</a>', $this->tool, 'request_a_cloud', $this->name );
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $option = 'bookly_installation_time';
        if ( $this->data['action'] === 'request_a_cloud' ) {
            $cloud = Lib\Cloud\API::getInstance();
            $data = array(
                'feedback' => array(
                    'tool' => array(
                        'action' => 'get_data_from_bookly',
                        'tool' => 'Cloud',
                    ),
                ),
                'endpoint' => add_query_arg( array( 'action' => 'bookly_run_tool' ), admin_url( 'admin-ajax.php' ) ),
            );
            $response = $cloud->sendPostRequest( '/1.0/test/feedback-request', $data );

            $post = $get = false;
            if ( isset( $response['data'] ) ) {
                if ( isset( $response['data']['POST'][ $option ] ) && $response['data']['POST'][ $option ] == get_option( $option ) ) {
                    $post = true;
                }
                if ( isset( $response['data']['GET'][ $option ] ) && $response['data']['GET'][ $option ] == get_option( $option ) ) {
                    $get = true;
                }
                if ( $get && $post ) {
                    $this->addInfo( 'Connection between Bookly and Bookly Cloud is confirmed' );
                } elseif ( ! $get && ! $post ) {
                    $this->addError( 'Connection between Bookly and Bookly Cloud is failed' );
                } elseif ( $get ) {
                    $this->addError( 'GET and POST requests from Bookly Cloud: POST failed' );
                } elseif ( $post ) {
                    $this->addError( 'GET and POST requests from Bookly Cloud: GET failed' );
                }
                return $get && $post;
            } else {
                $this->addError( 'Bookly Cloud is failed' );
            }
        } elseif ( $this->data['action'] === 'get_data_from_bookly' ) {
            // Response for Cloud
            wp_send_json_success( array( $option => get_option( $option ) ) );
        }

        return false;
    }
}