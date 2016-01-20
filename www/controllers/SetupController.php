<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * SetupController performs the initial setup and initialization of database.
 */
class SetupController extends Controller
{

    public function actionInit()
    {
        $this->initTable_platform();
        $this->initTable_generator();
        $this->initTable_gen_plat();
        $this->initTable_cracker();
        $this->initTable_cracker_plat();
        $this->initTable_cracker_gen();
        $this->initTable_algorithm();
        $this->initTable_cracker_algo();
        $this->initTable_plat_algo_cracker();
    }

    private function initStartMsg($function)
    {
        $tableName = substr($function, 10);
        echo "Initializing \"$tableName\" table...<br>";
    }

    private function initEndMsg($function)
    {
        $tableName = substr($function, 10);
        echo "\"$tableName\" table Initialized.<br><br>";
    }

    private $algoCpu = [
        [0,     'MD5',                                                      null],
        [10,    'md5($pass.$salt)',                                         null],
        [20,    'md5($salt.$pass)',                                         null],
        [30,    'md5(unicode($pass).$salt)',                                null],
        [40,    'md5($salt.unicode($pass))',                                null],
        [50,    'HMAC-MD5 (key = $pass)',                                   null],
        [60,    'HMAC-MD5 (key = $salt)',                                   null],
        [100,   'SHA1',                                                     null],
        [110,   'sha1($pass.$salt)',                                        null],
        [120,   'sha1($salt.$pass)',                                        null],
        [130,   'sha1(unicode($pass).$salt)',                               null],
        [140,   'sha1($salt.unicode($pass))',                               null],
        [150,   'HMAC-SHA1 (key = $pass)',                                  null],
        [160,   'HMAC-SHA1 (key = $salt)',                                  null],
        [200,   'MySQL323',                                                 null],
        [300,   'MySQL4.1/MySQL5',                                          null],
        [400,   'phpass, MD5(Wordpress), MD5(phpBB3), MD5(Joomla > 2.5.18)',null], // 'phpass, MD5(Wordpress), MD5(phpBB3), MD5(Joomla)'
        [500,   'md5crypt $1$, MD5(Unix), Cisco-IOS $1$',                   null], // 'md5crypt, MD5(Unix), FreeBSD MD5, Cisco-IOS MD5'
        [900,   'MD4',                                                      null],
        [1000,  'NTLM',                                                     null],
        [1100,  'Domain Cached Credentials (DCC), MS Cache',                null],
        [1400,  'SHA-256',                                                  null],
        [1410,  'sha256($pass.$salt)',                                      null],
        [1420,  'sha256($salt.$pass)',                                      null],
        [1430,  'sha256(unicode($pass).$salt)',                             null],
        [1431,  'base64(sha256(unicode($pass)))',                           null],
        [1440,  'sha256($salt.unicode($pass))',                             null],
        [1450,  'HMAC-SHA256 (key = $pass)',                                null],
        [1460,  'HMAC-SHA256 (key = $salt)',                                null],
        [1600,  'Apache $apr1$',                                            null], // 'md5apr1, MD5(APR), Apache MD5'
        [1700,  'SHA-512',                                                  null],
        [1710,  'sha512($pass.$salt)',                                      null],
        [1720,  'sha512($salt.$pass)',                                      null],
        [1730,  'sha512(unicode($pass).$salt)',                             null],
        [1740,  'sha512($salt.unicode($pass))',                             null],
        [1750,  'HMAC-SHA512 (key = $pass)',                                null],
        [1760,  'HMAC-SHA512 (key = $salt)',                                null],
        [1800,  'SHA512(Unix)',                                             null],
        [2400,  'Cisco-PIX MD5',                                            null],
        [2410,  'Cisco-ASA MD5',                                            null],
        [2500,  'WPA/WPA2',                                                 null],
        [2600,  'md5(md5($pass)',                                           null], // 'Double MD5'
        [3200,  'bcrypt $2*$, Blowfish(Unix)',                              null], // 'bcrypt, Blowfish(OpenBSD)'
        [3300,  'MD5(Sun)',                                                 null],
        [3500,  'md5(md5(md5($pass)))',                                     null],
        [3610,  'md5(md5($salt).$pass)',                                    null],
        [3710,  'md5($salt.md5($pass))',                                    null],
        [3720,  'md5($pass.md5($salt))',                                    null],
        [3800,  'md5($salt.$pass.$salt)',                                   null],
        [3910,  'md5(md5($pass).md5($salt))',                               null],
        [4010,  'md5($salt.md5($salt.$pass))',                              null],
        [4110,  'md5($salt.md5($pass.$salt))',                              null],
        [4210,  'md5($username.0.$pass)',                                   null],
        [4300,  'md5(strtoupper(md5($pass)))',                              null],
        [4400,  'md5(sha1($pass))',                                         null],
        [4500,  'sha1(sha1($pass)',                                         null], // 'Double SHA1'
        [4600,  'sha1(sha1(sha1($pass)))',                                  null],
        [4700,  'sha1(md5($pass))',                                         null],
        [4800,  'iSCSI CHAP authentication, MD5(Chap)',                     null], // 'MD5(Chap), iSCSI CHAP authentication'
        [4900,  'sha1($salt.$pass.$salt)',                                  null],
        [5000,  'SHA-3(Keccak)',                                            null],
        [5100,  'Half MD5',                                                 null],
        [5200,  'Password Safe v3 SHA-256',                                 null], // 'Password Safe SHA-256'
        [5300,  'IKE-PSK MD5',                                              null],
        [5400,  'IKE-PSK SHA1',                                             null],
        [5500,  'NetNTLMv1 + ESS',                                          null], // 'NetNTLMv1-VANILLA / NetNTLMv1-ESS'
        [5600,  'NetNTLMv2',                                                null],
        [5700,  'Cisco-IOS $4$',                                            null], // 'Cisco-IOS SHA256'
        [5800,  'Android PIN',                                              null],
        [6300,  'AIX {smd5}',                                               null],
        [6400,  'AIX {ssha256}',                                            null],
        [6500,  'AIX {ssha512}',                                            null],
        [6700,  'AIX {ssha1}',                                              null],
        [6900,  'GOST R 34.11-94',                                          null], // 'GOST, GOST R 34.11-94'
        [7000,  'Fortigate (FortiOS)',                                      null],
        [7100,  'OSX v10.8, 10.9, 10.10',                                   null], // 'OSX v10.8+'
        [7200,  'GRUB 2',                                                   null],
        [7300,  'IPMI2 RAKP HMAC-SHA1',                                     null],
        [7400,  'sha256crypt $5$, SHA256(Unix)',                            null], // 'sha256crypt, SHA256(Unix)'
        [7900,  'Drupal7',                                                  null],
        [8400,  'WBB3 (Woltlab Burning Board)',                             null], // 'WBB3, Woltlab Burning Board 3'
        [8900,  'scrypt',                                                   null],
        [9200,  'Cisco-IOS $8$',                                            null],
        [9300,  'Cisco-IOS $9$',                                            null],
//         [9800,  'Radmin2',                                                  null],
        [10000, 'Django (PBKDF2-SHA256)',                                   null],
        [10200, 'Cram MD5',                                                 null],
        [10300, 'SAP CODVN H (PWDSALTEDHASH) iSSHA-1',                      null],
        [11000, 'PrestaShop',                                               null],
        [11100, 'PostgreSQL Challenge-Response Authentication (MD5)',       null],
        [11200, 'MySQL Challenge-Response Authentication (SHA1)',           null],
        [11400, 'SIP digest authentication (MD5)',                          null],
//         [99999, 'Plaintext',                                                null],
        [11,    'Joomla < 2.5.18',                                          null],
        [12,    'PostgreSQL',                                               null],
        [21,    'osCommerce, xt:Commerce',                                  null],
        [23,    'Skype',                                                    null],
        [101,   'nsldap, SHA-1(Base64), Netscape LDAP SHA',                 null],
        [111,   'nsldaps, SSHA-1(Base64), Netscape LDAP SSHA',              null],
        [112,   'Oracle S: Type (Oracle 11+)',                              null],
        [121,   'SMF (Simple Machines Forum)',                              null], // 'SMF > v1.1'
        [122,   'OSX v10.4, v10.5, v10.6',                                  null],
        [123,   'EPi',                                                      null],
        [124,   'Django (SHA-1)',                                           null],
        [131,   'MSSQL(2000)',                                              null],
        [132,   'MSSQL(2005)',                                              null],
        [133,   'PeopleSoft',                                               null],
        [141,   'EPiServer 6.x < v4',                                       null],
        [1421,  'hMailServer',                                              null],
        [1441,  'EPiServer 6.x > v4',                                       null],
        [1711,  'SSHA-512(Base64), LDAP {SSHA512}',                         null],
        [1722,  'OSX v10.7',                                                null],
        [1731,  'MSSQL(2012 & 2014)',                                       null],
        [2611,  'vBulletin < v3.8.5',                                       null],
        [2612,  'PHPS',                                                     null],
        [2711,  'vBulletin > v3.8.5',                                       null],
        [2811,  'IPB (Invison Power Board)',                                null], // 'IPB2+, MyBB1.2+'
        [3711,  'Mediawiki B type',                                         null],
        [3721,  'WebEdition CMS',                                           null],
        [7600,  'Redmine',                                                  null] // 'Redmine Project Management Web App'
    ];

