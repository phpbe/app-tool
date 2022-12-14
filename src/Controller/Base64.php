<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class Base64
{

    /**
     * Base64
     *
     * @BeMenu("BASE64")
     * @BeRoute("/tool/base60")
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

        $key = $request->post('key', '');
        if ($key) {
            $response->set('success', true);
            $response->set('data', base64_encode($key));
            $response->json();
        }
    }

    public function decode()
    {
        $request = Be::getRequest();
        $response = Be::getResponse();

        $key = $request->post('key', '');
        if ($key) {
            $response->set('success', true);
            $response->set('data', htmlspecialchars(base64_decode($key)));
            $response->json();
        }
    }

}
