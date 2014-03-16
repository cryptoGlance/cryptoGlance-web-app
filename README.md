<br>

_[Skip to FAQ](#faq)_ &bull; <a href="http://cryptoglance.info/" rel="external">http://cryptoglance.info/</a>

----

## What is CryptoGlance?

Self-hosted, PHP-based frontend interface for cgminer, MPOS pools, and other APIs, all in one responsive UI. Protected with a login, but also offers a read-only/public view (if desired).

## Features:

- Add multiple rigs which display data from cgminer
- Add multiple pools to watch that support MPOS frontends (ask your pool op if you're unsure, or look in their site's footer)
- Mobile optimized design
- Customizable via:
 - Add/Remove/Edit Panels and move them around
 - Collapse or Expand panels
 - Drag n' drop certain stat-pairs to the position you prefer
 - These preferences are saved to a local browser cookie (for now)
- Monitor RSS feeds and Subreddits
- Create exchange/conversion rate pairs that display fresh data
- Add your addresses to keep on top of their current balance (determined from the public blockchain)

## Requirements:

- PHP v5.2+
- Apache or IIS
- cgminer / bfgminer / cudaminer / sgminer with API access allowed
- MPOS Mining Pool account with your API key (for certain pool stats -- ask your pool operatir)

## Installation:

#### How-to Video:

[![IMAGE ALT TEXT HERE](http://img.youtube.com/vi/YOUTUBE_VIDEO_ID_HERE/0.jpg)](http://www.youtube.com/watch?v=YOUTUBE_VIDEO_ID_HERE)

#### Step-by-step Instructions:

**Advanced Users:** Simply setup a new PHP instance and point it to the root folder of the CryptoGlance source/download. Ensure that the **php_sockets** extension is enabled, and you should be good to go.

**Beginner Users:**

1. Install (if required) a web server such as Apache or Microsoft IIS. 
  1. If you're running Windows, and have neither IIS nor PHP installed, there is a simple tool from Microsoft called [Web Platform Installer](http://www.microsoft.com/web/downloads/platform.aspx) that can do this painlessly. 
  1. Windows/IIS users may also need to add the '.woff' MIME type, which has a value of 'application/font-woff'

2. Setup a new site and point the home/root directory to this project. 

You'll want to ensure you're running cgminer with API-Access enabled, here's an example excerpt from the .conf:

    ...
    "api-allow" : "127.0.0.1,192.168.1.0/24",
    "api-listen" : true,
    "api-mcast-port" : "4028",
    "api-port" : "4028",
    ...

<a name="faq"></a>

...and you should be good to go. 

FAQ:
--
**Q. I am (understandably) careful with my crypto-currency. Can I trust CryptoGlance?**

A. Most definitely! The code is completely open source, and you run CryptoGlance on your own web server. No private keys are requested, nor passwords stored, with exception to API keys, but they are excluded from source.

---

**Q. How do I backup my CryptoGlance settings?**

A. Just look for the /user_data folder, and copy that somewhere safe.

---

**Q. I cannot get CryptoGlance to run. What can I check?**

A. Getting CryptoGlance setup requires a tiny bit of knowledge relating to web servers that host PHP sites. Most often you can search for any specific errors you see, or try the following:

- Ensure that the **php_sockets** extension is loaded via **php.ini**
- Configure any firewalls/anti-virus to allow for your web server traffic (usually port 80)
- Confirm that PHP is installed and working properly
- Adjust any permissions which will allow for write access to the /user_data folder  

---

**Q. The CryptoGlance site loads, but no data or stats are displayed. Why?**

A. Your mining utility (cgminer / bfgminer / cudaminer / etc.) requires that API access is allowed. Please see the installation section above for the proper settings to use in your .conf or .bat files.

---

**Q. Why is my wallet balance 0?**

A. Double-check that you've entered information accurately. Note that CryptoGlance will never ask for private keys or any other sensitive information.

## We owe thanks to the following projects:

- [WebhostingHub Glyphs](http://www.webhostinghub.com/glyphs/)
- [PHP Markdown by Michel Fortin](http://michelf.ca/projects/php-markdown/)
- [Flat icon social media by Guilherme Spigolan](https://www.iconfinder.com/search/?q=iconset%3Aflat-icon-social-media)
- [(elements of) PHPMailer](https://github.com/PHPMailer/PHPMailer)

Hope you enjoy what we're trying to do here, and thanks to all of the other similar OSS projects like this for help and inspiration (we give extra special thanks to **Anubis** for that!).

## Our Donation Addresses:

We've put a lot of our time and effort into CryptoGlance, and it hasn't been easy. We also wanted to make this tool free to everyone, however donations keep our fire lit, and more features/improvements coming out. If you like what we've built, or at least appreciate our efforts, please send a donation to any of the following addresses:

**Bitcoin** == 12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE

**Litecoin** == LKUceKGBJwcmL4uVykL9CzKjmEqo6Fcx9M

**Vertcoin** == Vp9izfX1kM3BqGADtvan1Et5nBiU1s32Zp

**Dogecoin** == D8bcNHYbkBDqwkvZKKpfu8oAyzqezJ5RvW 

/*end README.md*