    private $algoGpu = [
        [900,   'MD4',                                                      null],
        [0,     'MD5',                                                      null],
        [5100,  'Half MD5',                                                 null],
        [100,   'SHA1',                                                     null],
        [10800, 'SHA-384',                                                  null],
        [1400,  'SHA-256',                                                  null],
        [1700,  'SHA-512',                                                  null],
        [5000,  'SHA-3(Keccak)',                                            null],
        [10100, 'SipHash',                                                  null],
        [6000,  'RipeMD160',                                                null],
        [6100,  'Whirlpool',                                                null],
        [6900,  'GOST R 34.11-94',                                          null],
        [11700, 'GOST R 34.11-2012 (Streebog) 256-bit',                     null],
        [11800, 'GOST R 34.11-2012 (Streebog) 512-bit',                     null],
        [10,    'md5($pass.$salt)',                                         null],
        [20,    'md5($salt.$pass)',                                         null],
        [30,    'md5(unicode($pass).$salt)',                                null],
        [40,    'md5($salt.unicode($pass))',                                null],
        [3800,  'md5($salt.$pass.$salt)',                                   null],
        [3710,  'md5($salt.md5($pass))',                                    null],
        [2600,  'md5(md5($pass)',                                           null],
        [4300,  'md5(strtoupper(md5($pass)))',                              null],
        [4400,  'md5(sha1($pass))',                                         null],
        [110,   'sha1($pass.$salt)',                                        null],
        [120,   'sha1($salt.$pass)',                                        null],
        [130,   'sha1(unicode($pass).$salt)',                               null],
        [140,   'sha1($salt.unicode($pass))',                               null],
        [4500,  'sha1(sha1($pass)',                                         null],
        [4700,  'sha1(md5($pass))',                                         null],
        [4900,  'sha1($salt.$pass.$salt)',                                  null],
        [1410,  'sha256($pass.$salt)',                                      null],
        [1420,  'sha256($salt.$pass)',                                      null],
        [1430,  'sha256(unicode($pass).$salt)',                             null],
        [1440,  'sha256($salt.unicode($pass))',                             null],
        [1710,  'sha512($pass.$salt)',                                      null],
        [1720,  'sha512($salt.$pass)',                                      null],
        [1730,  'sha512(unicode($pass).$salt)',                             null],
        [1740,  'sha512($salt.unicode($pass))',                             null],
        [50,    'HMAC-MD5 (key = $pass)',                                   null],
        [60,    'HMAC-MD5 (key = $salt)',                                   null],
        [150,   'HMAC-SHA1 (key = $pass)',                                  null],
        [160,   'HMAC-SHA1 (key = $salt)',                                  null],
        [1450,  'HMAC-SHA256 (key = $pass)',                                null],
        [1460,  'HMAC-SHA256 (key = $salt)',                                null],
        [1750,  'HMAC-SHA512 (key = $pass)',                                null],
        [1760,  'HMAC-SHA512 (key = $salt)',                                null],
        [400,   'phpass, MD5(Wordpress), MD5(phpBB3), MD5(Joomla > 2.5.18)',null], // Combined
        [8900,  'scrypt',                                                   null],
        [11900, 'PBKDF2-HMAC-MD5',                                          null],
        [12000, 'PBKDF2-HMAC-SHA1',                                         null],
        [10900, 'PBKDF2-HMAC-SHA256',                                       null],
        [12100, 'PBKDF2-HMAC-SHA512',                                       null],
        [23,    'Skype',                                                    null],
        [2500,  'WPA/WPA2',                                                 null],
        [4800,  'iSCSI CHAP authentication, MD5(Chap)',                     null],
        [5300,  'IKE-PSK MD5',                                              null],
        [5400,  'IKE-PSK SHA1',                                             null],
        [5500,  'NetNTLMv1',                                                null],
        [5500,  'NetNTLMv1 + ESS',                                          null],
        [5600,  'NetNTLMv2',                                                null],
        [7300,  'IPMI2 RAKP HMAC-SHA1',                                     null],
        [7500,  'Kerberos 5 AS-REQ Pre-Auth etype 23',                      null],
        [8300,  'DNSSEC (NSEC3)',                                           null],
        [10200, 'Cram MD5',                                                 null],
        [11100, 'PostgreSQL Challenge-Response Authentication (MD5)',       null],
        [11200, 'MySQL Challenge-Response Authentication (SHA1)',           null],
        [11400, 'SIP digest authentication (MD5)',                          null],
        [121,   'SMF (Simple Machines Forum)',                              null],
        [2611,  'vBulletin < v3.8.5',                                       null],
        [2711,  'vBulletin > v3.8.5',                                       null],
        [2811,  'MyBB',                                                     null],
        [2811,  'IPB (Invison Power Board)',                                null],
        [8400,  'WBB3 (Woltlab Burning Board)',                             null],
        [11,    'Joomla < 2.5.18',                                          null],
        [2612,  'PHPS',                                                     null],
        [7900,  'Drupal7',                                                  null],
        [21,    'osCommerce, xt:Commerce',                                  null], // Combined
        [11000, 'PrestaShop',                                               null],
        [124,   'Django (SHA-1)',                                           null],
        [10000, 'Django (PBKDF2-SHA256)',                                   null],
        [3711,  'Mediawiki B type',                                         null],
        [7600,  'Redmine',                                                  null],
        [12,    'PostgreSQL',                                               null],
        [131,   'MSSQL(2000)',                                              null],
        [132,   'MSSQL(2005)',                                              null],
        [1731,  'MSSQL(2012 & 2014)',                                       null], // Combined
        [200,   'MySQL323',                                                 null],
        [300,   'MySQL4.1/MySQL5',                                          null],
        [3100,  'Oracle H: Type (Oracle 7+)',                               null],
        [112,   'Oracle S: Type (Oracle 11+)',                              null],
        [12300, 'Oracle T: Type (Oracle 12+)',                              null],
        [8000,  'Sybase ASE',                                               null],
        [141,   'EPiServer 6.x < v4',                                       null],
        [1441,  'EPiServer 6.x > v4',                                       null],
        [1600,  'Apache $apr1$',                                            null],
        [12600, 'ColdFusion 10+',                                           null],
        [1421,  'hMailServer',                                              null],
        [101,   'nsldap, SHA-1(Base64), Netscape LDAP SHA',                 null],
        [111,   'nsldaps, SSHA-1(Base64), Netscape LDAP SSHA',              null],
        [1711,  'SSHA-512(Base64), LDAP {SSHA512}',                         null],
        [11500, 'CRC32',                                                    null],
        [3000,  'LM',                                                       null],
        [1000,  'NTLM',                                                     null],
        [1100,  'Domain Cached Credentials (DCC), MS Cache',                null],
        [2100,  'Domain Cached Credentials 2 (DCC2), MS Cache 2',           null],
        [12800, 'MS-AzureSync PBKDF2-HMAC-SHA256',                          null],
        [1500,  'descrypt, DES(Unix), Traditional DES',                     null],
        [12400, 'BSDiCrypt, Extended DES',                                  null],
        [500,   'md5crypt $1$, MD5(Unix), Cisco-IOS $1$',                   null], // Combined
        [3200,  'bcrypt $2*$, Blowfish(Unix)',                              null],
        [7400,  'sha256crypt $5$, SHA256(Unix)',                            null],
        [1800,  'SHA512(Unix)',                                             null], // 'sha512crypt $6$, SHA512(Unix)'
        [122,   'OSX v10.4, v10.5, v10.6',                                  null], // Combined
        [1722,  'OSX v10.7',                                                null],
        [7100,  'OSX v10.8, 10.9, 10.10',                                   null], // Combined
        [6300,  'AIX {smd5}',                                               null],
        [6700,  'AIX {ssha1}',                                              null],
        [6400,  'AIX {ssha256}',                                            null],
        [6500,  'AIX {ssha512}',                                            null],
        [2400,  'Cisco-PIX MD5',                                            null], // 'Cisco-PIX'
        [2410,  'Cisco-ASA MD5',                                            null], // 'Cisco-ASA'
        [5700,  'Cisco-IOS $4$',                                            null],
        [9200,  'Cisco-IOS $8$',                                            null],
        [9300,  'Cisco-IOS $9$',                                            null],
        [22,    'Juniper Netscreen/SSG (ScreenOS)',                         null],
        [501,   'Juniper IVE',                                              null],
        [5800,  'Android PIN',                                              null],
        [8100,  'Citrix Netscaler',                                         null],
        [8500,  'RACF',                                                     null],
        [7200,  'GRUB 2',                                                   null],
        [9900,  'Radmin2',                                                  null],
        [7700,  'SAP CODVN B (BCODE)',                                      null],
        [7800,  'SAP CODVN F/G (PASSCODE)',                                 null],
        [10300, 'SAP CODVN H (PWDSALTEDHASH) iSSHA-1',                      null],
        [8600,  'Lotus Notes/Domino 5',                                     null],
        [8700,  'Lotus Notes/Domino 6',                                     null],
        [9100,  'Lotus Notes/Domino 8',                                     null],
        [133,   'PeopleSoft',                                               null],
        [11600, '7-Zip',                                                    null],
        [12500, 'RAR3-hp',                                                  null],
        [9700,  'MS Office <= 2003 MD5 + RC4, oldoffice$0, oldoffice$1',    null],
        [9710,  'MS Office <= 2003 MD5 + RC4, collider-mode #1',            null],
        [9720,  'MS Office <= 2003 MD5 + RC4, collider-mode #2',            null],
//         [9800,  'MS Office <= 2003 SHA1 + RC4, oldoffice$3, oldoffice$4',   null],
        [9810,  'MS Office <= 2003 SHA1 + RC4, collider-mode #1',           null],
        [9820,  'MS Office <= 2003 SHA1 + RC4, collider-mode #2',           null],
        [9400,  'MS Office 2007',                                           null],
        [9500,  'MS Office 2010',                                           null],
        [9600,  'MS Office 2013',                                           null],
        [10400, 'PDF 1.1 - 1.3 (Acrobat 2 - 4)',                            null],
        [10410, 'PDF 1.1 - 1.3 (Acrobat 2 - 4) + collider-mode #1',         null],
        [10420, 'PDF 1.1 - 1.3 (Acrobat 2 - 4) + collider-mode #2',         null],
        [10500, 'PDF 1.4 - 1.6 (Acrobat 5 - 8)',                            null],
        [10600, 'PDF 1.7 Level 3 (Acrobat 9)',                              null],
        [10700, 'PDF 1.7 Level 8 (Acrobat 10 - 11)',                        null],
        [9000,  'Password Safe v2',                                         null],
        [5200,  'Password Safe v3 SHA-256',                                 null], // 'Password Safe v3'
        [6800,  'Lastpass',                                                 null],
        [6600,  '1Password, agilekeychain',                                 null],
        [8200,  '1Password, cloudkeychain',                                 null],
        [11300, 'Bitcoin/Litecoin wallet.dat',                              null],
        [12700, 'Blockchain, My Wallet',                                    null]
    ];

