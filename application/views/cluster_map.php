<div class="main-content">
    <div class="page-content px-0">
        <div class="row">
            <div class="col-12">
                <?php 
                $icon = $data_top->icon;
                $icon_all = '<i id="icon_chain" class="bx bx-link bg-primary text-center text-white py-1 p-1 font-size-xl align-middle rounded';
                $icon_food = '<i id="icon_chain" class="bx bx-bowl-rice bg-warning text-white text-center py-1 p-1 font-size-xl align-middle rounded';
                $icon_shopping = '<i id="icon_chain" class="bx bx-shopping-bag bg-info text-white text-center py-1 p-1 font-size-xl align-middle rounded';
                $icon_service = '<i id="icon_chain" class="bx bx-wrench bg-danger text-white text-center py-1 p-1 font-size-xl align-middle rounded';
                
                $get_icon = '';
                if ($icon == 'all') {
                    $icon_all .= '"></i>';
                    $get_icon = $icon_all;
                }
                elseif ($icon == 'food') {
                    $icon_food .= '"></i>';
                    $get_icon = $icon_food;
                }
                elseif ($icon == 'shopping') {
                    $icon_shopping .= '"></i>';
                    $get_icon = $icon_shopping;
                }
                elseif ($icon == 'service') {
                    $icon_service .= '"></i>';
                    $get_icon = $icon_service;
                } else {
                    $icon_all .= ' d-none"></i>';
                    $get_icon = $icon_all;
                }
                ?>
                <div id="my_map" style="margin-top: -1.4rem; position: relative; width: 100%; height: 470px;"></div>
                <div id="card-top-info" class="card card-effect border border-3 border-secondary card-info-side w-100">
                    <div class="pin_div my-2 mx-1">
                        <img id="img_chain" src="flags/<?= ($icon == 'all' || $icon == 'food' || $icon == 'shopping' || $icon == 'service') ? 'flag_not_found.png' : $data_top->i.'.png' ?>" width="40" height="40" class="<?= ($icon == 'all' || $icon == 'food' || $icon == 'shopping' || $icon == 'service') ? 'd-none' : '' ?>" onerror="this.onerror=null; this.src='<?= base_url('flags/flag_not_found.png'); ?>'">
                        <?= $get_icon ?>
                    </div>
                    
                    <div id="card-tag" class="card-title chain_name mb-0" style="top: 7px; left: 3.5rem;"><?= $data_top->txt ?></div>
                    <?php $check_amount = ($data_top->icon == 'all') ? true : false ?>
                    <p id="card-desc" class="card-text text-muted chain_desc" style="top: 1.6rem; left: 3.5rem;">
                        <!-- <?php number_format($data_top->cname) .' チェーン / '. $this->link->change_number_format($data_top->poi_ori) ?> -->
                        <?= $data_top->desc ?>
                    </p>

                    <div class="row no-gutters align-items-center m-0 d-none">
                        <div class="col-2 px-0 ps-2">
                            <!-- <i id="icon_chain" class="bx bx-link bg-primary text-center text-white py-1 p-1 font-size-xxl align-middle rounded"></i> -->
                        </div>
                        <div class="col-10 px-4 px-lg-auto">
                            <div class="card-body px-0 py-2">
                                <!-- すべてのチェーン -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group dropstart mapboxgl-ctrl mapboxgl-ctrl-group d-none">
                    <button type="button" class="btn btn-light dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-layer font-size-18 align-middle'></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item item_style bg-secondary bg-soft" href="javascript:void(0);" id="default" onclick="style_map(this)">Streets</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="satellite-v9" onclick="style_map(this)">Satellite</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="dark-v10" onclick="style_map(this)">Dark</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="light-v10" onclick="style_map(this)">Light</a>
                    </div>
                </div>

                <div id="ads_loketech" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <a href="https://locationtech.jp/" class="carousel-item active" target="_blank" rel="noopener noreferrer">
                            <img class="d-block img-fluid" src="assets/images/ads/Ads-rounded1.png" alt="First slide">
                        </a>
                        <a href="https://locationtech.jp/" class="carousel-item" target="_blank" rel="noopener noreferrer">
                            <img class="d-block img-fluid" src="assets/images/ads/Ads-rounded2.png" alt="Second slide">
                        </a>
                        <a href="https://locationtech.jp/" class="carousel-item" target="_blank" rel="noopener noreferrer">
                            <img class="d-block img-fluid" src="assets/images/ads/Ads-rounded3.png" alt="Third slide">
                        </a>
                    </div>
                </div>
                <style>
                    #ads_loketech{
                        position: absolute;
                        bottom: 10px;
                        z-index: 999999999;
                        left: 50%;
                        transform: translate(-50%, 0%);
                    }
                </style>
            </div>
        </div>
    </div>
</div>
<style>
    #my_map{
        /* position: absolute !important; */
        top: 0;
        bottom: 0;
        width: 100%;
        margin-top: -1.4rem;
    }

    .font-size-xl{
        font-size: x-large !important;
        margin: 0 5px;
    }

    .font-size-xxl{
        font-size: xx-large !important;
    }

    .card-info-side {
        /* position: absolute; */
        top: 0;
        /* left: 3%; */
        width: max-content;
        margin-bottom: 0;
        background: rgb(245 245 245 / 85%);
    }
    .card-info-ver {
        position: absolute;
        top: 5%;
        left: 7%;
        width: max-content;
        margin-bottom: 0;
        background: rgb(245 245 245 / 85%);
    }

    .flag-markerss {
        background-image: url('<?= base_url() ?>assets/images/marker/marker-red.png');
        display: flex;
        position: inherit !important;
        /* width: 40px;
        height: 55px; */
        width: auto;
        height: 75px;
    }
    .flag-marker {
        background-size: 100%;
        background-repeat: no-repeat;
        cursor: pointer;
        /* width: min-content !important; */
    }

    .flag_popup{
        top: -20px !important;
        max-width: 400px !important;
    }

    #group_markers>.active{
        background-color: #cccecf !important;
    }
