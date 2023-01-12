<?php

namespace Be\App\Tool\Config\Page\CssBackgroundImageSvg;


class index
{

    public int $middle = 1;

    public array $middleSections = [
        [
            'name' => 'App.Tool.Menu',
        ],
        [
            'name' => 'App.Tool.CssBackgroundImageSvg',
        ],
    ];

    /**
     * @BeConfigItem("HEAD头标题",
     *     description="HEAD头标题，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $title = '在线生成CSS背景SVG';

    /**
     * @BeConfigItem("Meta描述",
     *     description="填写页面内容的简单描述，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaDescription = '在线生成CSS背景SVG，SVG图像用于CSS背景时，需要对部分字符进行转码，本工具协助开发人员自动生成CSS';

    /**
     * @BeConfigItem("Meta关键词",
     *     description="填写页面内容的关键词，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaKeywords = 'CSS,背景,SVG';

    /**
     * @BeConfigItem("页面标题",
     *     description="展示在页面内容中的标题，一般与HEAD头标题一致，两者相同时可不填写此项",
     *     driver = "FormItemInput"
     * )
     */
    public string $pageTitle = '';

}
