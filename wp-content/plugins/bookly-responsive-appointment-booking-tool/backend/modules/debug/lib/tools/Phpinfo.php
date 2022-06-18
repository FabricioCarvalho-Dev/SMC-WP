<?php
namespace Bookly\Backend\Modules\Debug\Lib\Tools;

/**
 * Class Phpinfo
 * @package Bookly\Backend\Modules\Debug\Lib\Tools
 */
class Phpinfo extends Base
{
    protected $name = 'Php info';
    protected $type = 'tools';

    /**
     * @inheritDoc
     */
    public function getMenu()
    {
        return sprintf( '<a href="#" data-tool="%s" data-action="%s" class="dropdown-item">%s</a>', $this->tool, 'php_info', $this->name );
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        ob_start();
        phpinfo();
        $info = ob_get_clean();

        $this->result = $info;
        return true;
    }

}