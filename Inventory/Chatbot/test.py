import requests

BOT_TOKEN = '802083598:AAGjP_dYZqUsY5GlTDsOd_hTX0DLkixGdpM'
CHAT_ID = '-4680298404'
MESSAGE = 'Hello from your bot!'

url = f"https://api.telegram.org/bot{BOT_TOKEN}/sendMessage"
payload = {'chat_id': CHAT_ID, 'text': MESSAGE}

response = requests.post(url, data=payload)
print(response.json())






# @bot.message_handler(func=lambda message: True)
# def instant_reply(message):
#     try:
#         query = message.text.lower()

#         if "send image" in query:
#             with open("path/to/your/image.jpg", "rb") as photo:
#                 bot.send_photo(message.chat.id, photo, caption="Here’s your image!")
#         else:
#             response = showData.finalOutput(query)
#             bot.reply_to(message, response)

#     except Exception as e:
#         print(f"Error: {e}")