<?php

namespace Be\App\Tool\Controller;

use Be\Be;

class Color
{

    /**
     * Base64
     *
     * @BeMenu("颜色处理", ordering="5")
     * @BeRoute("/tool/color")
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
        $key = trim($key);
        if (substr($key,0 , 1) != '#') {
            $key = '#' . $key;
        }

        if ($key && $this->isColor($key)) {
            $lighterColors = [
                '0%' => $key,
            ];
            $darkerColors = [
                '0%' => $key,
            ];
            $libCss = Be::getLib('Css');
            for ($i = 5; $i <= 100; $i += 5) {
                $lighterColors[$i . '%'] = $libCss->lighter($key, $i);
                $darkerColors[$i . '%'] = $libCss->darker($key, $i);
            }

            $response->set('success', true);
            $response->set('data', [
                'lighterColors' => $lighterColors,
                'darkerColors' => $darkerColors,
            ]);
            $response->json();
        } else {
            $response->set('success', false);
            $response->set('message', '请求参数无效！');
            $response->json();
        }
    }

    private function isColor($color)
    {
        if (strlen($color) < 3) return false;
        if (substr($color, 0, 1) == '#') $color = substr($color, 1);
        if (strlen($color) != 3 && strlen($color) != 6) return false;
        $color = strtolower($color);

        $colors = str_split($color);
        $units = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($colors as $c) {
            if (!in_array($c, $units)) return false;
        }
        return true;
    }


}
