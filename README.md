# php-kofi-api-integration
This is a simple PHP "plugin" system, composed of two parts:
- The main index.php file
- The send-discord.php file

The main file includes the logic for verifying an API POST came from Ko-Fi's API itself, as well as 'decoding' the JSON payload, and assigning the various values to individual variables, that you can then use for whatever further processing you would like to do.
- You need to put your own verification token value at the top of the file, where indicated, otherwise this plugin will NOT work for you properly.
- You will need to ensure that your API setting on your Ko-Fi dashboard, is set to the location that the main file from this plugin, is located at.

The discord file is optional, and only needed if you plan to activate the option to send notifications to a webhook endpoint in your Discord server.
- You will need to create a webhook in whatever channel you would like, on Discord
- Change the 'false' to 'true' under the setting at the top of the main file (enable discord sending)
- Replace the default example webhook address with your own.

If you need help, you can get in touch with me on Discord, under the account ModVault#0001

---
Do you like the plugin, and wish to donate?

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/Y8Y7653RW)
