<br>
_[Skip to FAQs](#faq)_ &bull; <a href="http://cryptoglance.info/" rel="external">http://cryptoglance.info</a>

----

<img src="images/cryptoGlance-thread-header.png" alt="cryptoGlance" />

### What is cryptoGlance?

cryptoGlance is an open-source, self-hosted PHP webapp providing you with a glance at all of your crypto-currency components in one spot. Designed for large and small screens, you can easily monitor and control many aspects of your crypto/mining devices. There's also an <a href="https://play.google.com/store/apps/details?id=com.scar45.cryptoGlance" rel="external">Android companion app</a> which connects to your cryptoGlance installation remotely.

### Features:

<ul>
  <li>Standalone version with installer (for Windows), or run the source code within your own (PHP) web server environment</li>
  <li>Obtains valid data directly from cgminer/sgminer</li>
  <li>Monitors detailed statistics, and manages core functions of multiple rigs/ASICs</li>
  <li>Switch pools and restart miners remotely</li>
  <li>Actively track pool stats and crypto address balances (MPOS and selective pools supported)</li>
  <li>Responsive, mobile-friendly interface</li>
  <li>Realtime information display (no refresh needed)</li>
  <li>Secure login system</li>
  <li>Configurable warning and danger status with visual cues</li>
  <li>Create 'wallets' that are collections of your selected coin addresses, and display the balance</li>
  <li>Void of malware or donation mining (does <strong>NOT</strong> require your private keys at all)</li>
  <li>Companion <a href="https://play.google.com/store/apps/details?id=com.scar45.cryptoGlance" rel="external">Android app</a> which easily allows you to quickly access your cryptoGlance instance while on the go</li>
  <li><strong>MUCH MORE is planned!</strong> Follow our social accounts, or drop by our IRC channel to find out when new features are released!</li>
</ul>

### Video Demo:

<a href="http://www.youtube.com/watch?v=MZF1ZasbT58" rel="external"><img src="images/cryptoGlance-video-intro-landscape.png" alt="cryptoGlance Video Thumb" /></a>

### Requirements:

- cgminer / sgminer properly configured with API access allowed

*Windows Version:* 

- Windows XP or newer

*Running from source:* 

- PHP v5.2+
- Apache / IIS / mongoose, or whichever web server you prefer
- php_sockets extension enabled in PHP

--- 

### Installation:

**Advanced Users:** Simply setup a new PHP instance and point it to the root folder of the cryptoGlance source/download. Ensure that the **php_sockets** extension is enabled in **php.ini**, grant write access to the **/user_data** folder, and you should be good to go.

**Windows App Users:**

1. <a href="https://sourceforge.net/projects/cryptoglance/files/latest/download" rel="external">Download the latest version of cryptoGlance</a> and run the setup executable to begin installation.

2. Read the information that appears in the installer carefully.

3. Choose your installation directory. **NOTE** - if you wish to install within <b>C:\Program Files (x86)\</b>, you will need to run cryptoGlance as an Administrator, since this is required for applications to write within that system directory. cryptoGlance creates a /user_data/ directory with your settings, and also writes new files here. This is why the default installation directory is *C:\cryptoGlance*.

4. **OPTIONAL** - If you wish to access cryptoGlance from other devices, you'll need to edit the **{{install_dir}}/settings.json** file. Change line 30 to use your 192.168.x.x address, similar to:

<br>

    "listen_on": ["192.168.1.20", 4041],

...and you should be good to go. 

---

### Upgrading:

Upgrading is easy. 

*Windows Version:* 

- First off, it never hurts to make a backup copy of your entire cryptoGlance folder. Files that should be kept safe are:
 - **/user_data** folder
 - **{{ install-dir }}\settings.json** (optional modification for accessing cryptoGlance externally on other devices)
- Simply <a href="https://sourceforge.net/projects/cryptoglance/files/latest/download" rel="external">download the latest version</a>, and install the program to the same directory. Your **/user_data** folder will not be overwritten
- If you've made an edit  need to re-edit the **{{ install-dir }}/settings.json** file.

*Running from source:* 

- Either run a **git pull** if you've cloned the repo, or simply overwrite all files from the latest zip download on Github.

<a name="faq"></a>

---

### FAQ:

**Q. What is the difference between the Windows and Source downloads?**

**A.** The **Windows Version** is a pre-packaged solution which allows cryptoGlance to run under its own PHP web server (Mongoose), without the need to setup any external apps/services. This version is recommended for Windows users who are not familiar with server configuration.

The **Run from Source** version is for users who know how to setup a (simple) PHP site. An ideal use of this version is to **clone the repo** from Github to a virtual directory that is served by your choice application (Apache, IIS, etc.). This method allows you to update quite easily, and also prepare code that can be contributed back to the project via a pull request.

---

**Q. I am (understandably) careful with my crypto-currency. Can I trust cryptoGlance?**

**A.** Most definitely! The code is completely open source, and you run cryptoGlance on your own web server (even the Windows version). There's no calls to home, or anything of the sort. No private keys are requested, passwords (stored as salted hashes) and API keys are within a protected **/user_data** directory, excluded from source.

---

**Q. How do I backup my cryptoGlance settings?**

**A.** Just look for the **/user_data** folder in the following locations, and copy it somewhere safe:

*Windows Version:* 

- **{{ install-dir }}\application\user_data**

*Running from source:* 

- **{{ project-root }}/user_data**

---

**Q. I cannot get cryptoGlance to run. What can I check?**

**A.** The Windows version should work quite well out of the box, but getting cryptoGlance setup under your own web server requires a bit of knowledge. Most often times, you can search for any specific errors you see, or try the following:

*Windows Version:*

- Configure any firewalls/anti-virus to allow cryptoGlance.exe traffic through
- Note the default port for the Windows app is **4041**. If you are configuring cryptoGlance to be externally accessible, you'll need to forward port **4041** to the IP of the Windows box running it, or change the port via the app's config file here:
 - **{{ install-dir }}\settings.json**
 - Simply open it in a text editor, and search for **"listen_on": ["127.0.0.1", 4041]**
- Investigate the **{{ cG Install Dir }}\debug.log** file for traces of errors

*Running from source:*

- Confirm that PHP is installed and working properly
- Ensure that the **php_sockets** extension is loaded via **php.ini**
- Adjust permissions to allow for write access on the **/user_data** folder  

---

**Q. The cryptoGlance site loads, but after adding a rig, no data or stats are displayed. Why?**

**A.** Your mining utility (cgminer) requires that API access is allowed. Here's an example excerpt from the .conf:

    ...
    "api-allow" : "127.0.0.1,192.168.1/24",
    "api-listen" : true,
    "api-mcast-port" : "4028",
    "api-port" : "4028",
    ...

---

**Q. Why do certain rig commands not work?**

**A.** Some functions require **API write access** in order to issue commands to the miner. An example of these would be *Switch Pools*, and other such commands that don't simply read data. In order to fix this, open your miner .conf file (or modify your .bat), and ensure that you have a "**W:**" notation before each IP that you wish to grant write access to:

    "api-allow" : "W:127.0.0.1,W:192.168.1/24",

---

**Q. After adding a pool panel, I see a lot of NULL values. What's up?**

**A.** This is most often caused by entering any one of the pool inputs incorrectly. Try removing the panel, and adding it again with accurate information.

---

**Q. Why is my wallet balance 0?**

**A.** Double-check that you've entered your address information accurately. Note that cryptoGlance will never ask for private keys or any other sensitive information.

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

We've put a lot of our time and effort into cryptoGlance, and it hasn't been easy. We also wanted to make this tool free to everyone, however donations keep our fire lit, and more features/improvements coming out. If you like what we've built, or at least appreciate our efforts, please send code, or a donation to any of the following addresses:

**Bitcoin**<br>
<small>12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE</small>

**Litecoin**<br>
<small>LKUceKGBJwcmL4uVykL9CzKjmEqo6Fcx9M</small>

**Vertcoin**<br>
<small>Vp9izfX1kM3BqGADtvan1Et5nBiU1s32Zp</small>

**Dogecoin**<br>
<small>D8bcNHYbkBDqwkvZKKpfu8oAyzqezJ5RvW</small>

---

/*end README.md*