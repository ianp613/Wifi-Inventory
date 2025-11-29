import logging
import json
import os
import time

# Disable INFO logs from httpx and telegram
logging.getLogger("httpx").setLevel(logging.CRITICAL)
logging.getLogger("telegram.ext").setLevel(logging.CRITICAL)
logging.getLogger("telegram").setLevel(logging.CRITICAL)

from telegram import Update
from telegram.ext import ApplicationBuilder, MessageHandler, ContextTypes, filters
import logging
import sole  # Your custom business logic module

# Bot config
BOT_TOKEN = "8245644441:AAHo9Lp5rYPxdFUk7QCRX7IQrRipi1Cn3yM"
GROUP_CHAT_ID = -1003306655092
MAX_LENGTH = 3000  # Telegram's message size limit

# 🧩 Log setup
logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO
)

# 📦 Message splitter for long replies
def split_message(text):
    return [text[i:i+MAX_LENGTH] for i in range(0, len(text), MAX_LENGTH)]

# 🎯 Main message reply handler
async def reply(update: Update, context: ContextTypes.DEFAULT_TYPE):
    if update.effective_chat.id == GROUP_CHAT_ID:
        try:
            user_message = update.message.text
            bot_reply = sole.index(user_message)

            try:
                # Try to parse as JSON
                parsed = json.loads(bot_reply)

                if isinstance(parsed, list):
                    # It's an array from PHP
                    print("It's an array from PHP")
                    if parsed[0] == "string":
                        for part in split_message(parsed[1]):
                            await update.message.reply_text(part)
                            # await update.message.reply_text(part)
                else:
                    # It's a JSON string or object, not an array
                    print("It's a JSON string or object, not an array")
                    await update.message.reply_text(str(parsed))

            except json.JSONDecodeError:
                # Not JSON — treat as plain string
                await update.message.reply_text(bot_reply)


        except Exception as e:
            logging.error("Error in reply(): %s", str(e), exc_info=True)
            try:
                await update.message.reply_text("⚠️ Something went wrong while processing your request. [python]")
            except:
                pass  # Prevent bot from crashing if reply fails

# ❗ Global error handler
async def error_handler(update: object, context: ContextTypes.DEFAULT_TYPE):
    logging.error("Exception while handling update:", exc_info=context.error)

    # Attempt to notify the user if possible
    if isinstance(update, Update) and update.message:
        try:
            await update.message.reply_text("⚠️ Bot encountered an error. Please try again later. [python]")
        except:
            pass

# 🛎️ Entry point
if __name__ == "__main__":
    app = ApplicationBuilder().token(BOT_TOKEN).build()

    # Add message handler (ignores commands)
    app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, reply))

    # Register error handler
    app.add_error_handler(error_handler)

    print("Unifi Wifi Bot is running ...")
    print("Do not close this window ...")
    app.run_polling()