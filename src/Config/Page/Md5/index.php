<?php

namespace Be\App\Tool\Config\Page\Md5;

class index
{

    public int $west = 0;
    public int $center = 1;
    public int $east = 0;

    public array $centerSections = [
        [
            'name' => 'App.Tool.Menu',
        ],
        [
            'name' => 'App.Tool.Md5',
        ],
    ];

    /**
     * @BeConfigItem("HEAD头标题",
     *     description="HEAD头标题，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $title = '在线MD5加密';

    /**
     * @BeConfigItem("Meta描述",
     *     description="填写页面内容的简单描述，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaDescription = '在线MD5加密';

    /**
     * @BeConfigItem("Meta关键词",
     *     description="填写页面内容的关键词，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaKeywords = 'MD5,在线,加密';

    /**
     * @BeConfigItem("页面标题",
     *     description="展示在页面内容中的标题，一般与HEAD头标题一致，两者相同时可不填写此项",
     *     driver = "FormItemInput"
     * )
     */
    public string $pageTitle = '';

}
