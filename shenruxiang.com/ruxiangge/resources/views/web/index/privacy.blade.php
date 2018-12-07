@extends('layouts.web.common')

@section('title', '入香阁-全本小说网')

@section('content')
    <style>
        .container_apk{
            width: 910px;
            margin:0 auto;
            margin-top: 30px;
        }
        .title{
            height: 30px;
            line-height: 30px;
            color:#0d94e2;
            font-size: 20px;
            text-align: right;
        }
        .title img{
            vertical-align: middle;
        }
        .title span{
            display: inline-block;
            width: 100px;
        }
        .update{
            width: 773px;
            padding-right: 15px;
            border-right: 5px solid #79c9f8;
            margin-top: 30px;
            padding-top: 30px;
        }
        .update>li{
            margin-bottom: 30px;
            font-size:16px;
        }
        .detail{
            background: #eeeeee;
            width: 710px;
            padding:10px 20px;
            position: relative;
        }
        .detail li{
            list-style-type: decimal;
            list-style-position: inside;
            font-size: 25px;
            font-weight: bold;
            line-height: 50px;
            color:#414141;
        }
        .circle{
            position: absolute;
            right: -55px;
            width: 20px;
            height:20px;
            border-radius: 100%;
            background: #0d94e2;
            border:5px solid #bee7ff;
        }
        .updateTime{
            position: absolute;
            font-size: 20px;
            font-weight: bold;
            right: -180px;
            color:#0d94e2;
        }
        .arrow{
            position: absolute;
            right: -9px;
            top:17px;
        }
    </style>
    <div class="container_apk ">
        <div class="title">
            <span>入香阁</span>
        </div>
        <ul class="update">
            <li>
                <ul class="detail">
                    <img src="https://res.9kus.com/www_9kus/images/d5.png" alt="" class="arrow">
                    <span class="circle"></span>

                    <span class="updateTime">隐私声明</span>
                    　　隐私权是您的重要权利。向我们提供您的个人信息是基于对我们的信任，相信我们会以负责的态度对待您的个人信息。我们认为您提供的信息只能用于帮助我们为您提供更好的服务。因此，我们制定了网站上个人信息保密制度以保护您的个人信息。我们的个人信息保密制度摘要如下：
                    <br><br>
                    　　1. 不会向任何人出售或借用用户个人信息，除非事先得到用户许可。
                    <br><br>
                    　　2. 当您将自己的个人信息递交给本网站您就自动接受本网站按以下隐私条例所述之目的，存储、使用您的个人信息。您同时也同意放弃就本隐私条例采取任何行动的权利。
                    <br><br>
                    　　3. 关于您的信息本网站收集您的相关信息，目的在于为您提供更优质的产品和服务：如您的昵称、电子邮件。我们不会对外泄露你的个人信息。
                    <br><br>
                    　　4. 本网可能从网站收集特定用途的信息，如网站的总访问量以及访问频率。该数据仅为累计之用，并不涉及到私人信息。
                    <br><br>
                    　　5. 本网网站运用了一种称作"cookies"的技术手段。Cookies是为了保存记录而从网站转送至个人电脑硬盘的信息。这些记录信息使我们得知网站的页面如何、何时被多少人访问。虽然Cookies会识别用户的电脑，但他们不收集个人识别信息。我们并不把Cookies收集到的信息与其他个人识别信息加以综合，以确认你的身份、你的帐号名称或是电子邮件地址。多数浏览器会自动接受COOKIES，但您通常可以改变你的浏览器设置来阻止它。如果您如此操作，您将不能够充分利用我们网站的优点。
                    <br><br>
                    　　6. 在法律规定的情况下，如司法机关、监管机构及其他相关机构需要，本网站有可能提供您的相关信息。
                    <br><br>
                    　　7. 我们也不会将个人信息公诸于众，并会把这些信息存储在安全的操作环境中。
                    <br><br>
                    　　8. 如果我们决定修改我们的隐私条例，我们将会在此页中公布这些调整，以便你能够时刻注意我们所收集到的信息。
                </ul>
            </li>
        </ul>
    </div>

@endsection