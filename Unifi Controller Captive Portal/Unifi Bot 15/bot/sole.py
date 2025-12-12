import requests
import json
import os

def load_config():
    try:
        # Adjust the path if needed
        config_path = os.path.join(os.path.dirname(__file__), 'config.json')
        with open(config_path, 'r') as f:
            config = json.load(f)
        return config.get('bot_host'), config.get('bot_port')
    except Exception as e:
        raise RuntimeError(f"Failed to load config.json: {e}")

def index(user_message: str) -> str:
    try:
        bot_host, bot_port = load_config()
        url = f"http://{bot_host}:{bot_port}/controllers/main.php"
        payload = {'message': user_message}
        response = requests.post(url, json=payload)
        return response.text
    except Exception as e:
        return f"Error contacting Unifi Server: {e} [python]"