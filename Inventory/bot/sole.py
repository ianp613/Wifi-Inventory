from vanna.chromadb.chromadb_vector import ChromaDB_VectorStore
from vanna.ollama.ollama_chat import Ollama_Chat
from sqlalchemy import create_engine
import pandas as pd

class MyVanna(ChromaDB_VectorStore, Ollama_Chat):
    def __init__(self):
        ChromaDB_VectorStore.__init__(self)
        Ollama_Chat.__init__(self, config={"model": "mistral"})  # Or "llama3", etc.

# Initialize once (optional: move to global scope if needed)
vn = MyVanna()

# Train with schema (you can load this dynamically or from DB later)
vn.train(ddl="""
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `privileges` varchar(1000) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

# MySQL connection (update your credentials here)
engine = create_engine("mysql+pymysql://root:@localhost:3306/wifi_inventory")
vn.run_sql = lambda sql: pd.read_sql(sql, engine)

# 🧠 Your integrated text-to-sql handler
def index(user_message: str) -> str:
    try:
        sql, df, *_ = vn.ask(user_message)
        response = f"🧠 SQL: {sql}\n📊 Result:\n{df.to_string(index=False)}"
        return response
    except Exception as e:
        return f"⚠️ Error: {str(e)}"