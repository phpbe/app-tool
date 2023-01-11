<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class Timestamp
{

    /**
     * Base64
     *
     * @BeMenu("时间戳", ordering="3")
     * @BeRoute("/tool/timestamp")
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
            $response->set('data', date('Y-m-d H:i:s', $key));
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
            $response->set('data', strtotime($key));
            $response->json();
        }
    }

}
