<br>

_[Skip to FAQ](#faq)_ &bull; <a href="http://rigwat.ch" rel="external">http://rigwat.ch</a>

----

What is RigWatch?
--

Self-hosted, PHP-based frontend interface for cgminer, MPOS pools, and other APIs, all in one responsive UI. Protected with a login, but also offers a read-only/public view (if desired).

Features:
--
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

Requirements:
--
- PHP v5.2+
- Apache or IIS
- cgminer (for monitoring rigs)
- MPOS Mining Pool account (many pools support this)
- BTC-e account (for obtaining currency rates)

Planned:
--
- cgminer remote control (write access)
- Read-only version
 - Toggle panels with 'allow on read-only view'
- Streaming feed of Subreddits
- Links to CryptoCurrency resources/news/tuts/etc.

Installation:
--

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

...and you should be good to go. 

<a name="faq"></a>FAQ:
--
Q. I am careful with my crypto-currency. Can I trust RigWatch?

A. Most definitely! The code is completely open source, and you run RigWatch on your own web server.

We owe thanks to the following projects:
--
- [Messenger jQuery plugin](http://github.hubspot.com/messenger/docs/welcome/)

Hope you enjoy what we're trying to do here, and thanks to all of the other similar OSS projects like this for help and inspiration.

Our own measly rigs would appreciate any catalyst donations to **[TODO] WALLET ADDRESS [/TODO] - Thanks in advance!**