    private function initTable_platform()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            [0,     'cpu_linux_64'],
            [1,     'cpu_linux_32'],
            [2,     'cpu_win_64'],
            [3,     'cpu_win_32'],
            [4,     'cpu_mac_64'],
            [5,     'cpu_mac_32'],
            [6,     'gpu_linux_64_amd'],
            [7,     'gpu_linux_64_nv'],
            [8,     'gpu_linux_32_amd'],
            [9,     'gpu_linux_32_nv'],
            [10,    'gpu_win_64_amd'],
            [11,    'gpu_win_64_nv'],
            [12,    'gpu_win_32_amd'],
            [13,    'gpu_win_32_nv'],
            [14,    'gpu_mac_64_amd'],
            [15,    'gpu_mac_64_nv'],
            [16,    'gpu_mac_32_amd'],
            [17,    'gpu_mac_32_nv']
        ];
        
        $fields = 2;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%platform}} (id, name) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_generator()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            [0, 'General',  ''],
//             [1, 'Markov', ''],
        ];
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%generator}} (id, name, config) VALUES $values ON DUPLICATE KEY UPDATE config = VALUES(config)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_gen_plat()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            /* general */
            [0, 0,  null,    null],
            [0, 1,  null,    null],
            [0, 2,  null,    null],
            [0, 3,  null,    null],
            [0, 4,  null,    null],
            [0, 5,  null,    null],
            [0, 6,  0,       null],
            [0, 7,  0,       null],
            [0, 8,  1,       null],
            [0, 9,  1,       null],
            [0, 10, 2,       null],
            [0, 11, 2,       null],
            [0, 12, 3,       null],
            [0, 13, 3,       null],
            [0, 14, 4,       null],
            [0, 15, 4,       null],
            [0, 16, 5,       null],
            [0, 17, 5,       null],
            
