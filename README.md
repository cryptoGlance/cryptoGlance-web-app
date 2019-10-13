# CRYPTOGLANCE HAS BEEN ARCHIVED

### The Git repository will be left accessible in a read-only, archived state.

----

<img src="images/cryptoGlance-thread-header.png" alt="cryptoGlance" />

### What is cryptoGlance?

cryptoGlance is an open-source, self-hosted PHP webapp providing you with a glance at all of your crypto-currency components in one spot. Designed for large and small screens, you can easily monitor and control many aspects of your crypto/mining devices.

### Features:

<ul>
  <li>Standalone version with installer (for Windows), or run the source code within your own (PHP) web server environment</li>
  <li>Responsive, mobile-friendly interface</li>
  <li>Real-time information display (no refresh needed)</li>
  <li>Secure login system</li>
  <li>Obtains valid data directly from cgminer/sgminer</li>
  <li>Rigs/ASICs
    <ul>
      <li>Monitors detailed statistics, and manages core functions of multiple rigs/ASICs</li>
      <li>Switch pools and restart miners remotely</li>
    </ul>
  </li>
  <li>Pools
    <ul>
      <li>Actively track pool stats (MPOS and selective pools supported)</li>
    </ul>
  </li>
  <li>Wallets/Balances
    <ul>
      <li>"Wallets" in cryptoGlance are basically collections of public addresses that you wish to check the balance of</li>
      <li>You can create multiple wallets which will sum up the total balances of all addresses belonging</li>
      <li>Multiple coin types are supported, with more being added regularly</li>
    </ul>
  </li>
  <li>Updates:
    <ul>
      <li>Notification alerts</li>
      <li>Automatic updating from within cryptoGlance</li>
      <li>Select your release type preference</li>
    </ul>
  </li>
  <li>Configurable warning and danger status with visual cues</li>
  <li>Void of malware or donation mining (does <strong>NOT</strong> require your private keys at all -- code is open source!)</li>
</ul>

