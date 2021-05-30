<?php /*a:1:{s:62:"D:\wamp64\www\amzcount\application\index\view\index\index.html";i:1622363152;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>amzcount</title>
    <script src="/static/jq.js"></script>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/layui/layui.js"></script>
    <script src="/static/echarts.js"></script>
    <script src="/static/vue.js"></script>
    <!-- <link rel="stylesheet" href="/static/element-ui.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

    <script src="/static/element-ui.js"></script>
</head>
<style>
</style>
<body>
<div id="app">
    <template>
        <el-tabs type="border-card" v-model="activeName" @tab-click="handleClick" style="width: 98%;margin:0 auto;">
            <el-tab-pane label="美国" name="usa">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="usaform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="usaform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="usaonSubmit('usa')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="usaform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="usaform" label-width="100px">
                                <input type="radio" name="usaonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="usaform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="usaonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="usaform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="usaform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('usa')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="usatableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ usatext(scope.$index, scope.row.id,'usa') }}
                                <div :id="`usatiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="usahandleSizeChange"
                            @current-change="usahandleCurrentChange"
                            :current-page="usacurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="usasize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="usatotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="英国" name="uk">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="ukform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="ukform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="ukonSubmit('uk')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="ukform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="ukform" label-width="100px">
                                <input type="radio" name="ukonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="ukform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="ukonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="ukform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="ukform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('uk')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="uktableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ uktext(scope.$index, scope.row.id,'uk') }}
                                <div :id="`uktiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="ukhandleSizeChange"
                            @current-change="ukhandleCurrentChange"
                            :current-page="ukcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="uksize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="uktotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="德国" name="de">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="deform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="deform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="deonSubmit('de')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="deform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="deform" label-width="100px">
                                <input type="radio" name="deonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="deform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="deonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="deform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="deform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('de')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="detableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ detext(scope.$index, scope.row.id,'de') }}
                                <div :id="`detiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="dehandleSizeChange"
                            @current-change="dehandleCurrentChange"
                            :current-page="decurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="desize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="detotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="日本" name="jp">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="jpform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="jpform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="jponSubmit('jp')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="jpform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="jpform" label-width="100px">
                                <input type="radio" name="jponly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="jpform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="jponly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="jpform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="jpform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('jp')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="jptableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ jptext(scope.$index, scope.row.id,'jp') }}
                                <div :id="`jptiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="jphandleSizeChange"
                            @current-change="jphandleCurrentChange"
                            :current-page="jpcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="jpsize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="jptotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="西班牙" name="esp">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="espform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="espform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="esponSubmit('esp')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="espform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="espform" label-width="100px">
                                <input type="radio" name="esponly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="espform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="esponly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="espform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="espform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('esp')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="esptableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ esptext(scope.$index, scope.row.id,'esp') }}
                                <div :id="`esptiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="esphandleSizeChange"
                            @current-change="esphandleCurrentChange"
                            :current-page="espcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="espsize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="esptotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="意大利" name="it">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="itform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="itform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="itonSubmit('it')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="itform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="itform" label-width="100px">
                                <input type="radio" name="itonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="itform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="itonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="itform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="itform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('it')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="ittableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ ittext(scope.$index, scope.row.id,'it') }}
                                <div :id="`ittiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="ithandleSizeChange"
                            @current-change="ithandleCurrentChange"
                            :current-page="itcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="itsize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="ittotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="法国" name="fr">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="frform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="frform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="fronSubmit('fr')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="frform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="frform" label-width="100px">
                                <input type="radio" name="fronly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="frform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="fronly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="frform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="frform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('fr')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="frtableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ frtext(scope.$index, scope.row.id,'fr') }}
                                <div :id="`frtiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="frhandleSizeChange"
                            @current-change="frhandleCurrentChange"
                            :current-page="frcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="frsize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="frtotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="墨西哥" name="mx">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="mxform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="mxform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="mxonSubmit('mx')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="mxform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="mxform" label-width="100px">
                                <input type="radio" name="mxonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="mxform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="mxonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="mxform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="mxform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('mx')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="mxtableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ mxtext(scope.$index, scope.row.id,'mx') }}
                                <div :id="`mxtiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="mxhandleSizeChange"
                            @current-change="mxhandleCurrentChange"
                            :current-page="mxcurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="mxsize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="mxtotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
            <el-tab-pane label="加拿大" name="ca">
                <div style="width: 98%;height:200px;margin:0 auto;border: 1px solid #d1dbe5">
                    <div style="width:50%;float: left;margin-top: 30px;">
                        <el-form :inline="true" :model="caform" class="demo-form-inline" style="margin-left: 20px;">
                            <el-form-item label="关键词">
                                <el-input v-model="caform.key_words" placeholder="请输入关键词" size="small"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" size="small" @click="caonSubmit('ca')">搜索</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div style="width:50%;float: left;margin-top: 10px;">
                        <div class="block" style="margin-bottom: 5px;">
                            <span class="demonstration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：&nbsp;&nbsp;</span>
                            <el-date-picker
                                    size="small"
                                    unlink-panels
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"
                                    v-model="caform.sdate"
                                    type="daterange"
                                    range-separator="TO"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <div>
                            <el-form ref="form" :model="caform" label-width="100px">
                                <input type="radio" name="caonly_who" checked="checked" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长量：">
                                    <el-input v-model="caform.val_change" size="small" style="width: 70%;"></el-input>
                                </el-form-item>

                                <input type="radio" name="caonly_who" style="float: left;margin-top: 13px;">
                                <el-form-item label="每周增长率：">
                                    <el-input v-model="caform.percentage_change" size="small" style="width: 70%;"></el-input>&nbsp;%
                                </el-form-item>
                                <el-form-item label="达标比例：" style="margin-left: 13px;">
                                    <el-input v-model="caform.satisfy_p" size="small" style="width: 71%;"></el-input>&nbsp;%
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
                <el-button style="float: right;margin-right: 20px;margin-top: 10px;margin-bottom: 10px;" size="small" type="primary" icon="el-icon-download"
                           @click="downloadExcel('ca')">导出
                </el-button>

                <el-table
                        v-loading="loading"
                        :data="catableData"
                        tooltip-effect="dark"
                        :row-key="(row)=>{ return row.id}"
                        stripe
                        style="width: 98%;margin: 0 auto;border: 1px solid #d1dbe5;"
                        height="670"
                        :header-cell-style="{textAlign: 'center'}"
                        :cell-style="{ textAlign: 'center' }"
                        @selection-change="handleSelectionChange">
                    <el-table-column
                            type="selection"
                            :reserve-selection="true"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            fixed
                            prop="key_words"
                            label="关键词">
                    </el-table-column>
                    <el-table-column
                            prop="c_rank"
                            label="本周排名">
                    </el-table-column>
                    <el-table-column
                            prop="l_rank"
                            label="上周排名">
                    </el-table-column>
                    <el-table-column
                            prop="chang"
                            label="排名变化">
                    </el-table-column>
                    <el-table-column
                            prop="update_time"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            prop="pic"
                            label="图表"
                            width="1300">
                        <template slot-scope="scope">
                            <div>
                                {{ catext(scope.$index, scope.row.id,'ca') }}
                                <div :id="`catiger-sale-trend-index` + scope.$index" class="tiger-trend-charts"></div>
                            </div>
                        </template>
                    </el-table-column>
                    </el-table-column>
                </el-table>
                <div class="block">
                    <el-pagination
                            @size-change="cahandleSizeChange"
                            @current-change="cahandleCurrentChange"
                            :current-page="cacurrentPage"
                            :page-sizes="[5, 10, 20, 50]"
                            :page-size="casize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="catotle">
                    </el-pagination>
                </div>
            </el-tab-pane>
        </el-tabs>

    </template>

</div>

<script>
</script>
</body>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                usacurrentPage: 1,
                usasize: 5,
                usatotle: 0,
                usaform: {},
                usatableData: [],

                ukcurrentPage: 1,
                uksize: 5,
                uktotle: 0,
                ukform: {},
                uktableData: [],

                decurrentPage: 1,
                desize: 5,
                detotle: 0,
                deform: {},
                detableData: [],

                jpcurrentPage: 1,
                jpsize: 5,
                jptotle: 0,
                jpform: {},
                jptableData: [],

                espcurrentPage: 1,
                espsize: 5,
                esptotle: 0,
                espform: {},
                esptableData: [],

                itcurrentPage: 1,
                itsize: 5,
                ittotle: 0,
                itform: {},
                ittableData: [],

                frcurrentPage: 1,
                frsize: 5,
                frtotle: 0,
                frform: {},
                frtableData: [],

                mxcurrentPage: 1,
                mxsize: 5,
                mxtotle: 0,
                mxform: {},
                mxtableData: [],

                cacurrentPage: 1,
                casize: 5,
                catotle: 0,
                caform: {},
                catableData: [],


                loading: false,
                multipleSelection: [], //选中的数据
                excelData: [],
                activeName: 'usa',
                isclicktabs:['usa']
            }
        },
        methods: {
            usagetListdata(cu) {
                this.loading = true
                var that = this
                if(this.usaform.key_words!=undefined || this.usaform.percentage_change != undefined || this.usaform.satisfy_p != undefined || this.usaform.sdate != undefined || this.usaform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("usaonly_who");
                    if(obj[0].checked==true){
                        this.usaform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.usaform.val_change='';
                    }
                    if(this.usaform.usasatisfy_p != undefined){
                        if((this.usaform.val_change == undefined && this.usaform.percentage_change == '') || (this.usaform.val_change == '' && this.usaform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.usasize,
                        page: that.usacurrentPage,
                        search: that.usaform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                            if(jdata.code==1){
                                that.usatableData = jdata.data
                                that.usatotle = jdata.totle
                                that.usapicdata = jdata.picdata
                                that.loading = false
                            }else{
                                that.usatableData = []
                                that.loading = false
                                that.$message.error(jdata.message);
                            }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            ukgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.ukform.key_words!=undefined || this.ukform.percentage_change != undefined || this.ukform.satisfy_p != undefined || this.ukform.sdate != undefined || this.ukform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("ukonly_who");
                    if(obj[0].checked==true){
                        this.ukform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.ukform.val_change='';
                    }
                    if(this.ukform.usasatisfy_p != undefined){
                        if((this.ukform.val_change == undefined && this.ukform.percentage_change == '') || (this.ukform.val_change == '' && this.ukform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.uksize,
                        page: that.ukcurrentPage,
                        search: that.ukform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.uktableData = jdata.data
                            that.uktotle = jdata.totle
                            that.ukpicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.uktableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            degetListdata(cu) {
                this.loading = true
                var that = this
                if(this.deform.key_words!=undefined || this.deform.percentage_change != undefined || this.deform.satisfy_p != undefined || this.deform.sdate != undefined || this.deform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("deonly_who");
                    if(obj[0].checked==true){
                        this.deform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.deform.val_change='';
                    }
                    if(this.deform.usasatisfy_p != undefined){
                        if((this.deform.val_change == undefined && this.deform.percentage_change == '') || (this.deform.val_change == '' && this.deform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.desize,
                        page: that.decurrentPage,
                        search: that.deform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.detableData = jdata.data
                            that.detotle = jdata.totle
                            that.depicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.detableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            jpgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.jpform.key_words!=undefined || this.jpform.percentage_change != undefined || this.jpform.satisfy_p != undefined || this.jpform.sdate != undefined || this.jpform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("jponly_who");
                    if(obj[0].checked==true){
                        this.jpform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.jpform.val_change='';
                    }
                    if(this.jpform.usasatisfy_p != undefined){
                        if((this.jpform.val_change == undefined && this.jpform.percentage_change == '') || (this.jpform.val_change == '' && this.jpform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.jpsize,
                        page: that.jpcurrentPage,
                        search: that.jpform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.jptableData = jdata.data
                            that.jptotle = jdata.totle
                            that.jppicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.jptableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            espgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.espform.key_words!=undefined || this.espform.percentage_change != undefined || this.espform.satisfy_p != undefined || this.espform.sdate != undefined || this.espform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("esponly_who");
                    if(obj[0].checked==true){
                        this.espform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.espform.val_change='';
                    }
                    if(this.espform.usasatisfy_p != undefined){
                        if((this.espform.val_change == undefined && this.espform.percentage_change == '') || (this.espform.val_change == '' && this.espform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.espsize,
                        page: that.espcurrentPage,
                        search: that.espform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.esptableData = jdata.data
                            that.esptotle = jdata.totle
                            that.esppicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.esptableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            itgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.itform.key_words!=undefined || this.itform.percentage_change != undefined || this.itform.satisfy_p != undefined || this.itform.sdate != undefined || this.itform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("itonly_who");
                    if(obj[0].checked==true){
                        this.itform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.itform.val_change='';
                    }
                    if(this.itform.usasatisfy_p != undefined){
                        if((this.itform.val_change == undefined && this.itform.percentage_change == '') || (this.itform.val_change == '' && this.itform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.itsize,
                        page: that.itcurrentPage,
                        search: that.itform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.ittableData = jdata.data
                            that.ittotle = jdata.totle
                            that.itpicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.ittableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            frgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.frform.key_words!=undefined || this.frform.percentage_change != undefined || this.frform.satisfy_p != undefined || this.frform.sdate != undefined || this.frform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("fronly_who");
                    if(obj[0].checked==true){
                        this.frform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.frform.val_change='';
                    }
                    if(this.frform.satisfy_p != undefined){
                        if((this.frform.val_change == undefined && this.frform.percentage_change == '') || (this.frform.val_change == '' && this.frform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.frsize,
                        page: that.frcurrentPage,
                        search: that.frform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.frtableData = jdata.data
                            that.frtotle = jdata.totle
                            that.frpicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.frtableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            mxgetListdata(cu) {
                this.loading = true
                var that = this
                if(this.mxform.key_words!=undefined || this.mxform.percentage_change != undefined || this.mxform.satisfy_p != undefined || this.mxform.sdate != undefined || this.mxform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("mxonly_who");
                    if(obj[0].checked==true){
                        this.mxform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.mxform.val_change='';
                    }
                    if(this.mxform.satisfy_p != undefined){
                        if((this.mxform.val_change == undefined && this.mxform.percentage_change == '') || (this.mxform.val_change == '' && this.mxform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.mxsize,
                        page: that.mxcurrentPage,
                        search: that.mxform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.mxtableData = jdata.data
                            that.mxtotle = jdata.totle
                            that.mxpicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.mxtableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },
            cagetListdata(cu) {
                this.loading = true
                var that = this
                if(this.caform.key_words!=undefined || this.caform.percentage_change != undefined || this.caform.satisfy_p != undefined || this.caform.sdate != undefined || this.caform.val_change != undefined){
                    // console.log(this.form.length)
                    var obj = document.getElementsByName("caonly_who");
                    if(obj[0].checked==true){
                        this.caform.percentage_change='';
                    }
                    if(obj[1].checked==true){
                        this.caform.val_change='';
                    }
                    if(this.caform.satisfy_p != undefined){
                        if((this.caform.val_change == undefined && this.caform.percentage_change == '') || (this.caform.val_change == '' && this.caform.percentage_change == undefined)){
                            this.$message.error('使用“达标比例”时，“每周增长量”或“每周增长率”必须填写其中一个');
                            this.loading = false
                            return false
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/index/index/getList",
                    data: {
                        limit: that.casize,
                        page: that.cacurrentPage,
                        search: that.caform,
                        cu: cu
                    },
                    dataType: "json",
                    success: function (data) {
                        var jdata = JSON.parse(data);
                        if(jdata.code==1){
                            that.catableData = jdata.data
                            that.catotle = jdata.totle
                            that.capicdata = jdata.picdata
                            that.loading = false
                        }else{
                            that.catableData = []
                            that.loading = false
                            that.$message.error(jdata.message);
                        }


                    },
                    error: function (jqXHR) {
                        that.loading = false
                    }
                });
            },

            usatext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.usatableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.usatableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.usatableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            uktext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.uktableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.uktableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.uktableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            detext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.detableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.detableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.detableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            jptext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.jptableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.jptableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.jptableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            esptext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.esptableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.esptableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.esptableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            ittext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.ittableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.ittableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.ittableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            mxtext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.mxtableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.mxtableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.mxtableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            frtext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.frtableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.frtableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.frtableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            catext: function (idname, id,cu) {
                // console.log(this.tableData[idname].key_words)
                var that = this
                // console.log(idname)
                let option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        },
                        formatter: function (datas) {
                            var res = '关键词：' + that.catableData[idname].key_words + '<br/>涨跌：' + datas[0].value + '<br/>日期：' + datas[0].axisValue;

                            return res;
                        },
                        textStyle: {
                            color: '#5c6c7c',
                            fontSize: 10
                        },
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 40
                    },
                    grid: {
                        top: 7,
                        bottom: 20
                        // containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        // axisLabel:{
                        //     clickable:true,
                        //     interval:0,
                        //     rotate:30
                        // },
                        data: this.catableData[idname][id].update_time
                    },
                    yAxis: {
                        show: true,
                        type: 'value'
                    },
                    series: [{
                        data: this.catableData[idname][id].chang,
                        type: 'bar',
                        showBackground: true,
                        backgroundStyle: {
                            color: 'rgba(180, 180, 180, 0.2)'
                        },
                        label: {
                            normal: {
                                // show:true,
                                textStyle: {
                                    fontSize: 10
                                }
                            }
                        }
                    }]
                }
                var id = cu+'tiger-sale-trend-index' + idname
                this.$nextTick(() => {
                    let myChart = echarts.init(document.getElementById(id), 'macarons');
                    myChart.setOption(option);
                    myChart.resize();
                })
            },
            usahandleSizeChange(val) {
                this.usasize = val
                this.usagetListdata('usa')
            },
            usahandleCurrentChange(val) {
                this.usacurrentPage = val
                this.usagetListdata('usa')
            },


            ukhandleSizeChange(val) {
                this.uksize = val
                this.ukgetListdata('uk')
            },
            ukhandleCurrentChange(val) {
                this.ukcurrentPage = val
                this.ukgetListdata('uk')
            },

            dehandleSizeChange(val) {
                this.desize = val
                this.degetListdata('de')
            },
            dehandleCurrentChange(val) {
                this.decurrentPage = val
                this.degetListdata('de')
            },

            jphandleSizeChange(val) {
                this.jpsize = val
                this.jpgetListdata('jp')
            },
            jphandleCurrentChange(val) {
                this.jpcurrentPage = val
                this.jpgetListdata('jp')
            },

            esphandleSizeChange(val) {
                this.espsize = val
                this.espgetListdata('esp')
            },
            esphandleCurrentChange(val) {
                this.espcurrentPage = val
                this.espgetListdata('esp')
            },

            ithandleSizeChange(val) {
                this.itsize = val
                this.itgetListdata('it')
            },
            ithandleCurrentChange(val) {
                this.itcurrentPage = val
                this.itgetListdata('it')
            },

            frhandleSizeChange(val) {
                this.frsize = val
                this.frgetListdata('fr')
            },
            frhandleCurrentChange(val) {
                this.frcurrentPage = val
                this.frgetListdata('fr')
            },

            mxhandleSizeChange(val) {
                this.mxsize = val
                this.mxgetListdata('mx')
            },
            mxhandleCurrentChange(val) {
                this.mxcurrentPage = val
                this.mxgetListdata('mx')
            },

            cahandleSizeChange(val) {
                this.casize = val
                this.cagetListdata('ca')
            },
            cahandleCurrentChange(val) {
                this.cacurrentPage = val
                this.cagetListdata('ca')
            },


            usaonSubmit(cu) {
                this.usagetListdata(cu)
            },
            ukonSubmit(cu) {
                this.ukgetListdata(cu)
            },
            deonSubmit(cu) {
                this.degetListdata(cu)
            },
            jponSubmit(cu) {
                this.jpgetListdata(cu)
            },
            esponSubmit(cu) {
                this.espgetListdata(cu)
            },
            itonSubmit(cu) {
                this.itgetListdata(cu)
            },
            fronSubmit(cu) {
                this.frgetListdata(cu)
            },
            mxonSubmit(cu) {
                this.mxgetListdata(cu)
            },
            caonSubmit(cu) {
                this.cagetListdata(cu)
            },


            handleSelectionChange(val) {
                this.multipleSelection = val;
                // console.log(this.multipleSelection[0]);
            },
            downloadExcel(cu) {
                var that = this
                if(this.multipleSelection.length==0){
                    this.$message.error('请选择需要导出的数据');
                    return
                }
                var ids='';
                for(var i=0;i<this.multipleSelection.length;i++){
                    ids+=this.multipleSelection[i].id+',';
                }
                window.open("/index/index/expExcel?ids="+ids+'&cu='+cu);
            },
            handleClick(tab, event) {
                this.multipleSelection=[];
                if(this.isclicktabs.indexOf(tab.name)==-1){
                    if(tab.name=='usa'){
                        this.usagetListdata('usa')
                    }
                    if(tab.name=='uk'){
                        this.ukgetListdata('uk')
                    }
                    if(tab.name=='de'){
                        this.degetListdata('de')
                    }
                    if(tab.name=='jp'){
                        this.jpgetListdata('jp')
                    }
                    if(tab.name=='esp'){
                        this.espgetListdata('esp')
                    }
                    if(tab.name=='it'){
                        this.itgetListdata('it')
                    }
                    if(tab.name=='fr'){
                        this.frgetListdata('fr')
                    }
                    if(tab.name=='mx'){
                        this.mxgetListdata('mx')
                    }
                    if(tab.name=='ca'){
                        this.cagetListdata('ca')
                    }
                    this.isclicktabs.push(tab.name)
                }

            }
        },
        watch: {
            size: function (newval, oldval) {

            },
        },
        mounted: function () {
            this.usagetListdata('usa')
            // this.ukgetListdata('uk')
            // this.degetListdata('de')
            // this.jpgetListdata('jp')
            // this.espgetListdata('esp')
            // this.itgetListdata('it')
            // this.frgetListdata('fr')
            // this.mxgetListdata('mx')
            // this.cagetListdata('ca')
        }
    })
</script>
<style>
    &
    -frame {
        display: flex;
        flex-flow: column nowrap;
        justify-content: space-between;
    }

    .price-bar {
        color: red !important;
    }

    .tiger-trend-charts {
        height: 120px;
        min-width: 100px;
    }

    .cell {
        font-size: 12px;
    }
    .el-form-item{
        margin-bottom: 0px;
    }
</style>
</html>
