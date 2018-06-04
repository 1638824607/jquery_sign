# encoding:utf-8
# http://www.jq22.com/ jquery插件库登陆签到

import requests
import time
import sys
import smtplib
from email.mime.text import MIMEText
from bs4 import BeautifulSoup

try:
    import cookielib
except:
    import http.cookiejar as cookielib


class JquerySign():
    def __init__(self):
        # 登陆界面url
        self.loginUrl = 'http://www.jq22.com/'

        # 登陆表单提交url
        self.posturl = 'http://www.jq22.com/emdl.aspx'

        # 签到表单页面url
        self.signHtmlUrl = 'http://www.jq22.com/signIn.aspx'

        # 签到表单提交url
        self.signUrl = 'http://www.jq22.com/signIn.aspx'

        # 签到网站名称
        self.signWebsiteName = 'jquery插件库'

        # 网站账号密码
        self.username = '1638824607@qq.com'
        self.userpass = 'shenruxiang123'

        # 设置请求头
        self.headers = {
            'Referer': 'http://www.jq22.com/',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) '
                          'Chrome/66.0.3359.181 Safari/537.36',
            'Host': 'www.jq22.com',
            'Origin': 'http://www.jq22.com',
        }

        self.home_headers = {
            'Host': 'www.jq22.com',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) '
                          'Chrome/66.0.3359.181 Safari/537.36'
        }

        # 设置session
        self.session = requests.session()

        # 生成cookie
        self.session.cookies = cookielib.LWPCookieJar(filename='jquery_cookie')

    def get_token(self):
        
        self.load_cookie()

    def set_token(self):
        self.session.cookies.save()

    def load_cookie(self):
        self.session.cookies.load(ignore_discard=True)

    def post_account(self, username, userpass):

        post_data = {
            'em': username,
            'pw': userpass
        }

        self.session.post(self.posturl, data=post_data, headers=self.headers)

        self.set_token()

    def sign_action(self):

        sing_get_response = self.session.get(self.signHtmlUrl, headers=self.headers)

        soup = BeautifulSoup(sing_get_response.text, 'lxml')

        viewstate = soup.find(id='__VIEWSTATE')['value']
        viewstate_generator = soup.find(id='__VIEWSTATEGENERATOR')['value']
        event_valid_ation = soup.find(id='__EVENTVALIDATION')['value']
        sianin_name = soup.find(id='Button1')['value']

        sign_post_data = {
            '__VIEWSTATE': viewstate,
            '__VIEWSTATEGENERATOR': viewstate_generator,
            '__EVENTVALIDATION': event_valid_ation,
            'Button1': sianin_name
        }

        sign_post_response = self.session.post(self.signUrl, data=sign_post_data, headers=self.headers)

        soup = BeautifulSoup(sign_post_response.text, 'lxml')

        signin_status_name = soup.find(id='Button1')['value']

        # 获取当前时间
        now_time = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())

        email_message = '%s %s %s' % (self.signWebsiteName, signin_status_name.strip(), now_time)

        return email_message

    def send_email_me(self, email_message):

        mail_host = 'smtp.qq.com'
        mail_port = 465

        mail_from = '1638824607@qq.com'
        mail_to = '1638824607@qq.com'

        mail_password = 'xwoobmsgiutcbiah'

        subject = email_message
        content = email_message

        msg = MIMEText(content, 'text', 'utf-8')

        msg['Subject'] = subject
        msg['From'] = mail_from
        msg['To'] = mail_to

        try:
            s = smtplib.SMTP_SSL(mail_host, mail_port)

            s.login(mail_from, mail_password)
            s.sendmail(mail_from, mail_to, msg.as_string())

            print(email_message)
        except:

            print('发送失败')

    def jquery_sign(self):

        # 登陆
        self.post_account(self.username, self.userpass)

        time.sleep(2)

        # 加载cookie
        self.get_token()

        # 签到
        email_message = self.sign_action()

        # 发送邮件
        self.send_email_me(email_message)


if __name__ == "__main__":
    default_encoding = 'utf8'

    # 防止ascii解析错误
    if sys.getdefaultencoding() != default_encoding:
        reload(sys)
        sys.setdefaultencoding(default_encoding)

    jquery = JquerySign()

    # jquery签到
    jquery.jquery_sign()