</style>

<!-- plugin loading -->
<link href="<?= base_url() ?>custom-loading/css/modal-loading.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?= base_url() ?>custom-loading/js/modal-loading.js"></script>

<!-- SCRIPT GLOBAL VARIABLE -->
<script type="text/javascript">
    const viewJapan = [140.34, 38.28]; // format lng, lat
    const ROOTS = '<?= base_url() ?>api';
    const TOKEN_MAP = '<?= token_mapbox ?>';
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '') ? MAIN_STYLE : item_style;
    
    let _opening_popup = null;
    let _all_shop_hash = {};
    let _last_epoch = 0;
    let _blue_ball_marker = null;
    let _current_tag_list = ['food_udon_marugame'];
    let _my_device = get_device();
    let sc = null;
    let list_bbox = {
        feat: null,
        list_poi: [],
        bbox: [],
        line: [],
        bboxPoly: []
    }; 
    
    // =============================
    // setting paramter
    // =============================
    let __params = null;
    let __map_refresh = true;
    __params = get_params();
    let param_lat = parseFloat(__params['lat']);
    let param_lon = parseFloat(__params['lon']);
    let param_z = parseFloat(__params['z']);
    let param_tag = __params['tag'];
    let param_m = __params['m']; // 開始時にバルーンを開くマーカーのshop ID または緯度経度

    if (Number.isNaN(param_lat)) {
        // param_lat = null;
        param_lat = 35.83153;
    }
    if (Number.isNaN(param_lon)) {
        // param_lon = null;
        param_lon = 139.26266;
    }
    if (Number.isNaN(param_z)) {
        // param_z = null;
        param_z = 7;
    }
    param_lat = 38.61243;
    param_lon = 134.63015;
    param_z = 4;
    // console.log("param_lat: ", param_lat, " param_lon: ", param_lon, " param_z: ", param_z);

    if (param_tag == '' || param_tag == null) {
        param_tag = ['food_udon_marugame'];
    } else {
        param_tag = param_tag.split(',');
    }

    if (param_m == '' || typeof param_m == 'undefined') {
        param_m = null;
    }

    let map_state = {
        tag_list: param_tag,
        lat: param_lat,
        lon: param_lon,
        z: param_z,
        m: param_m,
    }
    // =============================
    // END setting paramter
    // =============================
    
    var first_load = false;

    function get_params() {
        var str = document.location.search;
        str = str.replace(/&amp;/g, '&');

        var params = {};
        var pairs = (str[0] === '?' ? str.substr(1) : str).split('&');
        for (var i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || '');
        }
        return params;
    }

    function get_screen_type() {
        // Size of browser viewport.
        let win_W = $(window).width();
        let win_H = $(window).height();

        // Size of HTML document (same as pageHeight/pageWidth in screenshot).
        let doc_W = $(document).width();
        let doc_H = $(document).height();

        // For screen size
        let screen_W = window.screen.width;
        let screen_H = window.screen.height;
        // if (win_W > 1200) {
        //     $("#card-top-info").removeClass('w-auto').addClass('w-25');            
        // } else {
        //     $("#card-top-info").removeClass('w-25').addClass('w-auto');
        // }

        return {"win_width": win_W, "win_height": win_H, "doc_width": doc_W, "doc_height": doc_H, "screen_width": screen_W, "screen_height": screen_H}
	}

    function get_device() {
		let ua = navigator.userAgent.toLowerCase();
		if (ua.toLowerCase().indexOf("iphone") >= 0)  { return "iphone";  }
		if (ua.toLowerCase().indexOf("ipod") >= 0)    { return "iphone";  }
		if (ua.toLowerCase().indexOf("ipad") >= 0)    { return "iphone";  }
		if (ua.toLowerCase().indexOf("android") >= 0) { return "android"; }
		return "pc";
	}
    
    function make_current_map_state() {
        let m = null;
        if (_opening_popup != null && _opening_popup.isOpen() == true) {
            if (_opening_popup.marker.shop.shop_id < 100000000) {
                m = _opening_popup.marker.shop.shop_id; // チェーン店ならshop_idでinfowinを開く
            } else {
                let {lat, lng} = _opening_popup.getLngLat();
                m = `${lat},${lng}`; // チェーン店以外なら緯度経度でinfowinを開く
            }
        }
        let {lat, lng: lon} = map.getCenter();
        lat = Math.round(lat * 100000) / 100000;
        lon = Math.round(lon * 100000) / 100000;
        let z = Math.floor(map.getZoom());

        let tag = _current_tag_list.join(',');
        let url = `?tag=${tag}&lat=${lat}&lon=${lon}&z=${z}`;
        if (m != null) {
            url = url + `&m=${m}`;
        }

        let map_state = {
            tag_list: _current_tag_list,
            lat: lat,
            lon: lon,
            z:   z,
            m:   m,
            url: url,
        };

        return map_state;
    }

    function replace_url() {
        let map_state = make_current_map_state();
        history.replaceState(map_state, '', map_state.url);
        // console.log("replace_url: ", map_state);
    }
    
    function push_url() {
        let map_state = make_current_map_state();
        history.pushState(map_state, '', map_state.url);
        // console.log("push_url: ", map_state);
    }

    first_menu(); // hapus first_menu jika sudah ada all chain, all food, dll di bagian menu
    console.log("map_state: ", map_state);
    function first_menu(){
        let url = `${ROOTS}/ii?i=${map_state.tag_list[0]}&token=${refresh_token()}`;
        fetch(url).then((res) => {return res.json()})
        .then((result) => {
            let json = get_hashed(result);
            if (json.tag_title != null || json.tag_title != '') {
                title_and_desc(json.tag_title, json.tag_desc, json.tag_icon);
            }
        });
    }
    
    function refresh_token(){
        var length = Math.floor((Math.random() * 600) + 300);
        var token = generate_token(length);
        keys.set_key(token);
        console.log("length: ", length, "key: ", keys.get_key);
        // var url = `${ROOTS}/re/?token=${token}`;
        // return $.ajax({
        //     type: "GET",
        //     url: url,
        //     dataType: "json",
        // });
        return token;
    }

    function generate_token(length = 16){
        let result = '';
        // const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789=!@#$%^&*()';
        const characters = 'abcdefghijklmnopqrstuvwxyz0123456789_-';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
        }
        // if (is_enc) {
        //     return CryptoJSAesJson.encrypt(result, "<?= secret_key_aes ?>");
        // } else {
        //     return result;
        // }
        return result;
    }
    