### **NEW** v2.0 Changes:
<ul>
  <li>Total Hashrates are now categorized by Rig Algorithms used</li>
  <li>Enable/Disable Total Hashrate via Tools dropdown</li>
  <li>New ability to edit Rigs and Pools</li>
  <li>Re-amped Rig summary and device details (percentages, etc)</li>
  <li>New Rig Details</li>
  <li>Cleaner interface</li>
  <li>Ability to drag+drop pool priority for a rig</li>
  <li>Auto-Restart on BITMAIN ASIC failure (chain contains "x" instead of "0")</li>
  <li>Rig devices have two more types of details showing:
    <ul>
      <li>BITMAIN ASIC fan speed (fan 1, fan 2, fan 3, etc)</li>
      <li>BITMAIN ASIC temperatures (temperature 1, temperature 2, temperature 3, etc)</li>
    </ul>
  </li>
  <li>Rigs have a new option for Algorithm</li>
  <li>Rigs Algorithm is auto-set when using sgMiner v5+</li>
  <li>Ability to reset rig stats</li>
  <li>Ability to reset rig stats on pool change</li>
  <li>New FIAT conversions for most coins (Thanks to FunkyC: <a href="https://firstrally.com/" rel="external">https://firstrally.com/</a>)</li>
  <li>New debug command to see raw miner data: CTRL + D</li>
  <li>[+POOL] Bitcoin Affiliate Network (<a href="http://mining.bitcoinaffiliatenetwork.com/" rel="external">http://mining.bitcoinaffiliatenetwork.com</a>)</li>
  <li>[+POOL] CkPool</li>
  <li>[+POOL] Eligius</li>
  <li>[+POOL] MagicPool</li>
  <li>[+POOL] Multipool.Us</li>
  <li>[+POOL] NOMP</li>
  <li>[+COIN] NeosCoin</li>
  <li>[+COIN] ReddCoin</li>
  <li>[+COIN] PayCoin</li>
</ul>

---

## Requirements:

- cgminer / sgminer properly configured with API access allowed

*Windows Version:*

- Windows XP or newer

*Running from source:*

- PHP v5.2+
- Apache / IIS / mongoose, or whichever web server you prefer
- php_sockets extension enabled in PHP

---

## Installation:

_**Advanced Users:**_

Simply setup a new PHP instance and point it to the root folder of the <a href="https://github.com/cryptoGlance/cryptoGlance-web-app" rel="external">cryptoGlance source/download</a>. Ensure that the **php_sockets** extension is enabled in **php.ini**, grant write access to the **/user_data** folder, and you should be good to go.

_**Linux Users:**_

1. Note that a few php/supporting packages must be installed prior to using cryptoGlance. We've created a simple script that will install them for you, or feel free to run the steps yourself by examining the **install-linux-dependencies.sh** file.

_**Windows App Users:**_

1. <a href="https://sourceforge.net/projects/cryptoglance/files/latest/download" rel="external">Download the latest version of cryptoGlance</a> and run the setup executable to begin installation.

2. Read the information that appears in the installer carefully.

3. Choose your installation directory. **NOTE** - if you wish to install within <b>C:\Program Files (x86)\</b>, you will need to run cryptoGlance as an Administrator, since this is required for applications to write within that system directory. cryptoGlance creates a /user_data/ directory with your settings, and also writes new files here. This is why the default installation directory is *C:\cryptoGlance*.

4. **OPTIONAL** - If you wish to access cryptoGlance from other devices, you'll need to edit the **{{install_dir}}/settings.json** file. Change line 30 to use your 192.168.x.x address, similar to:

```
    "listen_on": ["192.168.1.20", 4041],
```

---

## Upgrading:

Upgrading cryptoGlance is easy.  First off, it never hurts to make a backup copy of your entire cryptoGlance folder. Files that should be kept particularly safe are:

- **/user_data** folder

Next, you'll need to **Enable cryptoGlance Updates** on the Settings page. Then, choose your release type:

- **Release:** Stable code, should have very few bugs/issues (if any).
- **Beta:** Slightly experimental for testing new features and bug-fixes.
- **Nightly:** Bleeding-edge code commits, will most likely have bugs, but they shouldn't be very serious.


_**Windows App:**_

Since the Windows App works a bit differently, in the sense that it has its own webserver with PHP installed and configured, updates aren't usually frequent, and separate from the main release version numbers. However, if you do use the Windows App, it may be a good idea to <a href="https://sourceforge.net/projects/cryptoglance/files/latest/download" rel="external">check for the latest version on SourceForge</a> from time to time. Simply install the program to the same directory. Your /user_data folder will not be overwritten.

If you've made edits to `{{ install-dir }}\settings.json` (optional modification for accessing cryptoGlance externally on other devices), then you'll need to re-apply them after the installation finishes.

---

## FAQ:

**Q. What is the difference between the Windows and Source downloads?**

**A.** The **Windows Version** is a pre-packaged solution which allows cryptoGlance to run under its own PHP web server (Mongoose), without the need to setup any external apps/services. This version is recommended for Windows users who are not familiar with server configuration.

The **Run from Source** version is for users who know how to setup a (simple) PHP site. An ideal use of this version is to **clone the repo** from Github to a virtual directory that is served by your choice application (Apache, IIS, etc.). This method allows you to update quite easily, and also prepare code that can be contributed back to the project via a pull request.

---

**Q. I am (understandably) careful with my crypto-currency. Can I trust cryptoGlance?**

**A.** Most definitely! The code is completely open source, and you run cryptoGlance on your own web server (even the Windows version). There's no calls to home, or anything of the sort. No private keys are requested, passwords (stored as salted hashes) and API keys are within a protected **/user_data** directory, excluded from source.

---

**Q. How do I backup my cryptoGlance settings?**

**A.** Just look for the **/user_data** folder in the following locations, and copy it somewhere safe:

- **{{ project-root }}/user_data**
- _**Windows App** users need to backup **{{ install-dir }}\application\user_data** and **{{ install-dir }}\settings.json** (optional modification for accessing cryptoGlance externally on other devices)_

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
- (Linux) Ensure that you have the following packages installed:
 - apache2
 - php5
 - libapache2-mod-php5
 - php5-json
 - php5-curl
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

### We owe thanks to the following projects:

- [WebhostingHub Glyphs](http://www.webhostinghub.com/glyphs/)
- [Flat icon social media by Guilherme Spigolan](https://www.iconfinder.com/search/?q=iconset%3Aflat-icon-social-media)
- [PHP Desktop](http://code.google.com/p/phpdesktop/)
- [PHP Markdown by Michel Fortin](http://michelf.ca/projects/php-markdown/)
- [(elements of) PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [Bootstrap CSS Framework](http://getbootstrap.com)

Hope you enjoy what we're trying to do here, and thanks to all of the other similar OSS projects like this for help and inspiration (we give extra special thanks to **Anubis** for that!).

---

/*end README.md*
