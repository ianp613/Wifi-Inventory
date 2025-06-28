import requests

class TelegramBot:
    def __init__(self):
        self.API= "8020836598:AAGjP_dYZqUsY5GlTDsOd_hTX0DLkixGdpM"
        self.CHAT_ID= "-4680298404"

    def notifyMe(self,message):
        try:
            # URL= f"https://api.telegram.org/bot{API}/getUpdates"
            # print(requests.get(URL).json())
            message= message
            URL= f"https://api.telegram.org/bot{self.API}/sendMessage?chat_id={self.CHAT_ID}&text={message}"
            requests.get(URL)
        except Exception as e:
            print(e)
