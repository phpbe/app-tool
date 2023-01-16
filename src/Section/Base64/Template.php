<?php

namespace Be\App\Tool\Section\Base64;

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

        echo '<div class="tool-base64">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }
        echo '<h1 class="be-h1 be-bb-ccc be-fs-125 be-pb-25">' . $this->page->pageTitle . '</h1>';
        echo '<div class="be-mt-25 be-c-999">' . $this->page->metaDescription . '</div>';

        echo '<div class="be-row be-mt-200">';
        echo '<div class="be-col">请输入要加密或解密的字符串</div>';
        echo '<div class="be-col-auto"><div style="width: 240px"></div></div>';
        echo '<div class="be-col">计算结果</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '<form id="form_encode">';
        echo '<textarea class="be-textarea" style="width:100%; height:200px;resize:none;" name="key" id="key_encode" placeholder="请输入要加密的字符串..." onkeyup="checkEncode();"></textarea>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-ta-center be-px-100">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_encode" value="BASE64 加密 &gt;&gt;" />';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<div id="result_encode" style="max-height:200px; word-break:break-all;word-wrap:break-word; overflow-y: auto;"></div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-200">';
        echo '<div class="be-col">';
        echo '<form id="form_decode">';
        echo '<textarea class="be-textarea" style="width:100%; height:200px;resize:none;" name="key" id="key_decode" placeholder="请输入要解密的字符串..." onkeyup="checkDecode();"></textarea>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-ta-center be-px-100">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_decode" value="BASE64 解密 &gt;&gt;" />';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<div id="result_decode" style="max-height:200px; word-break:break-all;word-wrap:break-word; overflow-y: auto;"></div>';
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
        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-base64');
        echo $this->getCssMargin('tool-base64');
        echo $this->getCssBackgroundColor('tool-base64');
        echo '</style>';
    }


    private function js()
    {
        echo '<script type="text/javascript">';

        echo 'function checkEncode() {';
        echo '$("#result_encode").html("");';
        echo 'if( $.trim($("#key_encode").val()) =="") {';
        echo '$("#btn_encode").attr("disabled", "disabled");';
        echo '} else {';
        echo '$("#btn_encode").removeAttr("disabled");';
        echo '}';
        echo '}';

        echo 'function checkDecode() {';
        echo '$("#result_decode").html("");';
        echo 'if( $.trim($("#key_decode").val()) =="") {';
        echo '$("#btn_decode").attr("disabled", "disabled");';
        echo '} else {';
        echo '$("#btn_decode").removeAttr("disabled");';
        echo '}';
        echo '}';

        echo '$(function () {';
        echo 'checkEncode();';
        echo 'checkDecode();';

        echo '$("#btn_encode").click(function() {';
        echo 'let sKey = $.trim($("#key_encode").val());';
        echo 'if(sKey=="") return;';
        echo 'let $result = $("#result_encode");';
        echo '$result.html("计算中...");';
        echo '$.ajax({';
        echo 'type: "post",';
        echo 'url: "' . beUrl('Tool.Base64.encode') . '",';
        echo 'data: $("#form_encode").serialize(),';
        echo 'dataType: "json",';
        echo 'success: function(response) {';
        echo 'if (response.success) {';
        echo '$result.html(response.data);';
        echo '}';
        echo '}';
        echo '});';
        echo '});';

        echo '$("#btn_decode").click(function() {';
        echo 'let sKey = $.trim($("#key_decode").val());';
        echo 'if(sKey=="") return;';
        echo 'let $result = $("#result_decode");';
        echo '$result.html("计算中...");';
        echo '$.ajax({';
        echo 'type: "post",';
        echo 'url: "' . beUrl('Tool.Base64.decode') . '",';
        echo 'data: $("#form_decode").serialize(),';
        echo 'dataType: "json",';
        echo 'success: function(response) {';
        echo 'if (response.success) {';
        echo '$result.html(response.data);';
        echo '}';
        echo '}';
        echo '});';
        echo '});';

        echo '});';
        echo '</script>';
    }

}

