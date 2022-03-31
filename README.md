## 📝 Kazalo

1 [Namestitev](#namestitev)

1.1 [Samodejni namestitveni program](#samodejni-namestitveni-program)

2 [Posodabljanje](#posodabljanje)

3 [Za obnovitev SSL potrdila](#obnovitev-ssl-potrdila)

## <a name="namestitev"></a> 🖥️ Namestitev
```
OPOMBA: Če uporabljate SLODovInnovations na primerku, ki ni HTTPS, MORATE spremeniti naslednje konfiguracije.

.env  <-- SESSION_SECURE_COOKIE mora biti nastavljen na false
config/secure-headers.php   <-- HTTP Strict Transport Security mora biti nastavljen na false
config/secure-headers.php   <-- Politika varnosti vsebine mora biti onemogočena 
```

### <a name="samodejni-namestitveni-program"></a> Samodejni namestitveni program
**SLOYakuza je izdal namestitveni program SLOshare Installer.**

**Uradno podprti OS**

    Ubuntu 20.04 LTS (priporočeno)
    Ubuntu 18.04 LTS
    Ubuntu 16.04 LTS

**Za Ubuntu 20.04 LTS:**
```
git clone https://github.com/SLODovInnovations/SLOshare-INSTALLER.git installer
cd installer
sudo ./install.sh
```

**Za Ubuntu 16.04 LTS ali Ubuntu 18.04 LTS:**
```
git clone https://github.com/SLODovInnovations/SLOshare-INSTALLER.git installer
cd installer
git checkout Ubuntu-16.04-18.04
sudo ./install.sh
```

## <a name="posodabljanje"></a> 🖥️ Posodabljanje
```
php artisan git:update
```
## <a name="obnovitev-ssl-potrdila"></a> 🔐 Za obnovitev SSL potrdila
**Za obnovitev SSL potrdila LetsEncrypt:**
```
cerbot renew --dry-run
```
