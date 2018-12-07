<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>入香阁后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">

        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    访问量
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">9,999,666</p>
                    <p>
                        总计访问量
                        <span class="layuiadmin-span-color">88万 <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    下载
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">33,555</p>
                    <p>
                        新下载
                        <span class="layuiadmin-span-color">10% <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    收入
                    <span class="layui-badge layui-bg-green layuiadmin-badge">年</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">999,666</p>
                    <p>
                        总收入
                        <span class="layuiadmin-span-color">*** <i class="layui-inline layui-icon layui-icon-dollar"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    活跃用户
                    <span class="layui-badge layui-bg-orange layuiadmin-badge">月</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">66,666</p>
                    <p>
                        最近一个月
                        <span class="layuiadmin-span-color">15% <i class="layui-inline layui-icon layui-icon-user"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm12">
            <div class="layui-card">
                <div class="layui-card-header">
                    访问量
                    <div class="layui-btn-group layuiadmin-btn-group">
                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">去年</a>
                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">今年</a>
                    </div>
                </div>
                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-sm8">
                            <div id="test3" class="layui-carousel layadmin-carousel layadmin-dataview">
                                <div carousel-item>
                                    <div  style="display: block !important;" id="erchart1" style="width: 758px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm4">
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月访问数</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="30%"></div>
                                </div>
                            </div>
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月下载数</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="20%"></div>
                                </div>
                            </div>
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月收入</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-sm4">
            <div class="layui-card">
                <div class="layui-card-header">用户留言</div>
                <div class="layui-card-body">
                    <ul class="layuiadmin-card-status layuiadmin-home2-usernote">
                        <li>
                            <h3>诸葛亮</h3>
                            <p>皓首匹夫！苍髯老贼！你枉活九十有六，一生未立寸功，只会摇唇鼓舌！助曹为虐！一条断脊之犬，
                                还敢在我军阵前狺狺狂吠，我从未见过有如此厚颜无耻之人！</p>
                            <span>5月02日 00:00</span>
                            <a href="javascript:;" layadmin-event="replyNote" data-id="5" class="layui-btn layui-btn-xs
                            layuiadmin-reply">回复</a>
                        </li>
                        <li>
                            <h3>胡歌</h3>
                            <p>你以为只要长得漂亮就有男生喜欢？你以为只要有了钱漂亮妹子就自己贴上来了？你以为学霸就能找到好工作？
                                我告诉你吧，这些都是真的！</p>
                            <span>5月11日 00:00</span>
                            <a href="javascript:;" layadmin-event="replyNote" data-id="6" class="layui-btn layui-btn-xs
                            layuiadmin-reply">回复</a>
                        </li>
                        <li>
                            <h3>杜甫</h3>
                            <p>人才虽高，不务学问，不能致圣。刘向十日画一水，五日画一石。</p>
                            <span>4月11日 00:00</span>
                            <a href="javascript:;" layadmin-event="replyNote" data-id="2" class="layui-btn layui-btn-xs
                            layuiadmin-reply">回复</a>
                        </li>
                        <li>
                            <h3>鲁迅</h3>
                            <p>路本是无所谓有和无的，走的人多了，就没路了。。</p>
                            <span>4月28日 00:00</span>
                            <a href="javascript:;" layadmin-event="replyNote" data-id="4" class="layui-btn layui-btn-xs
                            layuiadmin-reply">回复</a>
                        </li>
                        <li>
                            <h3>张爱玲</h3>
                            <p>于千万人之中遇到你所要遇到的人，于千万年之中，时间的无涯的荒野中，没有早一步，也没有晚一步，刚巧赶上了，
                                那也没有别的话好说，唯有轻轻的问一声：“噢，原来你也在这里？”</p>
                            <span>4月11日 00:00</span>
                            <a href="javascript:;" layadmin-event="replyNote" data-id="1" class="layui-btn layui-btn-xs
                            layuiadmin-reply">回复</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-col-sm8">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-sm6">
                    <div class="layui-card">
                        <div class="layui-card-header">本周活跃用户列表</div>
                        <div class="layui-card-body">
                            <table class="layui-table layuiadmin-page-table" lay-skin="line">
                                <thead>
                                <tr>
                                    <th>用户名</th>
                                    <th>最后登录时间</th>
                                    <th>状态</th>
                                    <th>获得赞</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><span class="first">胡歌</span></td>
                                    <td><i class="layui-icon layui-icon-log"> 11:20</i></td>
                                    <td><span>在线</span></td>
                                    <td>22 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td><span class="second">彭于晏</span></td>
                                    <td><i class="layui-icon layui-icon-log"> 10:40</i></td>
                                    <td><span>在线</span></td>
                                    <td>21 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td><span class="third">靳东</span></td>
                                    <td><i class="layui-icon layui-icon-log"> 01:30</i></td>
                                    <td><i>离线</i></td>
                                    <td>66 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td>吴尊</td>
                                    <td><i class="layui-icon layui-icon-log"> 21:18</i></td>
                                    <td><i>离线</i></td>
                                    <td>45 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td>许上进</td>
                                    <td><i class="layui-icon layui-icon-log"> 09:30</i></td>
                                    <td><span>在线</span></td>
                                    <td>21 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td>小蚊子</td>
                                    <td><i class="layui-icon layui-icon-log"> 21:18</i></td>
                                    <td><i>在线</i></td>
                                    <td>45 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                <tr>
                                    <td>贤心</td>
                                    <td><i class="layui-icon layui-icon-log"> 09:30</i></td>
                                    <td><span>在线</span></td>
                                    <td>21 <i class="layui-icon layui-icon-praise"></i></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="layui-col-sm6">
                    <div class="layui-card">
                        <div class="layui-card-header">项目进展</div>
                        <div class="layui-card-body">
                            <div class="layui-tab-content">
                                <div class="layui-tab-item layui-show">
                                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                                        <thead>
                                        <tr>
                                            <th>任务</th>
                                            <th>所需时间</th>
                                            <th>完成情况</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>开会</td>
                                            <td>一小时</td>
                                            <td style="color: #5FB878;">已完成</td>
                                        </tr>
                                        <tr>
                                            <td>开会</td>
                                            <td>二小时</td>
                                            <td style="color: #FFB800;">进行中</td>
                                        </tr>
                                        <tr>
                                            <td>开会</td>
                                            <td>三小时</td>
                                            <td style="color: #FF5722;">未完成</td>
                                        </tr>
                                        <tr>
                                            <td>开会</td>
                                            <td>四小时</td>
                                            <td style="color: #FF5722;">未完成</td>
                                        </tr>
                                        <tr>
                                            <td>开会</td>
                                            <td>五小时</td>
                                            <td style="color: #FF5722;">未完成</td>
                                        </tr>
                                        <tr>
                                            <td>开会</td>
                                            <td>六小时</td>
                                            <td style="color: #FF5722;">未完成</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-sm12">
                    <div class="layui-card">
                        <div class="layui-card-header">用户全国分布</div>
                        <div class="layui-card-body">
                            <div class="layui-row layui-col-space15">
                                <div class="layui-col-sm4">
                                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                                        <thead>
                                        <tr>
                                            <th>排名</th>
                                            <th>地区</th>
                                            <th>人数</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>浙江</td>
                                            <td>62310</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>上海</td>
                                            <td>59190</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>广东</td>
                                            <td>55891</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>北京</td>
                                            <td>51919</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>山东</td>
                                            <td>39231</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>湖北</td>
                                            <td>37109</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="layui-col-sm8">

                                    <div class="layui-carousel layadmin-carousel layadmin-dataview"
                                         data-anim="fade" lay-filter="LAY-index-pagethree">
                                        <div carousel-item id="LAY-index-pagethree">
                                            <div style="display: block !important;" class="" id="erchart2" style="width: 400px"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<script src="/admin/lib/layui/layui.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script>
    layui.use(['carousel','element','table','jquery','layer'], function() {
        var carousel = layui.carousel;
        var element = layui.element;
        var table = layui.table;
        var $ = layui.$;
        var layer = layui.layer;

        carousel.render({
            elem: '#test3'
            ,width: '100%' //设置容器宽度
            ,index:0
            ,autoplay:false
            ,arrow:'none'
            ,anim:'fade'
        });

        $('.layuiadmin-reply').click(function(){
            layer.prompt({title: '回复留言', formType: 2}, function(pass, index){
                layer.close(index);
            });
        });
    });

    var dom1 = document.getElementById("erchart1");
    var dom2 = document.getElementById("erchart2");
    var myChart1 = echarts.init(dom1);
    var myChart2 = echarts.init(dom2);

    option2 = option1 = {
        title: {
            text: "今日流量趋势",
            x: "center",
            textStyle: {
                fontSize: 14
            }
        },
        tooltip: {
            trigger: "axis"
        },
        legend: {
            data: ["", ""]
        },
        xAxis: [{
            type: "category",
            boundaryGap: !1,
            data: ["06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "11:30", "12:00",
                "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
                "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"]
        }],
        yAxis: [{
            type: "value"
        }],
        series: [{
            name: "PV",
            type: "line",
            smooth: !0,
            itemStyle: {
                normal: {
                    areaStyle: {
                        type: "default"
                    }
                }
            },
            data: [111, 222, 333, 444, 555, 666, 3333, 33333, 55555, 66666, 33333, 3333, 6666, 11888, 26666, 38888,
                56666, 42222, 39999, 28888, 17777, 9666, 6555, 5555, 3333, 2222, 3111, 6999, 5888, 2777, 1666, 999, 888, 777]
        }, {
            name: "UV",
            type: "line",
            smooth: !0,
            itemStyle: {
                normal: {
                    areaStyle: {
                        type: "default"
                    }
                }
            },
            data: [11, 22, 33, 44, 55, 66, 333, 3333, 5555, 12666, 3333, 333, 666, 1188, 2666, 3888, 6666, 4222, 3999,
                2888, 1777, 966, 655, 555, 333, 222, 311, 699, 588, 277, 166, 99, 88, 77]
        }
        ]
    };

    myChart1.setOption(option1, true);
    myChart2.setOption(option2, true);
</script>
</body>
</html>