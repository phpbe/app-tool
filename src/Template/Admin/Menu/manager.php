<be-page-content>
    <div class="be-bc-fff be-p-150" id="app" v-cloak>

        <div class="be-fw-bold be-bb-eee be-pb-50">初始化工具菜单</div>
        <div class="be-c-666 be-mt-50">初始化功能用来重置工具菜单，将首先清除工具菜单，然后检测应用中的菜单项注解，重建菜单项。</div>
        <div class="be-mt-100">
            <el-button type="danger" size="small" @click="init">执行</el-button>
        </div>


        <div class="be-fw-bold be-bb-eee be-pb-50 be-mt-200">删除工具菜单</div>
        <div class="be-c-666 be-mt-50">删除仅用来删除工具菜单。</div>
        <div class="be-mt-100">
            <el-button type="danger" size="small" @click="del">执行</el-button>
        </div>

        <ul class="be-mt-200 be-pl-100">
            <li class="be-lh-150 be-c-666">工具菜单在应用安装时会自动创建系统菜单项（Tool - 工具菜单），通过BE框架的 <el-tag size="mini">网站装修</el-tag> &gt; <el-tag size="mini">菜单导航</el-tag> 管理></li>
            <li class="be-lh-150 be-c-666">应用更新时，您可以在菜单管理界面手工添加新增的工具，</li>
            <li class="be-lh-150 be-c-666">也可以通过本页面提供的功能重建工具菜单，或清除工具菜单，</li>
        </ul>

        <div class="be-mt-100">
            <el-link type="primary" href="<?php echo beAdminUrl('System.Menu.menus'); ?>">前往菜单管理</el-link>
        </div>

    </div>
    <script>
        let vueCenter = new Vue({
            el: '#app',
            data: {
                loading: false,
                t: false
            },
            methods: {
                init: function () {
                    let _this = this;
                    _this.loading = true;
                    _this.$http.get("<?php echo beAdminUrl('Tool.Menu.init'); ?>").then(function (response) {
                        _this.loading = false;
                        if (response.status === 200) {
                            var responseData = response.data;
                            if (responseData.success) {
                                _this.$message.success(responseData.message);
                            } else {
                                if (responseData.message) {
                                    _this.$message.error(responseData.message);
                                } else {
                                    _this.$message.error("服务器返回数据异常！");
                                }
                            }
                        }
                    }).catch(function (error) {
                        _this.loading = false;
                        _this.$message.error(error);
                    });
                },
                del: function () {
                    let _this = this;
                    _this.loading = true;
                    _this.$http.get("<?php echo beAdminUrl('Tool.Menu.delete'); ?>").then(function (response) {
                        _this.loading = false;
                        if (response.status === 200) {
                            var responseData = response.data;
                            if (responseData.success) {
                                _this.$message.success(responseData.message);
                            } else {
                                if (responseData.message) {
                                    _this.$message.error(responseData.message);
                                } else {
                                    _this.$message.error("服务器返回数据异常！");
                                }
                            }
                        }
                    }).catch(function (error) {
                        _this.loading = false;
                        _this.$message.error(error);
                    });
                },
                t: function () {
                }
            },
        });
    </script>
</be-page-content>