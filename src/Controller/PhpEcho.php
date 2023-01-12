<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class PhpEcho
{

    /**
     * PHP echo
     *
     * @BeMenu("PHP echo", ordering="7")
     * @BeRoute("/tool/php-echo")
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
            $lines = explode("\n", $key);
            $code = '';
            foreach ($lines as $line) {
                $line = trim($line);
                $line = str_replace('\'', '\\\'', $line);
                if ($line === '') {
                    $code .= "\n";
                } else {
                    $code .= 'echo \'' . $line . '\';' . "\n";
                }
            }

            $code = trim($code);

            $response->set('success', true);
            $response->set('data', $code);
            $response->json();
        } else {
            $response->set('success', false);
            $response->set('message', '请求参数无效！');
            $response->json();
        }
    }

}
