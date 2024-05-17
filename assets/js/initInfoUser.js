function getIPaddress() {
    var API_TOKEN = '681c5d97313bc8';

    // Menggunakan Fetch API
    return fetch(`https://ipinfo.io/json?token=${API_TOKEN}`)
        .then(response => response.json())
        .then(data => {
            return data; // Return data for further processing
        })
        .catch(error => {
            console.error('Error:', error);
            throw error; // Rethrow error for proper error handling
        });
}

function getBrowserUser() {
    // Mendapatkan informasi user agent
    var userAgent = navigator.userAgent;
    console.log('User Agent:', userAgent);

    // Mendapatkan informasi vendor
    var vendor = navigator.vendor;
    console.log('Vendor:', vendor);

    return {
        "userAgent": userAgent,
        "vendor": vendor,
        "device": getDeviceType()
    };
}

function getLocationUser() {
    return new Promise((resolve, reject) => {
        // Cek apakah Geolocation didukung oleh browser
        if ('geolocation' in navigator) {
            // Mendapatkan lokasi pengguna
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // console.log('Latitude:', position.coords.latitude);
                    // console.log('Longitude:', position.coords.longitude);
                    console.log('LatLng:', `${position.coords.latitude},${position.coords.longitude}`);
                    resolve(position);
                },
                function(error) {
                    reject(error.message);
                    console.error('Error getting location:', error.message);
                }
            );
        } else {
            reject('Geolocation is not supported by this browser.');
            console.error('Geolocation is not supported by this browser.');
        }
    });
}

function initParams() {
    // Mendapatkan URL saat ini
    // var currentUrl = window.location.href;
    // var currentUrl = document.currentScript;

    // Mengambil parameter id dari URL
    // var idParam = new URL(currentUrl).searchParams.get("id");
    // var urlSearchParams = new URLSearchParams(currentUrl.split('?')[1]);
    // var idParam = urlSearchParams.get("id");

    // Mendapatkan elemen <script> berdasarkan ID
    var scriptElement = document.getElementById('initInfoUserScript');

    // Mengambil parameter id dari URL
    var urlSearchParams = new URLSearchParams(scriptElement.src).get('time');
    // var idParam = new URLSearchParams(scriptElement.src.split('?')[1]).get("v");
    var idParam = new URLSearchParams(scriptElement.src).get("v");

    // console.log("currentUrl: ", currentUrl);
    console.log("scriptElement: ", scriptElement);
    console.log("urlSearchParams: ", urlSearchParams);
    console.log("idParam: ", idParam);

    // Mengecek apakah parameter id tersedia
    if (idParam !== null) {
        // Gunakan nilai idParam sesuai kebutuhan
        console.log('Id User:', idParam);
    } else {
        console.error('Parameter id tidak ditemukan.');
    }
    return idParam;
}

async function getInformationUser() {
    try {
        var list_info = {};

        // Mendapatkan id pengguna
        list_info['id_user'] = initParams();

        // Mendapatkan browser pengguna
        list_info['browser_name'] = getBrowserUser();

        // Mendapatkan alamat IP pengguna
        var ipData = await getIPaddress();
        console.log('Alamat IP:', ipData);
        list_info['ip_address'] = ipData.ip;
        list_info['data_ip_address'] = ipData;

        try {
            // Mendapatkan lokasi pengguna
            var locationInfo = await getLocationUser();
            list_info['location_user'] = {
                'timestamp': locationInfo.timestamp,
                'latitude': locationInfo.coords.latitude,
                'longitude': locationInfo.coords.longitude,
                'accuracy': locationInfo.coords.accuracy,
            };
            list_info['latLon'] = `${locationInfo.coords.latitude},${locationInfo.coords.longitude}`;

        } catch (error) {
            // Mendapatkan lokasi pengguna yang ditolak dari ip address
            list_info['location_user'] = {};
            list_info['latLon'] = `${ipData.loc}`;
        }

        list_info['db'] = {
            'id_user': list_info['id_user'],
            'browser_name': JSON.stringify(list_info['browser_name']),
            'ip_address': list_info['ip_address'],
            'data_ip_address': JSON.stringify(list_info['data_ip_address']),
            'location_user': JSON.stringify(list_info['location_user']),
            'latLon': list_info['latLon'],
        };
        // console.log("list_info: ", list_info);

        return list_info; // Mengembalikan informasi pengguna
    } catch (error) {
        console.error('Error:', error);
        throw error; // Rethrow error untuk penanganan lebih lanjut jika perlu
    }
}

// Menggunakan async/await untuk mendapatkan hasil dari fungsi asinkron
async function processInformation() {
    try {
        var get_info = await getInformationUser();
        console.log("get_info: ", get_info);
        saveInfo(get_info.db);
    } catch (error) {
        console.error('Error:', error);
    }
    // atau bisa juga menggunakan metode pemanggilan seperti dibawah ini
    // panggil untuk mendapatkan hasil dari fungsi asinkron
    // getInformationUser().then((get_info) => {
    //     console.log("get_info: ", get_info);
    //     saveInfo(get_info.db);
    // });
}