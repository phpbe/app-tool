<?php

namespace Be\App\Tool\Section\Color;

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

        $color = \Be\Be::getRequest()->get('color', '');

        echo '<div class="tool-color">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        echo '<div class="be-row">';
        echo '<div class="be-col-auto be-lh-250">输入3或6位16进制颜色：</div>';
        echo '<div class="be-col-auto be-lh-250">#</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-px-50">';
        echo '<form id="form_encode">';
        echo '<input type="text" class="be-input" name="key" id="key" value="' . $color . '" placeholder="请输入颜色..." onkeyup="checkEncode();" />';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '<div class="be-col-auto be-lh-250">';
        echo '<input type="button" class="be-btn be-btn-major" id="btn_encode" value="获取渐变颜色" />';
        echo '</div>';
        echo '</div>';


        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '<div class="be-ta-center">变浅</div>';
        echo '<ul class="be-mt-50 be-mb-200" id="lighter-colors"></ul>';
        echo '</div>';
        echo '<div class="be-col-auto">';
        echo '<div class="be-pl-200"></div>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<div class="be-ta-center">加深</div>';
        echo '<ul class="be-mt-50 be-mb-200" id="darker-colors"></ul>';
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
        echo $this->getCssPadding('tool-color');
        echo $this->getCssMargin('tool-color');
        echo $this->getCssBackgroundColor('tool-color');
        echo '#lighter-colors, #darker-colors{ margin:0; padding:0;}';
        echo '#lighter-colors li, #darker-colors li{ padding:5px; margin:5px; list-style:none; text-align:center; font-family:黑体; font-size:1.5rem;}';
        echo '#darker-colors li{ color: #ccc;}';
        echo '</style>';
    }


    private function js()
    {
        echo '<script type="text/javascript">';

        echo 'function checkEncode() {';
        echo 'if( $.trim($("#key").val()) =="") {';
        echo '$("#btn_encode").attr("disabled", "disabled");';
        echo '} else {';
        echo '$("#btn_encode").removeAttr("disabled");';
        echo '}';
        echo '}';

        echo '$(function () {';
        echo 'checkEncode();';

        echo '$("#btn_encode").click(function() {';
        echo 'let sKey = $.trim($("#key").val());';
        echo 'if(sKey=="") return;';

        echo 'let $resultLighterColors = $("#lighter-colors");';
        echo 'let $resultDarkerColors = $("#darker-colors");';

        echo '$resultLighterColors.html("<li>计算中...</li>");';
        echo '$resultDarkerColors.html("<li>计算中...</li>");';

        echo '$.ajax({';
        echo 'type: "post",';
        echo 'url: "' . beUrl('Tool.Color.encode') . '",';
        echo 'data: $("#form_encode").serialize(),';
        echo 'dataType: "json",';
        echo 'success: function(response) {';
        echo 'if (response.success) {';
        echo 'let html;';
        echo 'let color;';

        echo 'html = "";';
        echo 'for(let p in response.data.lighterColors) {';
        echo 'color = response.data.lighterColors[p];';
        echo 'html += \'<li style="background-color:\' + color + \';">\' + p + \' \' + color + \'</li>\';';
        echo '}';
        echo '$resultLighterColors.html(html);';

        echo 'html = "";';
        echo 'for(let p in response.data.darkerColors) {';
        echo 'color = response.data.darkerColors[p];';
        echo 'html += \'<li style="background-color:\' + color + \';">\' + p + \' \' +color + \'</li>\';';
        echo '}';
        echo '$resultDarkerColors.html(html);';

        echo '}';
        echo '}';
        echo '});';
        echo '});';

        echo '});';
        echo '</script>';
    }

}