</script>

<!-- SCRIPT MAIN MAPBOX -->
<script type="text/javascript">
    mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map',
        style: get_style_map,
        center: viewJapan,
        // minZoom: 2,
        zoom: 4,
        attributionControl: false,
        // pitchWithRotate: false,
        dragRotate: false,
        // touchPitch: false,
    });

    sc = get_screen_type();
    const language = new MapboxLanguage({defaultLanguage: 'ja'});
    map.addControl(language);
    map.addControl(new mapboxgl.AttributionControl({
        customAttribution: `© Location Technology. Design & Developed by <a href="https://asiaresearchinstitute.com/" target="_blank" rel="noopener noreferrer"><img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="13"></a>`
    }));
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            language: 'ja',
            placeholder: '住所検索',
        }),
        'top-left'
    );
    $("#card-top-info").addClass("mapboxgl-ctrl").appendTo(".mapboxgl-ctrl-top-left");

    map.addControl(new mapboxgl.FullscreenControl());
    $(".dropstart").removeClass("d-none").appendTo(".mapboxgl-ctrl-top-right");
    map.addControl(new mapboxgl.NavigationControl());
    $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);

    const scale = new mapboxgl.ScaleControl({maxWidth: 200});
    if (_my_device == 'pc') {
        map.addControl(scale, 'top-right');
    }
    window.addEventListener('resize', change_map_layout, true);
    $("#vertical-menu-btn").on("click", change_map_layout);
    
    map.on('load', () => {
        first_load = true;
        // main_flag();
        start_map(map_state);
        setTimeout(() => {
            map.resize();
        }, 10);
        $(".mapbox-improve-map").addClass('d-none');
    });
    map.on('moveend', get_moveend_flag);
    
    var _list_request = {};
    function get_moveend_flag(){
        if (first_load) {
            main_flag();
            replace_url();
        }
        
        if (__map_refresh == false) {
            return;
        }
    }

    function remove_flag_bug(){
        var get_all_flags = document.querySelectorAll('.flag-marker');
        if (get_all_flags.length > 0) {
            get_all_flags.forEach((e) => e.marker.remove());
        }
    }

    function remove_flag(flag) {
        clearTimeout(flag.timer);
        if (flag.marker != null) {
            flag.marker.remove();
        }
        delete _all_shop_hash[flag.shop_id];
        // delete list_filtered_flag[shop.id_property];
    }

    function remove_all_flag(restarted = true){
        for (let shop of Object.values(_all_shop_hash)) {
            remove_flag(shop);
        }
    }

    function change_map_layout(){
        sc = get_screen_type();
        setTimeout(() => {
            var w = (sc.screen_width == undefined) ? sc.win_width : sc.screen_width;
            // console.clear();
            // console.log("screen: ", sc, "\nw:", w);
            if ($("body").attr('class') == 'vertical-collpsed') {
                // $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${w*2}px;`);                
                $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);
            } else {
                $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);
            }
            map.resize();
        }, 1);
    }
    
    function start_map(map_state) {
        _current_tag_list = map_state.tag_list;
        change_map3(false, false, false);

        // if (map_state.lat == null || map_state.lon == null) {
        //     __here();
        // } else {
        // }
        if (map_state.z == null) {
            // set_good_zoom(map_state.lat, map_state.lon);
            zoom_in(map_state.lat, map_state.lon, map_state.z);
        } else {
            zoom_in(map_state.lat, map_state.lon, map_state.z);
        }
    }

    function change_map3(auto_zoom, call_push_url = true, refresh = true) {
        console.log('change_map3', auto_zoom, call_push_url, refresh);
        //update_tag_button_list();

        // if (typeof clear_manku !== 'undefined') {
        //     clear_manku();
        // }

        // if (typeof clear_name_label !== 'undefined') {
        //     clear_name_label();
        // }

        // この位置でないとiphoneはなぜかタイトルが更新されない場合あり
        var current_tag_id = _current_tag_list[0];
        //alert(current_tag_id);
        // if (typeof _title_div !== 'undefined') {
        //     change_map_title(current_tag_id);
        // }

        // remove_all_shops();
        remove_all_flag();
        remove_flag_bug();

        if (auto_zoom == true) {
            // set_good_zoom(lat, lng);
            if (list_bbox.bbox.length != 0) {
                fit_bounds(list_bbox.bbox);
            } else {
                let {
                    lat,
                    lng
                } = map.getCenter(); 
                zoom_in(lat, lng, map.getZoom());
            }

            // let sw = map.getBounds()._sw;
            // let ne = map.getBounds()._ne;
            // let bb = [ne.lng, ne.lat, sw.lng, sw.lat];

            // fit_bounds(bb);
        } 

        if (call_push_url == true) {
            push_url();
        }

        // __lock_zoom == falseならmoveendでrefresh_markerされる。
        if (refresh == true) {
            main_flag();
        }
    }

    var ajx = null;
    let index;
    let ready = false;
    const worker = new Worker('<?= base_url() ?>pages/worker_flags.js?t=<?=time()?>');

    function main_flag(){
        var scale_html = $(".mapboxgl-ctrl.mapboxgl-ctrl-scale").text();
        var scale_km = scale_html.replace('km', '');
        const get_radius = parseInt(scale_km.replace(',', ''));

        let center = map.getCenter();
        let bounds = map.getBounds();
        let swLatlng = bounds.getSouthWest();
        let neLatlng = bounds.getNorthEast();

        let {
            lng: w,
            lat: s
        } = swLatlng;
        let {
            lng: e,
            lat: n
        } = neLatlng;

        // n = n - (s - n) * 0.05; // Sedikit lebih lebar di bagian atas.
        s = s - (n - s) * 0.05; // Sedikit lebih lebar di bagian bawah.

        // w = w - (e - w) * 0.05; // Sedikit lebih lebar di bagian kiri.
        // e = e - (w - e) * 0.05; // Sedikit lebih lebar di bagian kanan.

        let {
            lng: lon,
            lat: lat
        } = center;
        // lat = parseFloat(lat.toFixed(6));
        // lon = parseFloat(lon.toFixed(6));
        
        // lat = lat - (lon - lat) * 0.05; // Sedikit lebih lebar di bagian bawah.
        
        let z = Math.floor(map.getZoom()) + 1;
        if (_my_device != 'pc') { // スマホでは、より密に。
            z += 1;
        }

        _last_epoch = (new Date).getTime();
        // _last_epoch = '<?= time() ?>';
        var tag = _current_tag_list.join(',');
        if (tag == '') {
            return;
        }
        
        let url = `${ROOTS}/gg?tag=${tag}&lat=${lat}&lon=${lon}&n=${n}&s=${s}&w=${w}&e=${e}&z=${z}&km=${get_radius}&epoch=${_last_epoch}&token=${refresh_token()}`;
        // let url = `${ROOTS}/gg?tag=${tag}&lat=${s}&lon=${w}&n=${n}&s=${s}&w=${w}&e=${e}&z=${z}&km=${get_radius}&epoch=${_last_epoch}`;
    
        console.log("get_key: ", keys.get_key);
        if (ajx != null) {
            ajx.abort();
        }
        list_bbox.bbox = [];
        ajx = $.ajax({
            url: url,
            success: function(result, status, myxhr) {
                let json = get_hashed(result);
                console.log("json: ", json);
                // req.push({'tag': tag, 'status': status});
                // _list_request[tag] = req;
                
                var bbox = [w, s, e, n];
                // kirim pesan ke worker
                worker.postMessage({
                    "shops": json.shops,
                    "bbox": bbox,
                    "zoom": z,
                    "epoch": _last_epoch
                });
                worker.onmessage = function (e) {
                    // console.log("=======================");
                    // console.log("Step_2. Pesan dari worker: ", e);
                    // console.log("Step_2. Data dari worker: ", e.data);
                    // console.log("=======================");
                    ready = e.data.ready;
                    console.log("Step_2. data is ready: ", ready, e.data);
                    if (e.data.ready){
                        var geojson = e.data.to_geojson;
                        var to_json = e.data.to_json;
                        var mybbox = turf.bbox(geojson);
                        list_bbox.bbox = mybbox;
                        // getGeoJson(geojson);
                        run_animation(to_json);
                    }
                };
                // run_animation(json);
                jqxhr = null;
            }
        });

        // console.log("ajx: ", ajx);

        const run_animation = function (json){
            console.log("epoch: ", (json.epoch < _last_epoch));
            if (json.epoch < _last_epoch) {
                return;
            }

            for (let shop of Object.values(_all_shop_hash)) {
                shop.exist = false; // いったん全部存在しないことにする。
            }

            //let hidden_marker_exist = false;
            let adding_list = [];
            var group = grouping_data(json);

            for (let shop of json.shops) {
            // for (let shop of group.by_hide_dist) {
            // for (let shop of json.manipulasi_data) {

                if (shop.shop_id in _all_shop_hash) {
                    shop = _all_shop_hash[shop.shop_id];
                } else {
                    _all_shop_hash[shop.shop_id] = shop;
                    adding_list.push(shop);
                }

                shop.exist = true;
                // shop.has_hidden = (shop.hide >= z);
            }
            
            if (json.length != 0) {
                set_masterlist(json);
            }

            let max_anime_num_pin = 200;
            if (_my_device != 'pc') {
                max_anime_num_pin = 100;
            }

            if (adding_list.length < max_anime_num_pin) {
                for (let shop of adding_list) {
                    let timer = setTimeout(add_marker.bind(this, shop, true), Math.random() * 300);
                    shop.timer = timer;
                }
            } else {
                
                for (let shop of adding_list) {
                    let timer = setTimeout(add_marker.bind(this, shop, false), Math.random() * 50);
                    shop.timer = timer;
                }
                
                // for (let shop of adding_list) {
                //     add_marker(shop, false);
                // }
            }

            // 画面内の消えた（間引かれた）マーカーを削除
            for (let shop of Object.values(_all_shop_hash)) {
                if (shop.exist == false) {
                    remove_flag(shop);
                }
            }
            // console.log("adding_list: ", adding_list.length);
            // console.log("list_bbox: ", list_bbox);
            // console.log("grouping: ", group);
            // console.log("============================");

            check_current_data(json.shops);
            // setTimeout(() => { // 既存ピンの再描画（必要であれば） 
            // // Menggambar ulang pin yang ada (jika diperlukan)
            //     update_hide_mark();
            // }, 50);
        }
    }
    
    const id_source = 'source-cluster';
    const id_layer = 'layer-cluster';
    function getGeoJson(geojson){
        if (map.getSource(id_source)) {
            map.getSource(id_source).setData(geojson);
        } else {
            map.addSource(id_source, {
                type: 'geojson',
                data: geojson,
                // buffer: 1, // I honestly don't know what this does
                // maxzoom: 14
            });
        }
        
        if (!map.getLayer('clusters')) {
            map.addLayer({
                id: "clusters",
                type: "circle",
                source: id_source,
                filter: ["has", "point_count"],
                paint: {
                    // "circle-color": {
                    //     property: select_value,
                    //     stops: colorStops
                    // },
                    "circle-color": "lightseagreen",
                    "circle-blur": ["case", ['==', ["feature-state", 'hover'], 1], 0, 0.55],
                    "circle-stroke-width": ["case", ['==', ["feature-state", 'hover'], 1], 1.5, 0],
                    "circle-stroke-color": ["case", ['==', ["feature-state", 'hover'], 1], "white", "rgba(0,0,0,0)"],
                    // "circle-radius": {
                    //     property: select_value,
                    //     type: "interval",
                    //     stops: radiusStops
                    // }
                    "circle-radius": 20,
                    "circle-stroke-width": 1,
                    "circle-stroke-color": "#fff"
                }
            });
        }
        
        if (!map.getLayer('unclustered-point')) {
            map.addLayer({
                id: "unclustered-point",
                type: "circle",
                source: id_source,
                filter: ["!has", "point_count"],
                paint: {
                    // "circle-color": {
                    //     property: propertyToAggregate,
                    //     stops: colorStops
                    // },
                    "circle-color": "red",
                    "circle-radius": 4,
                    "circle-stroke-width": 1,
                    "circle-stroke-color": "#fff"
                }
            });
        }

        if (!map.getLayer('cluster-count')) {
            map.addLayer({
                id: "cluster-count",
                type: "symbol",
                source: id_source,
                filter: ["has", "point_count"],
                // "glyphs": "mapbox://fonts/mapbox/Open%20Sans%20Bold/0-255.pbf",
                layout: {
                    // "text-field": "{" + select_value + "}",
                    "text-field": ["get", "point_count"],
                    // "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-font": ["Open Sans Bold"],
                    // "text-font": ["Open Sans Regular","Arial Unicode MS Regular"],
                    "text-size": 14
                },
                paint: {
                    "text-halo-color": "white",
                    "text-halo-width": 1
                }
            });
        }
    }

    function grouping_data(list_data){
        const shops = list_data.shops;
        const grouping = list_data.grouping;

        var uniqueArray = [];
        var uniqueJson = {};

        const ids = shops.map(({ dist }) => dist);
        const filtered = shops.filter(({ dist }, index) => !ids.includes(dist, index + 1));
        uniqueJson['by_dist'] = filtered;

        const hides = shops.map(({ hide }) => hide);
        const by_hide = shops.filter(({ hide }, index) => !hides.includes(hide, index + 1));
        uniqueJson['by_hide'] = by_hide;

        const by_hide_dist = shops.filter(({ hide, dist }, index) => !hides.includes(hide, index + 1) && !ids.includes(dist, index + 1));
        uniqueJson['by_hide_dist'] = by_hide_dist;

        var mm = shops.filter(
            (value, index, self) =>
                index === self.findIndex((t) => t.hide === value.hide && value.hide >= 3),
        );
        var m2 = shops.filter(
            (value, index, self) =>
                index === self.findIndex((t) => t.dist <= value.dist),
        );
        uniqueJson['by_unique_1'] = mm;
        uniqueJson['by_unique_2'] = m2;
        return uniqueJson;
    }
    
    function set_masterlist(json){
        // var point = turf.points(json.points);
        // var bbox = turf.bbox(point);
        // console.log("masterList: ", json, "\nbbox: ", bbox);
        // list_bbox.feat = point;
        // list_bbox.bbox = bbox;
        // list_bbox.list_poi = json.points;

        // list_bbox.bbox = []; // reset bbox
        // list_bbox.feat = null;
        if (list_bbox.list_poi.length > 0) {
            list_bbox.list_poi = [];
            set_masterlist(json);
        } else {
            for (const shop of json.shops) {
                list_bbox.list_poi.push([shop.lon, shop.lat]);
    
                var points_lon_lat = turf.points(list_bbox.list_poi);
                list_bbox.feat = points_lon_lat;
    
                var bb = turf.bbox(list_bbox.feat);
                list_bbox.bbox = bb;
                
                // var line = turf.lineString(list_bbox.list_poi);
                // list_bbox.line = line;

                // var bbp = turf.bboxPolygon(list_bbox.line);
                // list_bbox.bboxPoly = bbp;
            }
        }
    }
    
    function add_marker(shop, anime) {
        // if (shop.icon != null) {
        //     var fgs = shop.icon.split('flags/');
        //     var total_fgs = fgs.length;
        //     shop.orig_icon = shop.icon;
        //     // shop.hide_icon = "<?= base_url()?>flags_star/" + fgs[total_fgs-1];
        //     shop.hide_icon = "flags-star/" + fgs[total_fgs-1].replace(".png", "_star.png");
        //     // // shop.has_hidden = shop.has_hidden == true ? shop.hide_icon : shop.orig_icon;
        //     // update_hide_mark
        //     shop.icon = shop.has_hidden == true ? shop.hide_icon : shop.orig_icon;
        // }
        
        shop.orig_icon = shop.icon;
        shop.hide_icon = shop.icon_star;
        shop.icon = (shop.has_hidden == true && shop.cluster == true) ? shop.hide_icon : shop.orig_icon;
        // var rep_icon = shop.icon.replace('.png', '.webp');
        // console.log("icon: ", rep_icon);

        const icon_flag = 'assets/images/chain_marker/40x80/flag_7.png';
        let img = document.createElement('img');
        img.src = shop.icon;
        // img.src = icon_flag; 
        img.style.cursor = 'pointer';
        // img.style.zIndex = Math.floor((90.0 - shop.lat) * 10000000.0);
        img.style.zIndex = 0;
        // img.width = 40;
        // img.height = 80;
        // img.className = 'flag-marker';
        img.className = (shop.exist) ? 'flag-marker' : 'flag-marker d-none'; // <style buat tanda CSS

        // img.width = 80;
        img.height = 90;
        img.loading = "lazy";

        // img.width = 70;
        // img.height = 90;

        img.addEventListener('error', function handleError() {
            const defaultImage = 'flags/flag_not_found.png';
            img.src = defaultImage;
            img.alt = 'default';
        });

        if (typeof _always_small_size_pin !== 'undefined' && _always_small_size_pin == true) {
            img.width = 42;
            img.height = 50;
        }

        ////////////////////////////////////////////////////////////////////////////////
        // 跳ねる処理
        let init_height = 500;
        let init_v = -1.0;
        //let g = 0.05;
        let g = 0.004;
        let e = 0.4; // 反発率　

        function animateMarker(timestamp) {
            //console.log(timestamp, marker.anime_id, marker.anime_v, marker.anime_height);
            if (marker.anime_time == 0) {
                marker.anime_time = timestamp;
                requestAnimationFrame(animateMarker);
            } else {
                if (marker.anime_num_bounce < 2) { // 1回跳ねたら終わり
                    var t = timestamp - marker.anime_time;
                    marker.anime_time = timestamp;
                    marker.anime_v = marker.anime_v - g * t;
                    marker.anime_height = marker.anime_height + marker.anime_v * t;

                    if (marker.anime_height <= 0) {
                        marker.anime_height = 0;

                        var new_latlon = get_height_latlon(shop.lat, shop.lon, marker.anime_height);
                        marker.setLngLat(new_latlon);

                        marker.anime_num_bounce += 1;
                        marker.anime_v = -marker.anime_v * e;
                        requestAnimationFrame(animateMarker);
                    } else {
                        var new_latlon = get_height_latlon(shop.lat, shop.lon, marker.anime_height);
                        marker.setLngLat(new_latlon);
                        requestAnimationFrame(animateMarker);
                    }
                }
            }
        }

        let marker = new mapboxgl.Marker(img, {
            offset: [0, -img.height / 2]
        });

        if (anime == true) {
            var init_latlon = get_height_latlon(shop.lat, shop.lon, init_height);
            marker.setLngLat(init_latlon)
                .addTo(map);
        } else {
            marker.setLngLat([shop.lon, shop.lat])
                .addTo(map);
        }

        img.marker = marker;
        marker.img = img;
        marker.shop = shop;
        shop.marker = marker;

        // console.log("shop: ", shop);
        if (anime == true) {
            marker.anime_num_bounce = 0;
            marker.anime_time = 0;
            marker.anime_v = init_v;
            marker.anime_height = init_height;
            marker.anime_id = requestAnimationFrame(animateMarker);
        }

        //add_help_on_plus_mark(shop);

        img.addEventListener('click', function (e) {
            // console.log("popup: ", this.marker);
            open_popup(this.marker);
        });
    }
    
    function open_external_url(url) {
        var a = document.createElement("a");
        a.href = url;
        a.rel = "noopener noreferrer";
        a.target = "_blank";
        a.click();
    }
    
    const share_url = async(name) => {
        try {
            await window.navigator.share({
                title: name,
                text: `${document.title}\n\n${name}\n`,
                url: location.href,
            });
        } catch (e) {
            console.log(e.message);
        }
    }

    function isEmpty(string) {
        return typeof string === 'string' && string.length === 0;
    }

    function additional_info(json){
        var list_info = json.info.split(" |split| ");
        const open_hours = '<営業時間>';
        const holiday = '<定休日>';
        const parking = '<駐車場> [parking]';
        const smoking = '<喫煙> [smoking]';
        const handling = '<取り扱い>';
        const remarks = '<備考>';
        const list_key = [open_hours, holiday, parking, smoking, handling, remarks];
        var html_info = '';
        var obj = {}, all_obj = {};

        list_info.forEach((item, index) => {
            if (!isEmpty(item)) {
                obj[list_key[index]] = item;
            }
            all_obj[list_key[index]] = item;
        });
        
        const create_html = (key, val) => {
            console.log("total val: ", val.trim().length);
            var html = `
                <p class="text-muted mb-2">
                    <span style="font-weight: 700; color: #495057;">${key}</span>
                    <span>${val}</span>
                </p>`;
            return html;
        };
        
        const hide_parking_and_smoking = () => {
            for (const key in obj) {
                if (Object.hasOwnProperty.call(obj, key)) {
                    const e = obj[key];
                    // hide info parking area and smoking
                    if(key == parking){
                        Reflect.deleteProperty(obj, parking);
                    }
                    if(key == smoking){
                        Reflect.deleteProperty(obj, smoking);
                    }
                }
            }
        }
        hide_parking_and_smoking();

        for (const key in obj) {
            if (Object.hasOwnProperty.call(obj, key)) {
                const e = obj[key];
                html_info += create_html(key, e);
            }
        }
        
        return isEmpty(html_info) ? '<p class="text-muted mb-2"></p>' : html_info;
    }

    function open_popup(marker){
        const popup_height = parseInt(marker.img.height/1.3);
		var popup_options = {
			className: 'flag_popup',
			anchor: 'bottom',
			offset: popup_height,
		};
        var popup = new mapboxgl.Popup(popup_options);
        popup.marker = marker;
        marker.popup = popup;
        
        let json = marker.shop;
        let google_map = `https://www.google.com/maps/search/?api=1&query=${json.lat},${json.lon}`;
        let route = `https://www.google.com/maps/dir//${json.lat},${json.lon}`;
        let st_google_map = `https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=${json.lat},${json.lon}`;
        
        var share_title = `${json.name} ${json.store}`.trim();

        // var html_info = (json.info == '') ? `<p class="text-muted">${json.tel_no}</p>` : `<p class="text-muted">${json.info}<br/>${json.tel_no}</p>`;
        // var html_info = (json.info != '' && json.info != null) ? `<p class="text-muted"><span style="font-weight: 700; color: #495057;">営業時間 </span>${json.info}</p>` : '<p class="mb-2"></p>';
        var html_info = additional_info(json);
        const list_tag = json.tag_id.split("_");
        const li = json.li;
        let class_tag = '';
        if (li == 'フード') { // food
            class_tag = 'bg-warning';
        }
        else if (li == 'ショッピング') { // shopping
            class_tag = 'bg-info';
        }
        else if (li == 'サービス') { // service
            class_tag = 'bg-danger';
        } else {
            class_tag = 'bg-primary'; // default
        }

        var popup_html = `
            <div class="card-body p-1">
                <div class="mb-2 d-none">
                    <span class="badge rounded-pill ${class_tag} px-2 py-1" id="${json.tag_id}" onclick="onc(this)" style="cursor: pointer;">${json.name}</span>
                    <span class="badge rounded-pill ${class_tag} px-2 py-1" id="${list_tag[0]}_${list_tag[1]}" onclick="onc(this)" style="cursor: pointer;">${json.middle}</span>
                </div>
                <div class="mb-1">${json.name}</div>
                <div class="card-title text-primary mb-2">${json.store}</div>
                ${html_info}
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" title="ルート検索" onclick='open_external_url("${route}");'>
                        <i class='bx bxs-direction-right align-middle font-size-18'></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" title="ストリートビュー表示" onclick='open_external_url("${st_google_map}");'>
                        <i class="bx bx-street-view align-middle font-size-18"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" title="Google Map 表示" onclick='open_external_url("${google_map}");'>
                        <i class="bx bx-map-alt align-middle font-size-18"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" title="共有" onclick='share_url("${share_title}");'>
                        <i class="bx bx-share-alt align-middle font-size-18"></i>
                    </button>
                </div>
            </div>`;
        
        marker.popup.setHTML(popup_html).addTo(map);
        marker.setPopup(marker.popup);

        $(".badge").on('click', (e) => {
            var btn_close = marker.popup._closeButton;
            btn_close.click();
        });

        // // let url = '<?php base_url() ?>map/d/'+marker.shop.shop_id;
        // let url = `${ROOTS}/dd/${marker.shop.shop_id}`;
        // fetch(url).then(res => {return res.json()})
        // .then((result) => {
        //     // console.log("flag detail: ", json);
        //     let json = get_hashed(result);

        //     if (json != null || json != undefined) {                
        //         let google_map = `https://www.google.com/maps/search/?api=1&query=${json.lat},${json.lon}`;
        //         let route = `https://www.google.com/maps/dir//${json.lat},${json.lon}`;
        //         let st_google_map = `https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=${json.lat},${json.lon}`;
                
        //         var share_title = `${json.name} ${json.store}`.trim();

        //         // var html_info = (json.info == '') ? `<p class="text-muted">${json.tel_no}</p>` : `<p class="text-muted">${json.info}<br/>${json.tel_no}</p>`;
        //         // var html_info = (json.info != '' && json.info != null) ? `<p class="text-muted"><span style="font-weight: 700; color: #495057;">営業時間 </span>${json.info}</p>` : '<p class="mb-2"></p>';
        //         var html_info = additional_info(json);
        //         const list_tag = json.tag_id.split("_");
        //         const li = json.li;
        //         let class_tag = '';
        //         if (li == 'フード') { // food
        //             class_tag = 'bg-warning';
        //         }
        //         else if (li == 'ショッピング') { // shopping
        //             class_tag = 'bg-info';
        //         }
        //         else if (li == 'サービス') { // service
        //             class_tag = 'bg-danger';
        //         } else {
        //             class_tag = 'bg-primary'; // default
        //         }

        //         var popup_html = `
        //             <div class="card-body p-1">
        //                 <div class="mb-2 d-none">
        //                     <span class="badge rounded-pill ${class_tag} px-2 py-1" id="${json.tag_id}" onclick="onc(this)" style="cursor: pointer;">${json.name}</span>
        //                     <span class="badge rounded-pill ${class_tag} px-2 py-1" id="${list_tag[0]}_${list_tag[1]}" onclick="onc(this)" style="cursor: pointer;">${json.middle}</span>
        //                 </div>
        //                 <div class="mb-1">${json.name}</div>
        //                 <div class="card-title text-primary mb-2">${json.store}</div>
        //                 ${html_info}
        //                 <div class="d-flex justify-content-center">
        //                     <button type="button" class="btn btn-outline-primary btn-sm me-2" title="ルート検索" onclick='open_external_url("${route}");'>
        //                         <i class='bx bxs-direction-right align-middle font-size-18'></i>
        //                     </button>
        //                     <button type="button" class="btn btn-outline-primary btn-sm me-2" title="ストリートビュー表示" onclick='open_external_url("${st_google_map}");'>
        //                         <i class="bx bx-street-view align-middle font-size-18"></i>
        //                     </button>
        //                     <button type="button" class="btn btn-outline-primary btn-sm me-2" title="Google Map 表示" onclick='open_external_url("${google_map}");'>
        //                         <i class="bx bx-map-alt align-middle font-size-18"></i>
        //                     </button>
        //                     <button type="button" class="btn btn-outline-primary btn-sm me-2" title="共有" onclick='share_url("${share_title}");'>
        //                         <i class="bx bx-share-alt align-middle font-size-18"></i>
        //                     </button>
        //                 </div>
        //             </div>`;
                
        //         marker.popup.setHTML(popup_html).addTo(map);
        //         marker.setPopup(marker.popup);

        //         $(".badge").on('click', (e) => {
        //             var btn_close = marker.popup._closeButton;
        //             btn_close.click();
        //         });
        //     } else {
        //         return;
        //     }
        // });
    }
    
    function check_current_data(latest_data){
        for (let i = 0; i < latest_data.length; i++) {
            const latest_shop = latest_data[i];
            const latest_id = latest_shop.shop_id;
            const latest_cluster = latest_shop.cluster;
            const latest_has_hidden = latest_shop.has_hidden;
            
            let current_shop = _all_shop_hash[latest_id];
            let current_cluster = current_shop.cluster;
            let current_has_hidden = current_shop.has_hidden;

            // periksa jika ada yg tidak sama dgn data terbaru
            if (current_cluster != latest_cluster || current_has_hidden != latest_has_hidden) {
                _all_shop_hash[latest_id].cluster = latest_cluster;
                _all_shop_hash[latest_id].has_hidden = latest_has_hidden;
            }
        }
        
        setTimeout(() => { // 既存ピンの再描画（必要であれば） 
            // Menggambar ulang pin yang ada (jika diperlukan)
            update_hide_mark();
        }, 100);
    }

    // 表示中のピンの＋マークを更新する
    function update_hide_mark() {
        for (let shop of Object.values(_all_shop_hash)) {
            
            if (shop.has_hidden == false && shop.icon == shop.hide_icon) {
                shop.icon = shop.orig_icon;
                shop.marker.img.src = shop.icon;
                // remove_flag(shop);
                // console.log("hide: ", shop.has_hidden, shop);

            } else if (shop.has_hidden == true && shop.icon == shop.orig_icon) {
                shop.icon = shop.hide_icon;
                shop.marker.img.src = shop.icon;
            }
        }
    }

    function onc(e, a = true){
        var tag_id = $(e).attr('id');
        _current_tag_list[0] = tag_id;
        push_url();
        // console.log("onclick: ", $(e).children('span'));
        // const judul = ($(e).children('span').length == 0) ? $(e) : $(e).children('span');
        const judul = $(e);
        var def_class = ' p-1 font-size-xl align-middle';
        // console.log("judul: ", judul[0].innerText, a);
        // console.log("cs: ", $(e).children('i.bx'), "\n",$(e).children('i.bx')[0]);

        // if ($("input[type='search']").val() != '') {
        //     $("input[type='search']").val(null);
        //     $("#result_search").html(null);
        // }

        if (a && judul.length > 0) {
            get_menu(tag_id);
            // $("#card-tag").text(judul[0].innerText);
        }

        if ($(e).children('i.bx')[0] != undefined) {
            const cs = $(e).children('i.bx')[0].classList;
            if (cs[0] == 'bx') {
                $("#img_chain").addClass('d-none');
                $("#icon_chain").removeClass('d-none')
                // $("#icon_chain").attr('class', 'bx '+cs[1]+def_class);
                $("#icon_chain").attr('class', cs.value+def_class);
            } else {
                $("#img_chain").removeClass('d-none');
                $("#icon_chain").addClass('d-none');
            }
        }
    }

    function title_and_desc(title, desc, icon){
        $("#card-tag").text(title);
        $("#card-desc").text(desc);

        if (icon != 'all') {
            $("#icon_chain").addClass('d-none');
            $("#img_chain").removeClass('d-none').attr('src', icon);
            img_not_found($("#img_chain")[0]);
        } else {
            $("#icon_chain").removeClass('d-none');
            $("#img_chain").addClass('d-none');
        }
    }

    function img_not_found(img){
        // const img = document.getElementById('img_chain');
        // $(e).attr("src", 'flags/flag_not_found.png');
        img.addEventListener("error", function(event) {
            console.clear();
            console.log("error: ", img);
            event.target.src = "flags/flag_not_found.png"
            event.onerror = null
        });
    }

    function get_menu(id){
        var param = make_current_map_state();
        let z = Math.floor(map.getZoom()) + 1;
        let url = `${ROOTS}/ii?i=${id}&token=${refresh_token()}`;
        
        fetch(url).then((res) => {return res.json()})
        .then((result) => {
            let json = get_hashed(result);
            // console.log("menu: ", json);

            if (list_bbox.bbox.length != 0) {
                fit_bounds(list_bbox.bbox);
            }
            if (json.tag_title != null || json.tag_title != '') {
                title_and_desc(json.tag_title, json.tag_desc, json.tag_icon);
            }
            main_flag();
        });
    }
