<?php

namespace Be\App\Tool\Section\Timestamp;

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

        echo '<div class="tool-timestamp">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        echo '<div class="be-row">';
        echo '<div class="be-col">请输入UNIX时间戳或日期</div>';
        echo '<div class="be-col-auto"><div style="width: 240px"></div></div>';
        echo '<div class="be-col">计算结果</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '<form id="form_encode">';
        echo '<textarea class="be-textarea" style="width:100%; height:60px;resize:none;" name="key" id="key_encode" placeholder="请输入UNIX时间戳(整数)..." onkeyup="checkEncode();"></textarea>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-ta-center" style="width: 240px">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_encode" value="时间戳转字符 &gt;&gt;" />';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<div id="result_encode"></div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="be-mt-50 be-c-999">当前UNIX时间戳：' . time() . '</div>';

        echo '<div class="be-row be-mt-200">';
        echo '<div class="be-col">';
        echo '<form id="form_decode">';
        echo '<textarea class="be-textarea" style="width:100%; height:60px;resize:none;" name="key" id="key_decode" placeholder="请输入字符格式的日期(如: 2000-01-01 12:00:00)..." onkeyup="checkDecode();"></textarea>';
        echo '</form>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-ta-center" style="width: 240px">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_decode" value="字符转时间戳 &gt;&gt;" />';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<div id="result_decode"></div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="be-mt-50 be-c-999">当前时间：' . date('Y-m-d H:i:s') . '</div>';

        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '</div>';
        }
        echo '</div>';

        $this->js();
    }


    private function css()
    {
        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-timestamp');
        echo $this->getCssMargin('tool-timestamp');
        echo $this->getCssBackgroundColor('tool-timestamp');
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
        echo 'url: "' . beUrl('Tool.Timestamp.encode') . '",';
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
        echo 'url: "' . beUrl('Tool.Timestamp.decode') . '",';
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