//             /* markov */
//             [1, 0,  null,    null],
//             [1, 1,  null,    null],
//             [1, 2,  null,    null],
//             [1, 3,  null,    null],
//             [1, 4,  null,    null],
//             [1, 5,  null,    null],
//             [1, 6,  0,       null],
//             [1, 7,  0,       null],
//             [1, 8,  1,       null],
//             [1, 9,  1,       null],
//             [1, 10, 2,       null],
//             [1, 11, 2,       null],
//             [1, 12, 3,       null],
//             [1, 13, 3,       null],
//             [1, 14, 4,       null],
//             [1, 15, 4,       null],
//             [1, 16, 5,       null],
//             [1, 17, 5,       null]
        ];
        
        $fields = 4;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%gen_plat}} (gen_id, plat_id, alt_plat_id, md5) VALUES $values ON DUPLICATE KEY UPDATE md5 = VALUES(md5)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $config_hashcat = [
            'args' => '-a 3 -m ALGO_ID -s START -l OFFSET CHAR1 CHAR2 CHAR3 CHAR4 --increment --increment-min=LEN_MIN --potfile-disable --outfile-format=3 -o OUT_FILE HASH_FILE MASK',
            'args_opt' => [
                ['CHAR1' => '-1 CHAR1'],
                ['CHAR2' => '-2 CHAR2'],
                ['CHAR3' => '-3 CHAR3'],
                ['CHAR4' => '-4 CHAR4']
            ]
        ];
        
        $data = [
            [0, 'hashcat', serialize($config_hashcat)],
            [1, 'oclHashcat', null],
            [2, 'cudaHashcat', null]
        ];
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%cracker}} (id, name, config) VALUES $values ON DUPLICATE KEY UPDATE config = VALUES(config)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_plat()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            /* hashcat */
            [0, 0, null],
            [0, 1, null],
            [0, 2, null],
            [0, 3, null],
            [0, 4, null],
            [0, 5, null],
            
            /* oclHashcat (AMD) */
            [1, 6,  null],
            [1, 8,  null],
            [1, 10, null],
            [1, 12, null],
            [1, 14, null],
            [1, 16, null],
            
            /* cudaHashcat (NVidia) */
            [2, 7,  null],
            [2, 9,  null],
            [2, 11, null],
            [2, 13, null],
            [2, 15, null],
            [2, 17, null]
        ];
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%cracker_plat}} (cracker_id, plat_id, md5) VALUES $values ON DUPLICATE KEY UPDATE md5 = VALUES(md5)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_gen()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $config_hashcat_general = [
            'args' => '-a 3 -m ALGO_ID -s START -l OFFSET CHAR1 CHAR2 CHAR3 CHAR4 --increment --increment-min=LEN_MIN --potfile-disable --outfile-format=3 -o OUT_FILE HASH_FILE MASK',
            'args_opt' => [
                ['CHAR1' => '-1 CHAR1'],
                ['CHAR2' => '-2 CHAR2'],
                ['CHAR3' => '-3 CHAR3'],
                ['CHAR4' => '-4 CHAR4']
            ]
        ];
        
        $data = [
            /* hashcat */
            [0, 0,  serialize($config_hashcat_general)],
//             [0, 1,  null],
            
            /* oclHashcat (AMD) */
            [1, 0,  null],
//             [1, 1,  null],
                    
            /* cudaHashcat (NVidia) */
            [2, 0,  null],
//             [2, 1,  null],
        ];
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%cracker_gen}} (cracker_id, gen_id, config) VALUES $values ON DUPLICATE KEY UPDATE config = VALUES(config)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_algorithm()
    {
        $this->initStartMsg(__FUNCTION__);
        
        /* CPU */
        $data = $this->algoCpu;
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%algorithm}} (id, name, rate_cpu) VALUES $values ON DUPLICATE KEY UPDATE rate_cpu = VALUES(rate_cpu)", $params)->execute();
        
        /* GPU */
        $data = $this->algoGpu;
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%algorithm}} (id, name, rate_gpu) VALUES $values ON DUPLICATE KEY UPDATE rate_gpu = VALUES(rate_gpu)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_algo()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [];
        
        foreach ($this->algoCpu as $algo) {
            $data[] = [0, $algo[0]]; // hashcat
        }
        
        foreach ($this->algoGpu as $algo) {
            $data[] = [1, $algo[0]]; // oclHashcat
            $data[] = [2, $algo[0]]; // cudaHashcat
        }
        
        $fields = 2;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%cracker_algo}} (cracker_id, algo_id) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_plat_algo_cracker()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [];
        
        foreach ($this->algoCpu as $algo) {
            // CPU
            $data[] = [$algo[0], 0,     0]; // hashcat
            $data[] = [$algo[0], 1,     0]; // hashcat
            $data[] = [$algo[0], 2,     0]; // hashcat
            $data[] = [$algo[0], 3,     0]; // hashcat
            $data[] = [$algo[0], 4,     0]; // hashcat
            $data[] = [$algo[0], 5,     0]; // hashcat
        }
        
        foreach ($this->algoGpu as $algo) {
            // GPU (AMD)
            $data[] = [$algo[0], 6,     1]; // oclHashcat
            $data[] = [$algo[0], 8,     1]; // oclHashcat
            $data[] = [$algo[0], 10,    1]; // oclHashcat
            $data[] = [$algo[0], 12,    1]; // oclHashcat
            $data[] = [$algo[0], 14,    1]; // oclHashcat
            $data[] = [$algo[0], 16,    1]; // oclHashcat
            
            // GPU (NVidia)
            $data[] = [$algo[0], 7,     2]; // cudaHashcat
            $data[] = [$algo[0], 9,     2]; // cudaHashcat
            $data[] = [$algo[0], 11,    2]; // cudaHashcat
            $data[] = [$algo[0], 13,    2]; // cudaHashcat
            $data[] = [$algo[0], 15,    2]; // cudaHashcat
            $data[] = [$algo[0], 17,    2]; // cudaHashcat
        }
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT INTO {{%plat_algo_cracker}} (algo_id, plat_id, cracker_id) VALUES $values ON DUPLICATE KEY UPDATE cracker_id = VALUES(cracker_id)", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }
}
