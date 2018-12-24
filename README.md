# Become a Supporter or Donation page

Requirements
PHP 5.0+
MySQL server
The example uses JQuery library version to monitor payment and refresh status on a page.

Setup
1) Deploy files to an internet host. Localhost is not applicable since send a callback to localhost is not possible.

2) Open install.php in a browser.
![Deploy files](https://apirone.com/static/img/supporter_install_small.png "install")

3) Fill callback URL link and database credentials.
In this example, we create Saving or Forwarding wallet. If you enter a Bitcoin address in the optional field you will create a forwarding wallet and all income payments will be immediately forwarded to this wallet.
Keep this field empty If you want to accept all payments without any fee and store your funds in the Saving wallet. See more at API documentation.

4) Click in the Submit button to finish the installation. Then, the script establishes a connection to a database in order to create a table and save file include/settings.php with global variables.

![Main page. Support Bitcoin project.](https://apirone.com/static/img/supporter_main_small.png "Main page. Support Bitcoin project.")

![Bitcoin payment page.](https://apirone.com/static/img/supporter_payment_small.png "Bitcoin payment page.")

![Bitcoin payment done.](https://apirone.com/static/img/supporter_payment_done_small.png "Bitcoin payment done.")


# How does it work?

Installation script creates anonymous Bitcoin wallet: Forwarding or Saving type. Data with wallet ID and transfer key is stored in the settings file.

At the main page, Supporter enters a link to Logotype and site URL. Page send API request with these links to create a new Bitcoin address for payment. This is an unique address for each payment.
Supporter sees the generated address and QR code on the page.

The page automatically checks the database for payment to the address every 3 seconds. As soon as the transaction appeared on the Bitcoin network, our server sends payment info with user data to callback.php. This page saves income data with links to the database.

When the script founds the record with payment info in the database, the QR code changes to an animation with payment done.

After 5 seconds delay, page refresh and Supporter is able to see the placed Logo.

At this example, we finish payment by an unconfirmed transaction. 1x1 pixel of Logo cost 10.000 Satoshi and Logo placed on the page forever. But you can modify scripts as you wish.


Demo page: http://supporter.bitcoinexamples.com/become-a-supporter.php

Work example: https://allprivatekeys.com/become-a-supporter.php

Documentation: https://apirone.com/integrations/become-a-supporter
