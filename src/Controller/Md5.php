<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class Md5
{

    /**
     * Base64
     *
     * @BeMenu("MD5")
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

    }

    public function decode()
    {

    }

}
