<?php

namespace Be\App\Tool;


class Property extends \Be\App\Property
{

    protected string $label = '工具';
    protected string $icon = 'bi-tools';
    protected string $description = '开发人员工具';

    public function __construct() {
        parent::__construct(__FILE__);
    }

}
