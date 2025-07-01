from telegram import Update
from telegram.ext import ApplicationBuilder, MessageHandler, filters, ContextTypes
import sole  # Your custom logic lives here

BOT_TOKEN = "7585903473:AAGAuKu6c4kOnNvDB0URwdBt_9gK66uD4HU"
GROUP_CHAT_ID = -1002850193001
MAX_LENGTH = 4096  # Telegram's character limit per message

# Helper function to split long messages
def split_message(text):
    return [text[i:i+MAX_LENGTH] for i in range(0, len(text), MAX_LENGTH)]

# Main handler
async def reply(update: Update, context: ContextTypes.DEFAULT_TYPE):
    if update.effective_chat.id == GROUP_CHAT_ID:
        user_message = update.message.text
        bot_reply = sole.index(user_message)

        for part in split_message(bot_reply):
            await update.message.reply_text(part)

if __name__ == "__main__":
    app = ApplicationBuilder().token(BOT_TOKEN).build()
    app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, reply))
    print("Wifi Team Inventory Bot is running ...")
    print("Do not close this window ...")
    app.run_polling()
