<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class Md5
{

    /**
     * Base64
     *
     * @BeMenu("MD5", ordering="2")
     * @BeRoute("/tool/md5")
     */
    public function index()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $pageConfig = $response->getPageConfig();
        $response->set('pageConfig', $pageConfig);

        $response->set('title', $pageConfig->title ?: '');
        $response->set('metaDescription', $pageConfig->metaDescription ?: '');
        $response->set('metaKeywords', $pageConfig->metaKeywords ?: '');
        $response->set('pageTitle', $pageConfig->pageTitle ?: ($pageConfig->title ?: ''));

        $response->display();
    }

    public function encode()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $key = $request->post('key', '', '');
        $key = trim($key);
        if ($key) {
            $response->set('success', true);
            $response->set('data', md5($key));
            $response->json();
        } else {
            $response->set('success', false);
            $response->set('message', '请求参数无效！');
            $response->json();
        }
    }

}
