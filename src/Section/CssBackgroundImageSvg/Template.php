<?php

namespace Be\App\Tool\Section\CssBackgroundImageSvg;

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

        echo '<div class="tool-css-background-image-svg">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        echo '<h1 class="be-h1 be-bb-ccc be-fs-125 be-pb-25">' . $this->page->pageTitle . '</h1>';
        echo '<div class="be-mt-25 be-c-999">' . $this->page->metaDescription . '</div>';

        echo '<div class="be-row be-mt-200">';
        echo '<div class="be-col">SVG图像代码</div>';
        echo '<div class="be-col-auto"><div style="width: 240px"></div></div>';
        echo '<div class="be-col">生成结果</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '<form id="form_encode">';
        echo '<textarea class="be-textarea" style="width:100%; height:400px;resize:none;" name="key" id="key_encode" placeholder="请输入SVG图像代码..." onkeyup="checkEncode();">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">' . "\n";
        echo '<path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z"/>' . "\n";
        echo '</svg>';
        echo '</textarea>';
        echo '<div class="be-mt-50">';
        echo '<input class="be-checkbox" type="checkbox" name="remove_attr" id="remove_attr" value="1" checked> ';
        echo '<label for="remove_attr">移除SVG中的多余属性</label>';
		echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-ta-center be-px-100">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_encode" value="生成 &gt;&gt;" />';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<textarea class="be-textarea" style="width:100%; height:400px;resize:none;" name="key" id="result_encode" placeholder="处理结果"></textarea>';
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
        echo '<link rel="stylesheet" href="'. $baseUrl . 'lib/codemirror.css"/>';
        echo '<link rel="stylesheet" href="'. $baseUrl . 'addon/hint/show-hint.css"/>';

        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-css-background-image-svg');
        echo $this->getCssMargin('tool-css-background-image-svg');
        echo $this->getCssBackgroundColor('tool-css-background-image-svg');

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
        echo '<script src="'. $baseUrl . 'lib/codemirror.js"></script>';

        // html
        echo '<script src="'. $baseUrl . 'mode/htmlmixed/htmlmixed.js"></script>';
        echo '<script src="'. $baseUrl . 'mode/xml/xml.js"></script>';
        echo '<script src="'. $baseUrl . 'mode/javascript/javascript.js"></script>';
        echo '<script src="'. $baseUrl . 'mode/css/css.js"></script>';

        // css
        echo '<script src="'. $baseUrl . 'addon/edit/matchbrackets.js"></script>';
        echo '<script src="'. $baseUrl . 'addon/hint/show-hint.js"></script>';
        echo '<script src="'. $baseUrl . 'addon/hint/css-hint.js"></script>';
        //echo '<script src="'. $baseUrl . 'addon/css/css.js"></script>';


        echo '<script type="text/javascript">';

        echo 'function checkEncode() {';
        echo '$("#result_encode").html("");';
        echo 'if( $.trim($("#key_encode").val()) =="") {';
        echo '$("#btn_encode").attr("disabled", "disabled");';
        echo '} else {';
        echo '$("#btn_encode").removeAttr("disabled");';
        echo '}';
        echo '}';

        echo '$(function () {';
        echo 'checkEncode();';

        echo  'let codeMirror1 = CodeMirror.fromTextArea(document.getElementById("key_encode"), {theme:"default",mode:"htmlmixed",lineNumbers:true,lineWrapping:true});';
        echo  'let codeMirror2 = CodeMirror.fromTextArea(document.getElementById("result_encode"), {readOnly:true,theme:"default",mode:"text/css",lineNumbers:true,lineWrapping:true,matchBrackets:true});';

        echo 'codeMirror1.on("change", function(cm) {$("#key_encode").val(cm.getValue());checkEncode();});';

        echo '$("#btn_encode").click(function() {';
        echo 'let sKey = $.trim($("#key_encode").val());';
        echo 'if(sKey=="") return;';
        echo 'codeMirror2.setValue("计算中...");';
        echo '$.ajax({';
        echo 'type: "post",';
        echo 'url: "' . beUrl('Tool.CssBackgroundImageSvg.encode') . '",';
        echo 'data: $("#form_encode").serialize(),';
        echo 'dataType: "json",';
        echo 'success: function(response) {';
        echo 'if (response.success) {';
        echo 'codeMirror2.setValue(response.data);';
        echo '}';
        echo '}';
        echo '});';
        echo '});';

        echo '});';
        echo '</script>';
    }

}

