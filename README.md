<br>
_[Skip to FAQ](#faq)_ &bull; <a href="http://cryptoglance.info/" rel="external">http://cryptoglance.info</a>

----

### What is CryptoGlance?

Self-hosted, PHP-based frontend interface for cgminer, MPOS pools, and other APIs, all in one responsive UI. Protected with a login, but also offers a read-only/public view (if desired).

### Features:

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

### Video Demo:

<a href="http://www.youtube.com/watch?v=5BBI8icIFuI" rel="external"><img src="images/cryptoGlance-video-intro-landscape.png" alt="cryptoGlance Video Thumb" /></a>

### Requirements:

- PHP v5.2+
- Apache or IIS
- cgminer / bfgminer / cudaminer / sgminer with API access allowed
- MPOS Mining Pool account with your API key (for certain pool stats -- ask your pool operatir)

### Installation:

**Advanced Users:** Simply setup a new PHP instance and point it to the root folder of the cryptoGlance source/download. Ensure that the **php_sockets** extension is enabled in **php.ini**, and you should be good to go.

**Windows App Users:**

1. <a href="https://sourceforge.net/projects/cryptoglance/files/latest/download" rel="external">Download the latest version of cryptoGlance</a> and run the setup executable to begin installation.

2. Read the information that appears in the installer carefully.

3. Choose your installation directory. **NOTE** - if you wish to install within **C:\Program Files (x86)\**, you will need to run cryptoGlance as an Administrator, since this is required for applications to write within Program Files. cryptoGlance creates a /user_data/ directory with your settings, and also writes new files here. This is why the default installation directory is *C:\cryptoGlance*.

4. You'll want to ensure you're running your mining application with API-Access enabled, here's an example excerpt from the .conf:

<br>

    ...
    "api-allow" : "127.0.0.1,192.168.1/24",
    "api-listen" : true,
    "api-mcast-port" : "4028",
    "api-port" : "4028",
    ...

<a name="faq"></a>

...and you should be good to go. 

---

### FAQ:

**Q. What is the difference between the Windows and Source downloads?**

**A.** The **Windows Version** is a pre-packaged solution which allows cryptoGlance to run under its own PHP web server (Mongoose), without the need to setup any external apps/services. This version is recommended for Windows users who are not familiar with server configuration.

The **Run from Source** version is for users who know how to setup a (simple) PHP site. An ideal use of this version is to **clone the repo** from Github to a virtual directory that is served by your choice application (Apache, IIS, etc.). This method allows you to update quite easily, and also prepare code that can be contributed back to the project via a pull request.

---

**Q. I am (understandably) careful with my crypto-currency. Can I trust CryptoGlance?**

**A.** Most definitely! The code is completely open source, and you run CryptoGlance on your own web server (even the Windows version). There's no calls to home, or anything of the sort. No private keys are requested, passwords (stored as salted hashes) and API keys are within a protected **/user_data** directory, excluded from source.

---

**Q. How do I backup my CryptoGlance settings?**

**A.** Just look for the **/user_data** folder in the following locations, and copy it somewhere safe:

*Windows Version:* 

- **{{ cG Install Dir }}\application\user_data**

*Running from source:* 

- **{{ project root }}/user_data**

---

**Q. I cannot get CryptoGlance to run. What can I check?**

**A.** The Windows version should work quite well out of the box, but getting CryptoGlance setup under your own web server requires a bit of knowledge. Most often times, you can search for any specific errors you see, or try the following:

*Windows Version:*

- Configure any firewalls/anti-virus to allow cryptoGlance.exe traffic through
- Note the default port for the Windows app is **4041**. If you are configuring cryptoGlance to be externally accessible, you'll need to forward port **4041** to the IP of the Windows box running it, or change the port via the app's config file here:
 - **{{ cG Install Dir }}\settings.json**
 - Simply open it in a text editor, and search for **"listen_on": ["127.0.0.1", 4041]**
- Investigate the **{{ cG Install Dir }}\debug.log** file for traces of errors

*Running from source:*

- Confirm that PHP is installed and working properly
- Ensure that the **php_sockets** extension is loaded via **php.ini**
- Adjust permissions to allow for write access on the **/user_data** folder  

---

**Q. The CryptoGlance site loads, but after adding a rig, no data or stats are displayed. Why?**

**A.** Your mining utility (cgminer / bfgminer / cudaminer / etc.) requires that API access is allowed. Please see the installation section above for the proper settings to use in your .conf or .bat files.

---

**Q. Why do certain rig commands not work?**

**A.** Some functions require **API write access** in order to issue commands to the miner. An example of these would be *Switch Pools*, and other such commands that don't simply read data. In order to fix this, open your miner .conf file (or modify your .bat), and ensure that you have a "**W:**" notation before each IP that you wish to grant write access to:

    "api-allow" : "W:127.0.0.1,W:192.168.1/24",

---

**Q. Why is my wallet balance 0?**

**A.** Double-check that you've entered your address information accurately. Note that CryptoGlance will never ask for private keys or any other sensitive information.

---

**Q. Can I include cryptoGlance in my custom Linux distribution, or with hardware that I offer?**

**A.** Yes, you may include it **only in non-commercial distributions**. If you wish to include it along with software or hardware that you sell, please get in touch with a channel operator in **#cryptoGlance on Freenode IRC** (use the chat widget on <a href="http://cryptoglance.info/" rel="external">http://cryptoglance.info</a>) to discuss.

---

### We owe thanks to the following projects:

- [WebhostingHub Glyphs](http://www.webhostinghub.com/glyphs/)
- [Flat icon social media by Guilherme Spigolan](https://www.iconfinder.com/search/?q=iconset%3Aflat-icon-social-media)
- [PHP Desktop](http://code.google.com/p/phpdesktop/)
- [PHP Markdown by Michel Fortin](http://michelf.ca/projects/php-markdown/)
- [(elements of) PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [Bootstrap CSS Framework](http://getbootstrap.com)

Hope you enjoy what we're trying to do here, and thanks to all of the other similar OSS projects like this for help and inspiration (we give extra special thanks to **Anubis** for that!).

---

### Our Donation Addresses:

We've put a lot of our time and effort into CryptoGlance, and it hasn't been easy. We also wanted to make this tool free to everyone, however donations keep our fire lit, and more features/improvements coming out. If you like what we've built, or at least appreciate our efforts, please send code, or a donation to any of the following addresses:

**Bitcoin**<br>
12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE

**Litecoin**<br>
LKUceKGBJwcmL4uVykL9CzKjmEqo6Fcx9M

**Vertcoin**<br>
Vp9izfX1kM3BqGADtvan1Et5nBiU1s32Zp

**Dogecoin**<br>
D8bcNHYbkBDqwkvZKKpfu8oAyzqezJ5RvW 

---

/*end README.md*