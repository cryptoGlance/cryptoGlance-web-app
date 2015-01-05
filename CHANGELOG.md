
    [ v2.0.0.438-nightly ]

    FEATURES
    ========
    - [+COIN] NeosCoin
    - Added Rig Update Times 1 second and 2 seconds

    HOTFIXES
    ========
    - Updated Toast messages to make notices easier to read

    KNOWN ISSUES
    ========
    - Wallet information creating/editing/deleting is wonky
    - If rig update time > 3 seconds, Rig summary will take an extended amount of time to appear
    - Rig Pools cannot be added/edited/deleted
    - Rig device settings cannot be modified
    - Pool and Wallet information may not load. Requires refresh (f5)

---

    [ v2.0.0.434-nightly ]

    HOTFIXES
    ========
    - Settings Page - clicking App Updates red/green button does not work
    - Changelog ICON changed

---

    [ v2.0.0.432-nightly ]

    FEATURES
    ========
    - Can Enable/Disable Total Hashrate via Tools dropdown

    HOTFIXES
    ========
    - [POOL] MPOS network hashrate was incorrect. API returns deca instead of hecto
    - Navigation dropdowns would close while using elements inside it.

---

    [ v2.0.0.422-nightly ]

    FEATURES
    ========
    - Re-amped Rig summary and device details (percentages, etc)
    - New debug command to see raw miner data: CTRL + D
    - New ability to edit Rigs and Pools
    - New functionality to reset rig stats
    - New functionality to reset rig stats on pool change
    - New FIAT conversions for most coins (Thanks to FunkyC: https://bitcoinindex.es/)
    - Rigs have a new option for Algorithm
    - Rigs Algorithm is auto-set when using sgMiner v5+
    - Total Hashrates are now categorized by Rig Algorithms used
    - New Rig Details - Cleaner interface
    - [+COIN] ReddCoin
    - [+POOL] NOMP
    - [+POOL] MagicPool
    - [+POOL] Multipool.Us
    - [+POOL] Eligius
    - [+POOL] TradeMyBit

    HOTFIXES
    ========
    - [POOL] MPOS sometimes displayed the wrong information

---

    [ v1.1.0 ]

    FEATURES
    ========
    - New Auto-Updater functionality! Keep on top of the latest features and fixes that we add.
    - New "Release", "Beta", "Nightly" options for the cG version stability you choose
    - Configurable Hardware Error warnings
    - Added more update time interval options
    - For first-time/fresh-install users, more alerts appear to help with setup
    - [+POOL] Eclipse MC (https://eclipsemc.com)
    - [+POOL] SimpleCoin
    - [+COIN] ContinuumCoin (CTM) (http://continuumcoin.com)

    HOTFIXES
    ========
    - Hardware Errors preference/value not set on first load
    - Fixed hashrate inconsistency with API
    - Resolved user_data folder not being found in certain cases
    - Improved session performance
    - Decimal place rounding for cgminer accepted/rejected
    - Active navbar link display states
    - Github repo URL in Update Available alert was incorrect

---

/*end CHANGELOG.md*
