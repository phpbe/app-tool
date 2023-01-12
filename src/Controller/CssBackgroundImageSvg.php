<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class CssBackgroundImageSvg
{

    /**
     * CSS背景SVG
     *
     * @BeMenu("CSS背景SVG", ordering="6")
     * @BeRoute("/tool/css-background-image-svg")
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
        $remove_attr = $request->post('remove_attr', '0');
        if ($key) {
            $css = $key;
            if ($remove_attr === '1') {
                $css = preg_replace('/ width="[a-zA-Z0-9\-\s]*"/', '', $css);
                $css = preg_replace('/ height="[a-zA-Z0-9\-\s]*"/', '', $css);
                $css = preg_replace('/ fill="[a-zA-Z0-9\-\s]*"/', '', $css);
                $css = preg_replace('/ class="[a-zA-Z0-9\-\s]*"/', '', $css);
            }

            $css = preg_replace('/>\s+</', '><', $css);
            $css = str_replace(['<', '>', '#', '(', ')'], ['%3c', '%3e', '%23', '%28', '%29'], $css);
            $css = str_replace('"', '\'', $css);
            $css = 'background-image: url("data:image/svg+xml,' . $css . '");';

            $response->set('success', true);
            $response->set('data', $css);
            $response->json();
        } else {
            $response->set('success', false);
            $response->set('message', '请求参数无效！');
            $response->json();
        }
    }


}
