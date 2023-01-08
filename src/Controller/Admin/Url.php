<?php

namespace Be\App\Tool\Controller\Admin;

use Be\App\System\Controller\Admin\Auth;
use Be\Be;

/**
 * @BePermissionGroup("网址")
 */
class Url extends Auth
{

    /**
     * 指定项目下的项目文档管理
     *
     * @BeMenu("网址", icon="bi-Tool-heart", ordering="2.1")
     * @BePermission("网址管理", ordering="2.1")
     */
    public function manager()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $serviceCategory = Be::getService('App.Tool.Admin.Category');
        $categoryTree = $serviceCategory->getTree();
        $response->set('categoryTree', $categoryTree);

        $response->set('title', '网址管理');
        $response->display();
    }

    /**
     * 获取文档
     *
     * @BePermission("项目文档管理")
     */
    public function getGroupUrls()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        try {
            $categoryId = $request->json('category_id', '');
            $groupUrls = Be::getService('App.Tool.Admin.Url')->getGroupUrls($categoryId);
            $response->set('success', true);
            $response->set('message', '获取文档成功！');
            $response->set('groupUrls', $groupUrls);
            $response->json();
        } catch (\Throwable $t) {
            $response->set('success', false);
            $response->set('message', $t->getMessage());
            $response->json();
        }
    }

    /**
     * 保存
     *
     * @BePermission("保存网址")
     */
    public function edit()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        try {
            $categoryId = $request->json('category_id', '');
            Be::getService('App.Tool.Admin.Url')->edit($categoryId, $request->json('formData'));
            $response->set('success', true);
            $response->set('message', '保存成功！');
            $response->json();
        } catch (\Throwable $t) {
            $response->set('success', false);
            $response->set('message', $t->getMessage());
            $response->json();
        }
    }

}
