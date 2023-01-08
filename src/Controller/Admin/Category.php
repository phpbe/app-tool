<?php

namespace Be\App\Tool\Controller\Admin;

use Be\App\System\Controller\Admin\Auth;
use Be\Be;

/**
 * @BePermissionGroup("分类")
 */
class Category extends Auth
{

    /**
     * 指定项目下的项目文档管理
     *
     * @BeMenu("分类", icon="bi-Tools", ordering="1.1")
     * @BePermission("项目文档管理", ordering="1.1")
     */
    public function categories()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $service = Be::getService('App.Tool.Admin.Category');
        if ($request->isAjax()) {
            try {
                $service->save($request->json('formData'));
                $response->set('success', true);
                $response->set('message', '保存成功！');
                $response->json();
            } catch (\Throwable $t) {
                $response->set('success', false);
                $response->set('message', $t->getMessage());
                $response->json();
            }
        } else {
            $flatTree = $service->getFlatTree();
            $response->set('flatTree', $flatTree);
            $response->set('title', '分类');
            $response->display();
        }
    }

}