</script>

<!-- SCRIPT OTHER FUNCTION YG BERHUBUNGAN DGN MAP -->
<script type="text/javascript">

    function style_map(e){
        console.clear();
        const style_id = e.id;
        // console.log("style_map: ", style_id, e);

        set_active_style(e);
        
        if (style_id == 'default') {
            map.setStyle(MAIN_STYLE);
            sessionStorage.setItem('mb_style', MAIN_STYLE);
        } else {
            map.setStyle(STYLE_MAPBOX + style_id);
            sessionStorage.setItem('mb_style', STYLE_MAPBOX + style_id);
        }
        
    }

    const set_active_style = (e_active) => {
        const class_active = 'bg-secondary bg-soft';
        const all_item = document.querySelectorAll('.item_style');
        all_item.forEach((el) => {
            $(el).removeClass(class_active);
        });
        $(e_active).addClass(class_active);
    }

    function load_style(){
        var sp_style = get_style_map.split("/");
        var is_mapbox = sp_style[3];
        var get_id = '';

        if (is_mapbox == 'mapbox') {
            // style from mapbox
            get_id = $("#"+sp_style[sp_style.length-1]);
        } else {
            // default
            get_id = $("#default");
        }
        set_active_style(get_id[0]);
    }
    load_style();

    function zoom_in(lat, lon, z) {
        if (z <= 3) {
            z = 4;
        }
        fly_to(lat, lon, z);
    }
    
    function fit_bounds(bbox = null){
        if (bbox != null) {
            // map.fitBounds(bbox, {padding: 60});
            map.fitBounds(bbox, {linear: true});
        } else {
            map.fitBounds(list_bbox.bbox, {linear: true});
        }
        // else if(bbox == null && list_bbox.bbox.length > 0) {
        //     map.fitBounds(list_bbox.bbox, {padding: 10});
        // }
    }
    
    function fly_to(lat, lon, z) {
        var new_z = z;
        if (map.scrollZoom.isEnabled() == false) {
            new_z = map.getZoom();
        }
        
        //map.setZoom(new_z);
        //map.panTo([lon, lat]);

        map.flyTo({
            center: [lon, lat],
            zoom: new_z,
            speed: 3,
            essential: true,
        });
    }

    function to_point(lat, lon) {
        return map.project([lon, lat]);
    }

    function to_latlon(x, y) {
        return map.unproject([x, y]);
    }

    function get_height_latlon(lat, lon, height) {
        var {
            x: x,
            y: y
        } = to_point(lat, lon);
        y = y - height;
        return to_latlon(x, y);
    }
</script>
