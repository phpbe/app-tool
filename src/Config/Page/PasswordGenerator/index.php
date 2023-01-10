<?php

namespace Be\App\Tool\Config\Page\PasswordGenerator;


class index
{

    public int $middle = 1;

    public array $middleSections = [
        [
            'name' => 'App.Tool.Menu',
        ],
        [
            'name' => 'App.Tool.PasswordGenerator',
        ],
    ];

    /**
     * @BeConfigItem("HEAD头标题",
     *     description="HEAD头标题，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $title = '在线生成随机密码';

    /**
     * @BeConfigItem("Meta描述",
     *     description="填写页面内容的简单描述，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaDescription = '在线生成随机密码，可选大写/小写字母、阿拉伯数字、特殊符号、长度等';

    /**
     * @BeConfigItem("Meta关键词",
     *     description="填写页面内容的关键词，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaKeywords = '生成,随机,密码';

    /**
     * @BeConfigItem("页面标题",
     *     description="展示在页面内容中的标题，一般与HEAD头标题一致，两者相同时可不填写此项",
     *     driver = "FormItemInput"
     * )
     */
    public string $pageTitle = '';

}
