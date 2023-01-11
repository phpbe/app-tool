<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class PasswordGenerator
{

    /**
     * Base64
     *
     * @BeMenu("密码生成器", ordering="4")
     * @BeRoute("/tool/password-generator")
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

    }

    public function decode()
    {

    }

}
