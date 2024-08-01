# ShadowNet

| 🇺🇸 [English](README.md) | 🇮🇷 [Persian](README-FA.md) |
|--------------------------|----------------------------|
<br>

ShadowNet is a data collection tool designed to gather various information from client devices, such as browser history, clipboard content, and webcam images. This project utilizes AES encryption for data security and can send the collected data to a Telegram bot.

## Features

- **AES Encryption**: Protects data during transmission.
- **Cross-Platform**: Works on various operating systems including Windows, Linux, and macOS.
- **Data Collection**: Gathers browser history, clipboard content, and more.
- **Secure Logging**: Logs errors and important events securely.
- **Integration with Telegram**: Sends collected data to a specified Telegram bot.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/clonerdev/ShadowNet.git
   cd ShadowNet
   ```

2. Install dependencies using Composer:
   ```bash
   composer install
   ```

3. Set up environment variables:
   - `TELEGRAM_BOT_TOKEN`: Your Telegram bot token.
   - `REPORT_EMAIL`: Email address for error reporting.
   - `AES_ENCRYPTION_KEY`: A secure key for AES encryption.

## Usage

- Ensure your server is configured to run PHP scripts.
- Deploy the script on a server and access it through a web browser.
- The collected data will be encrypted and sent to the specified Telegram bot.

## Disclaimer

This tool is intended for educational purposes only. Unauthorized use or deployment without user consent may violate privacy laws. Use responsibly and ethically.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.