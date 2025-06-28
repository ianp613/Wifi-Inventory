import subprocess
import sys
import nltk
import time

try:
    def install_packages(packages):
        """Installs the given list of packages using pip."""
        for package in packages:
            subprocess.run([sys.executable, "-m", "pip", "install", "--upgrade", package])

    # Example usage: Add package names to install
    packages_to_install = ["requests", "pyTelegramBotAPI","mysql-connector-python","nltk"]
    install_packages(packages_to_install)
    print("\n\nPreparing to download nltk punkt and average perceptron tagger...")
    time.sleep(3)
    nltk.download('punkt')
    print("\nDone Downloading nltk punkt")
    time.sleep(2)
    nltk.download('averaged_perceptron_tagger')
    print("\nDone Downloading nltk average perceptron tagger")
    time.sleep(3)
except Exception as e:
    print(e)

