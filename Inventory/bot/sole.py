import requests

def index(user_message: str) -> str:
    try:
        url = "http://192.168.15.221:8052/controllers/telegram_bot/main.php"  # Replace with your actual PHP URL
        payload = {'message': user_message}
        response = requests.post(url, data=payload)
        return response.text
    except Exception as e:
        return f"Error contacting Wifi Team Inventory Server: {e} [python]"