<?php

namespace Be\App\Tool\Config\Page\Timestamp;

class index
{

    public int $middle = 1;

    public array $middleSections = [
        [
            'name' => 'App.Tool.Menu',
        ],
        [
            'name' => 'App.Tool.Timestamp',
        ],
    ];

    /**
     * @BeConfigItem("HEAD头标题",
     *     description="HEAD头标题，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $title = 'UNIX时间戳与日期时间相互转换';

    /**
     * @BeConfigItem("Meta描述",
     *     description="填写页面内容的简单描述，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaDescription = 'UNIX时间戳与日期时间相互转换';

    /**
     * @BeConfigItem("Meta关键词",
     *     description="填写页面内容的关键词，用于SEO",
     *     driver = "FormItemInput"
     * )
     */
    public string $metaKeywords = 'UNIX时间戳,日期时间,转换';

    /**
     * @BeConfigItem("页面标题",
     *     description="展示在页面内容中的标题，一般与HEAD头标题一致，两者相同时可不填写此项",
     *     driver = "FormItemInput"
     * )
     */
    public string $pageTitle = '';

}
