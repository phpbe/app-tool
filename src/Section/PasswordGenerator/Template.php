<?php

namespace Be\App\Tool\Section\PasswordGenerator;

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

        echo '<div class="tool-password-generator">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        echo '<div class="be-bb-ccc be-fw-bold be-py-25">生成随机密码</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">种子字符</div>';
        echo '<div class="be-col">';
        echo '<label><input class="be-checkbox" type="checkbox" id="password_seed_1" checked="checked" /> 小写字母</label>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<label><input class="be-checkbox" type="checkbox" id="password_seed_2" checked="checked" /> 大写字母</label>';
        echo '</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<label><input class="be-checkbox" type="checkbox" id="password_seed_3" checked="checked" /> 阿拉伯数字</label>';
        echo '</div>';
        echo '<div class="be-col">';
        echo '<label><input class="be-checkbox" type="checkbox" id="password_seed_4" /> 特殊符号</label>';
        echo '</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col">密码位数</div>';
        echo '<div class="be-col">';
        echo '<input type="number" class="be-input" id="password_length" value="10" maxlength="2" style="width:120px;" /> ';
        echo '</div>';
        echo '<div class="be-col">1 - 50 位</div>';
        echo '</div>';

        echo '<div class="be-row be-mt-100">';
        echo '<div class="be-col"></div>';
        echo '<div class="be-col">';
        echo '<button onClick="javascript:generatePassword();" class="be-btn be-btn-major"><i class="icon-share-alt icon-white"></i> 生成</button>';
        echo '</div>';
        echo '<div class="be-col"></div>';
        echo '</div>';

        echo '<div class="be-mt-100 be-bb-ccc be-fw-bold be-py-25">生成结果</div>';

        echo '<ul class="be-mt-50 be-mb-200" id="password_results"></ul>';

        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '</div>';
        }
        echo '</div>';

        $this->js();
    }


    private function css()
    {
        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-password-generator');
        echo $this->getCssMargin('tool-password-generator');
        echo $this->getCssBackgroundColor('tool-password-generator');

        echo '#password_results{ margin:0; padding:0;}';
        echo '#password_results li{ border:#EEE 1px solid; color:#999; background-color:#FFFFFF; padding:5px; margin:5px; list-style:none; text-align:center;}';
        echo '#password_results li.last{ border:var(--major-color) 1px solid; color:var(--major-color); background-color:var(--major-color-9);}';
        echo '</style>';
    }


    private function js()
    {
        echo '<script type="text/javascript">';

        echo 'function generatePassword() {';
        echo 'let sSeed = "";';
        echo 'if($("#password_seed_1").prop("checked")) sSeed += "abcdefhjmnpqrstuvwxyz";';
        echo 'if($("#password_seed_2").prop("checked")) sSeed += "ABCDEFGHJKLMNPQRSTUVWYXZ";';
        echo 'if($("#password_seed_3").prop("checked")) sSeed += "1234567890";';
        echo 'if($("#password_seed_4").prop("checked")) sSeed += "!@#$%^&*()_+";';
        echo 'if(sSeed == "") {';
        echo 'alert("请选择所用字符");';
        echo 'return false;';
        echo '}';

        echo 'let sLength = $("#password_length").val();';
        echo 'if(isNaN(sLength)) {';
        echo 'alert("密码位数请输入数字");';
        echo 'return false;';
        echo '}';
        echo 'let iLength = parseInt(sLength);';
        echo 'if(iLength < 0) iLength = 1;';
        echo 'if(iLength > 50) iLength = 50;';
        echo '$("#password_length").val(iLength);';

        echo 'let sResult = "";';
        echo 'let iSeedLength = sSeed.length;';
        echo 'for (var i = 0; i < iLength; i++) {';
        echo 'sResult += sSeed.charAt(Math.floor(Math.random() * iSeedLength));';
        echo '}';
        echo '$("#password_results li:first").removeClass("last");';
        echo 'let sHtml = $("#password_results").html();';
        echo '$("#password_results").html("<li>"+sResult+"</li>"+sHtml);';
        echo '$("#password_results li:first").addClass("last");';
        echo 'if($("#password_results li").length>5) {';
        echo '$("#password_results li").each(function(i){';
        echo 'if(i>=10) {';
        echo '$(this).fadeOut(500, function(){$(this).remove();});';
        echo '}';
        echo '});';
        echo '}';

        echo '}';
        echo '</script>';
    }

}

