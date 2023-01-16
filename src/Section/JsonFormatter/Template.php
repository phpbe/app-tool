<?php

namespace Be\App\Tool\Section\JsonFormatter;

use Be\Be;
use Be\Theme\Section;

class Template extends Section
{

    public array $positions = ['middle', 'center'];


    public function display()
    {
        if ($this->config->enable === 0) {
            return;
        }

        $this->css();

        echo '<div class="tool-php-echo">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        echo '<h1 class="be-h1 be-bb-ccc be-fs-125 be-pb-25">' . $this->page->pageTitle . '</h1>';
        echo '<div class="be-mt-25 be-c-999">' . $this->page->metaDescription . '</div>';

        echo '<div class="be-row be-mt-200">';
        echo '<div class="be-col">JSON字符串</div>';
        echo '<div class="be-col-auto"><div style="width: 240px"></div></div>';
        echo '<div class="be-col">格式化结果</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '<form id="form_encode">';
        echo '<textarea class="be-textarea" style="width:100%; height:400px;resize:none;" name="key" id="key_encode" placeholder="请输入JSON字符串..." onkeyup="checkEncode();">';
        echo '{';
        echo '"success":1,';
        echo '"message":"处理成功！"';
        echo '}';
        echo '</textarea>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        if ($this->config->server === 1) {
            echo '<div class="be-ta-center be-px-100">';
            echo '<input type="button" class="be-btn be-btn-major" id="btn_encode" value="格式化 &gt;&gt;" />';
            echo '</div>';
        } else {
            echo '<div class="be-ta-center be-pl-100">';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="be-col">';
        echo '<textarea class="be-textarea" style="width:100%; height:400px;resize:none;" name="key" id="result_encode" placeholder="格式化结果"></textarea>';
        echo '</div>';
        echo '</div>';

        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '</div>';
        }
        echo '</div>';

        $this->js();
    }

    private function css()
    {
        $baseUrl = Be::getProperty('App.Tool')->getWwwUrl() . '/lib/codemirror/codemirror-5.57.0/';
        echo '<link rel="stylesheet" href="' . $baseUrl . 'lib/codemirror.css"/>';
        echo '<link rel="stylesheet" href="' . $baseUrl . 'addon/lint/lint.css"/>';

        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-php-echo');
        echo $this->getCssMargin('tool-php-echo');
        echo $this->getCssBackgroundColor('tool-php-echo');

        echo '#' . $this->id . ' .CodeMirror {';
        echo 'font-size: 13px;';
        echo 'line-height: 1.5rem;';
        echo 'border: 1px solid #DCDFE6;';
        echo '}';

        echo '</style>';
    }

    private function js()
    {
        $baseUrl = Be::getProperty('App.Tool')->getWwwUrl() . '/lib/codemirror/codemirror-5.57.0/';
        echo '<script src="' . $baseUrl . 'lib/codemirror.js"></script>';

        // json
        echo '<script src="' . $baseUrl . 'mode/javascript/javascript.js"></script>';
        echo '<script src="' . $baseUrl . 'addon/edit/matchbrackets.js"></script>';
        echo '<script src="' . $baseUrl . 'addon/lint/jsonlint-1.6.0.js"></script>';
        echo '<script src="' . $baseUrl . 'addon/lint/lint.js"></script>';
        echo '<script src="' . $baseUrl . 'addon/lint/json-lint.js"></script>';

        echo '<script type="text/javascript">';

        echo 'let codeMirror;';

        echo 'function checkEncode() {';
        if ($this->config->server === 1) {
            echo '$("#result_encode").html("");';
            echo 'if( $.trim($("#key_encode").val()) =="") {';
            echo '$("#btn_encode").attr("disabled", "disabled");';
            echo '} else {';
            echo '$("#btn_encode").removeAttr("disabled");';
            echo '}';
        } else {
            echo 'let sKey = $.trim($("#key_encode").val());';
            echo 'try {';
            echo 'let json = JSON.stringify(JSON.parse(sKey), null, 2);';
            echo 'codeMirror.setValue(json);';
            echo '} catch (e) {';
            echo 'codeMirror.setValue(sKey);';
            echo '}';
        }
        echo '}';

        echo '$(function () {';

        echo 'codeMirror = CodeMirror.fromTextArea(document.getElementById("result_encode"), {';
        echo 'readOnly:true,';
        echo 'theme:"default",';
        echo 'mode:"application/json",';
        echo 'lineNumbers:true,';
        echo 'lineWrapping:true,';
        echo 'gutters:["CodeMirror-lint-markers"],';
        echo 'matchBrackets:true,';
        echo 'lint:true';
        echo '});';
        echo 'codeMirror.setSize("100%", "400px");';

        if ($this->config->server === 1) {
            echo '$("#btn_encode").click(function() {';
            echo 'let sKey = $.trim($("#key_encode").val());';
            echo 'if(sKey=="") return;';
            echo 'codeMirror.setValue("处理中...");';
            echo '$.ajax({';
            echo 'type: "post",';
            echo 'url: "' . beUrl('Tool.JsonFormatter.encode') . '",';
            echo 'data: $("#form_encode").serialize(),';
            echo 'dataType: "json",';
            echo 'success: function(response) {';
            echo 'if (response.success) {';
            echo 'codeMirror.setValue(response.data);';
            echo '}';
            echo '}';
            echo '});';
            echo '});';
        }


        echo 'checkEncode();';

        echo '});';
        echo '</script>';
    }
}

