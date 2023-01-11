<?php

namespace Be\App\Tool\Controller\Admin;

use Be\App\System\Controller\Admin\Auth;
use Be\Be;

/**
 * @BePermissionGroup("菜单")
 */
class Menu extends Auth
{

    /**
     * 指定项目下的项目文档管理
     *
     * @BeMenu("菜单", icon="bi-Tools", ordering="1.1")
     * @BePermission("管理", ordering="1.1")
     */
    public function manager()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $response->set('title', '菜单管理');
        $response->display();
    }

    /**
     * 初始化工具菜单
     *
     * @BePermission("初始化", ordering="1.2")
     */
    public function init()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();
        try {
            $service = Be::getService('App.Tool.Admin.Menu');
            $service->init();
            $response->set('success', true);
            $response->set('message', '初始化工具菜单成功！');
            $response->json();
        } catch (\Throwable $t) {
            $response->set('success', false);
            $response->set('message', $t->getMessage());
            $response->json();
        }
    }

    /**
     * 删除工具菜单
     *
     * @BePermission("删除", ordering="1.3")
     */
    public function delete()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();
        try {
            $service = Be::getService('App.Tool.Admin.Menu');
            $service->delete();
            $response->set('success', true);
            $response->set('message', '删除工具菜单成功！');
            $response->json();
        } catch (\Throwable $t) {
            $response->set('success', false);
            $response->set('message', $t->getMessage());
            $response->json();
        }
    }

}
