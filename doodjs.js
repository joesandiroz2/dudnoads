let filelink = window.location.href.split('?')[1].split('=')[1];
let download_link = '';

if (filelink) {
    if (filelink.match(/dood(stream)?\./)) {
        function makePlay() {
            let a = '';
            let t = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let n = t.length - 1;
            for (let o = 0; o < 10; o++) {
                a += t.charAt(Math.floor(Math.random() * n));
            }
            return a;
        }

        filelink = filelink.replace("/f/", "/e").replace("/d/", "/e/");
        let host = new URL(filelink).host;
        let DEFAULT_CIPHERS = [
            "ECDHE+AESGCM",
            "ECDHE+CHACHA20",
            "DHE+AESGCM",
            "DHE+CHACHA20",
            "ECDH+AESGCM",
            "DH+AESGCM",
            "ECDH+AES",
            "DH+AES",
            "RSA+AESGCM",
            "RSA+AES",
            "!aNULL",
            "!eNULL",
            "!MD5",
            "!DSS",
            "!ECDHE+SHA",
            "!AES128-SHA",
            "!DHE"
        ];

        let ssl_version = (typeof(CURL_SSLVERSION_TLSv1_3) !== 'undefined') ? 7 : 0;
        let ua = "Mozilla/5.0";
        let ch = new XMLHttpRequest();
        ch.open("GET", filelink, false);
        ch.setRequestHeader("User-Agent", ua);
        ch.send();
        let h = ch.responseText;

        let m = h.match(/location\:\s+(http.+)/i);
        if (m) {
            filelink = m[1].trim();
            host = new URL(m[1].trim()).host;
        }

        let s = h.match(/(\/\/[\.\d\w\-\.\/\\\:\?\&\#\%\_\,]*(\.(srt|vtt)))/);
        let srt = (s) ? "https:" + s[1] : '';

        if (h.includes("pass_md5")) {
            let t1 = h.split('token=');
            let t2 = t1[1].split('&');
            let tok = t2[0];
            let t3 = h.split("pass_md5/");
            let t4 = t3[1].split("'");
            let l = "https://" + host + "/pass_md5/" + t4[0];
            let head = [
                'Accept: */*',
                'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
                'Accept-Encoding: deflate',
                'X-Requested-With: XMLHttpRequest',
                'Alt-Used: dood.to:443',
                'Connection: keep-alive',
                'Cookie: referer=',
                'Referer: ' + filelink
            ];
            ch.open("GET", l, false);
            ch.setRequestHeader("User-Agent", ua);
            ch.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            ch.setRequestHeader("Referer", filelink);
            ch.send();
            let h1 = ch.responseText;
            let link = '';
            if (h1.includes("http") && h1.substring(0, 4) === "http") {
                link = h1 + "?token=" + tok + "&expiry=" + (Date.now());
            }
            if (link) {
                link += "|Referer=" + encodeURIComponent("https://" + host);
            }
        }

        if (link) {
            download_link = link;
        }
    } else {
        let response = { error: 'Parameter filelink tidak diberikan' };
    }
}
