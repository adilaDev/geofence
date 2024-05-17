<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="card-title mb-4">Super Dynamic DataTable</div>
                            
                            <div class="dropdown ms-2 float-end">
                                <button type="button" class="btn btn-primary waves-effect" id="search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify font-size-18"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="search-dropdown">

                                    <form class="p-3">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input type="search" class="form-control" id="searchInput" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button id="addRowBtn" class="btn btn-info btn-sm waves-effect waves-light me-1">Add Row</button>
                                <button id="saveAll" class="btn btn-primary btn-sm waves-effect waves-light me-1">Save All</button>
                            </div>
                            <div id="superDynamic" class="table-responsive mb-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<!-- All CSS Editable DT -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
<link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css"> -->

<!-- All JS Editable DT -->
<!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script> -->

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Required datatable js -->
<script src="<?=base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="<?=base_url()?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?=base_url()?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Required scroller datatable js -->
<link href="https://cdn.datatables.net/scroller/2.3.0/css/scroller.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/scroller/2.3.0/js/dataTables.scroller.min.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuP573ebN6ZJTbs3IGcW2G-zgiBH4pp0Q&libraries=places&callback=initPlacesSearch"></script>
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqRYyf2UD8U7Ow80y7Un-MmfBt4HHGpTM&libraries=places&callback=initPlacesSearch"></script> -->

<script>
    function initPlacesSearch() {
        var input = document.getElementById('searchInput');
        var searchBox = new google.maps.places.SearchBox(input);
        // var searchBox = new google.maps.places.Autocomplete(input);
        
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            
            if (places.length === 0) {
                return;
            }

            // Dapatkan koordinat dari tempat yang dipilih
            var place = places;
            var location = places[0].geometry.location;
            var latitude = location.lat();
            var longitude = location.lng();

            // Lakukan apa pun yang Anda inginkan dengan koordinat ini
            console.log('place:', place);
            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
            addMarkerGeolocation(place[0]);
        });
    }

    function addMarkerGeolocation(place) {
        const location = place.geometry.location;
        const viewport = place.geometry.viewport;
        
        var lokasi = [location.lng(), location.lat()];
        // var bbox_viewport = [viewport.Bb, viewport.Va];
        var bbox_viewport = [viewport.La, viewport.eb];
        
        console.log("Lokasi: ", lokasi);
        console.log("bbox: ", bbox_viewport);
        // marker_gmap.remove();
        // marker_gmap.setLngLat(lokasi).addTo(map);

        // map.flyTo({
        //     center: lokasi,
        //     zoom: 12
        // });
    }
    $(document).ready(function() {
        initPlacesSearch();
    });
</script>

<script>
    const center = [106.89982384391512, -6.186337140600409];
    const TOKEN_MAP = "<?= token_mapbox ?>";
    var featureCollection = {
        "type": "FeatureCollection",
        "features": [
            {
                "id": "1545089bbe626eb988c818bf185a5577",
                "type": "Feature",
                "properties": {
                },
                "geometry": {
                    "coordinates": [
                        [
                            [
                                106.87464757312557,
                                -6.157816458830652
                            ],
                            [
                                106.92749504342657,
                                -6.155769342493144
                            ],
                            [
                                106.92200439716089,
                                -6.220590849169412
                            ],
                            [
                                106.87190224999495,
                                -6.21172100791776
                            ],
                            [
                                106.87464757312557,
                                -6.157816458830652
                            ]
                        ]
                    ],
                    "type": "Polygon"
                }
            }
        ]
    }
    var features = featureCollection.features[0];

    $(document).ready(function() {
        // geocodingApi(center);
        loadEditable();
        var dummyData = [
            {"key": '', "value": '', 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'},
            {"key": '', "value": '', 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'},
        ];
        // superDynamicDT(dummyData);
        
        // geoAPI(center).then((data) => {
        //     console.log("geoAPI finally: ", data);
        //     var result = data.features;
        //     var geocodeToDataTable = [];

        //     if (result.length > 0) {
        //         var locationInfo = result[0].context;

        //         // Setel propertis GeoJSON dengan informasi lokasi
        //         var properties = {};

        //         geocodeToDataTable.push({"no": 1, "key": "address", "value": result[0].properties.address, 'action': ''});
        //         geocodeToDataTable.push({"no": 2, "key": "place name", "value": result[0].place_name, 'action': ''});
        //         var no = 2;
        //         for (var i = 0; i < locationInfo.length; i++) {
        //             var type = locationInfo[i].id.split('.')[0];
        //             var value = locationInfo[i].text;
        //             // features.properties[type] = value;
        //             properties[type] = value;
        //             // geocodeToDataTable.push([type, value]);
        //             geocodeToDataTable.push({"no": no++, "key": type, "value": value, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
        //         }
        //         // tambahkan place name & address
        //         properties["place_name"] = result[0].place_name;
        //         properties["address"] =  result[0].properties.address;

        //         console.log('Properties:', properties);
        //         console.log('geocodeToDataTable:', geocodeToDataTable);

        //         // superDynamicDT([properties]);
        //         superDynamicDT(geocodeToDataTable);
        //     }
        // });

        geoAPIgoogle(center).then((data) => {
            var geocodeToDataTable = [];
            var results = data.results;
            var list_main = results[0];
            var list_address = results[0].address_components;

            // geocodeToDataTable.push({'no': 1, 'key': 'formatted_address', 'value': list_main.formatted_address, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            var no = 0;
            // dapatkan semua informasi formatted_address
            for (let i = 0; i < results.length; i++) {
                const item = results[i];
                const key = Object.keys(item)[i];
                const value = item.formatted_address;
                no++;

                geocodeToDataTable.push({'no': no, 'key': "formatted_address_"+no, 'value': value, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            }

            // for (let i = 0; i < list_address.length; i++) {
            //     const item = list_address[i];
            //     const key = item.types[0];
            //     const value = item.long_name;

            //     geocodeToDataTable.push({'no': no++, 'key': key, 'value': value, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            // }

            console.log("API GoogleMap: ", data);
            console.log("API Gmap: ", geocodeToDataTable);
            superDynamicDT(geocodeToDataTable);
        });
    });

    function superDynamicDT(data = []){
        if (data.length == 0) {
            var data = [
                { name: 'John Doe', position: 'Developer', office: 'New York', age: 30, start_date: '2023-01-01', salary: 50000 },
                { name: 'Jane Doe', position: 'Designer', office: 'London', age: 28, start_date: '2023-02-01', salary: 45000 }
                // Add more data as needed
            ];
        }

        // Create table dynamically
        var table = $('<table>').attr('id', 'dynamic_table').attr('class', 'table table-sm table-bordered table-striped border-secondary w-100').addClass('display').attr("style", "border-collapse: collapse !important;");
        var thead = $('<thead>').appendTo(table);
        var tbody = $('<tbody>').appendTo(table);

        var headerRow = $('<tr>').appendTo(thead);
        // Add headers dynamically
        Object.keys(data[0]).forEach(function(key) {
            $('<th>').text(key.replace('_', ' ')).appendTo(headerRow);
        });

        // Add data to tbody
        data.forEach(function(item) {
            var row = $('<tr>').appendTo(tbody);
            Object.values(item).forEach(function(value) {
                // $('<td>').attr('contenteditable', (value != "")).text(value).appendTo(row);
                $('<td>').text(value).appendTo(row);
            });
            $(row).find('td').each(function(index, val) {
                // Set contenteditable to true unless it's the 'action' column
                $(this).attr('contenteditable', index !== Object.keys(data[0]).indexOf('action'));
            });
        });

        // Append table to the body
        table.appendTo('body');
        $("#superDynamic").append(table);

        // Initialize DataTable
        var tables = $(table).DataTable({
            scrollX: true,
            scrollY: '56vh',
            // scrollY: '32vh',
            scrollCollapse: true,
            fixedHeader: true,
            responsive: true,
            columns: [
                { data: 'no' },
                { data: 'key' },
                { data: 'value'},
                {
                    data: 'action',
                    render: function (data, type, row, col) {
                        // console.log("render data: ", data, "\ntype: ", type, "\nrow: ", row, "\ncol: ", col);
                        // return '<a class="btn btn-outline-secondary btn-sm edit me-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>' +
                        //         '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                        return '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }
                }
            ],
            columnDefs: [{
                // "targets": "_all",
                targets: [0, 1],
                className: "editables",
            }],
            destroy: true,
            select: false,
            paging: false,
            // lengthMenu: [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, 'All'],
            // ],
        });
        // $(tables.buttons().container()).children().removeClass('btn-secondary').addClass("btn-primary btn-sm");
        // tables.buttons().container().addClass('ms-md-3').appendTo('#example_filter');
        // $(".dataTables_length select").addClass('form-select form-select-sm');

        $('#saveAll').on('click', function () {
            // Simpan data yang sedang diedit ke DataTable
            // $('#dynamic_table td[contenteditable=true]').trigger('blur');
            var allData = tables.rows().data().toArray();
            console.log("saveAll click: ", $(this), " allData: ", allData);
        });

        // $(document).on('blur', '#dynamic_table td[contenteditable=true]', function() {
        //     var cellValue = $(this).text();
        //     var rowIndex = $(this).parent().index();
        //     var colIndex = $(this).index();

        //     // Update data di DataTable
        //     // tables.cell(rowIndex, colIndex).data(cellValue).draw();
        //     tables.rows('.selected').data(cellValue).draw();
        //     var allData = tables.rows().data().toArray();

        //     console.log("this: ", $(this));
        //     console.log("allData: ", allData);
        //     console.log("cellValue: ", cellValue);
        //     console.log("rowIndex: ", rowIndex, " colIndex: ", colIndex);
            
        //     // var xdata = tables.row($(this).closest('tr')).data();
        //     // console.log("xdata: ", xdata);
        // });

        $('#dynamic_table').on('blur', 'tbody tr', function (e) {
            var child =  $(this).children();
            var newData = {'no': '', 'key': '', 'value': '', 'action': '&lt;a class="btn btn-outline-danger btn-sm delete" title="Delete"&gt;&lt;i class="fas fa-trash-alt"&gt;&lt;/i&gt;&lt;/a&gt;'};
            const no = $(child[0]).text();
            const key = $(child[1]).text();
            const val = $(child[2]).text();
            newData.no = no;
            newData.key = key;
            newData.value = val;

            var edit = tables.row(this)
            .data(newData).draw();
            console.log("edit: ", edit, "\nnewData: ",newData);
        });

        $('#dynamic_table tbody').on('click', 'a.delete', function () {
            tables.row($(this).parents('tr')).remove().draw();
        });

        $('#addRowBtn').on('click', function() {
            var allData = tables.rows().data().toArray();
            var lastData = allData[allData.length-1];
            var no = parseInt(lastData.no)+1;
            console.log("lastData: ", lastData);

            // Buat baris kosong baru
            var newRowData = {'no': no, 'key': '', 'value': '', 'action': ''};
            // Object.keys(data[0]).forEach(function(key) {
            //     newRowData[key] = '';
            // });

            // Tambahkan baris baru ke awal DataTable
            var newRow = tables.row.add(newRowData).draw().node();

            // Tetapkan atribut yang dapat diedit untuk setiap sel di baris baru
            // $(newRow).find('td').attr('contenteditable', true);
            
            // Tetapkan atribut yang dapat diedit untuk setiap sel di baris baru
            $(newRow).find('td').each(function(index) {
                // Setel contenteditable ke true kecuali kolom 'action'
                $(this).attr('contenteditable', index !== Object.keys(data[0]).indexOf('action'));
            });


            // Add new empty row to the top of the tbody
            tbody.prepend(newRow);
        });
    }

    function loadEditable(){
        var table = $('#example').DataTable({
            // ajax: {
            //     url: 'your_server_script_to_fetch_data.php',
            //     type: 'POST'
            // },
            data: [
                {
                    "DT_RowId": "row_1",
                    "first_name": "Tiger",
                    "last_name": "Nixon",
                    "position": "System Architect",
                    "email": "t.nixon@datatables.net",
                    "office": "Edinburgh",
                    "extn": "5421",
                    "age": "61",
                    "salary": "320800",
                    "start_date": "2011-04-25"
                },
                {
                    "DT_RowId": "row_2",
                    "first_name": "Garrett",
                    "last_name": "Winters",
                    "position": "Accountant",
                    "email": "g.winters@datatables.net",
                    "office": "Tokyo",
                    "extn": "8422",
                    "age": "63",
                    "salary": "170750",
                    "start_date": "2011-07-25"
                },
                {
                    "DT_RowId": "row_3",
                    "first_name": "Ashton",
                    "last_name": "Cox",
                    "position": "Junior Technical Author",
                    "email": "a.cox@datatables.net",
                    "office": "San Francisco",
                    "extn": "1562",
                    "age": "66",
                    "salary": "86000",
                    "start_date": "2009-01-12"
                }
            ],
            columns: [
                // {
                //     data: null,
                //     defaultContent: '',
                //     className: 'select-checkbox',
                //     orderable: false
                // },
                { data: 'DT_RowId' },
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'position' },
                { data: 'office' },
                { data: 'start_date' },
                { data: 'salary', render: DataTable.render.number(null, null, 0, '$') }
            ],
            select: false,
            columnDefs: [{
                "targets": "_all",
                "className": "editable"
            }],
            // dom: 'Bfrtip',
            // buttons: [
            //     { extend: 'create', editor: editor },
            //     { extend: 'edit',   editor: editor },
            //     { extend: 'remove', editor: editor }
            // ]
        });
        console.log("table: ", table);

        // Initialize DataTable Editor
        // Make cells editable on click
        $('#example').on('click', 'td.editable', function () {
            var cell = table.cell(this);
            var columnIndex = cell.index().column;
            var rowIndex = cell.index().row;

            var currentData = cell.data();
            var newData = prompt('Edit data:', currentData);

            if (newData !== null) {
                cell.data(newData).draw();

                // Update data on the server
                // You need to implement the server-side logic to update data
                // You can use AJAX to send the updated data to the server
                // Example:
                // $.ajax({
                //     url: 'your_server_script_to_handle_edit.php',
                //     type: 'POST',
                //     data: { rowIndex: rowIndex, columnIndex: columnIndex, newData: newData },
                //     success: function(response) {
                //         console.log('Data updated successfully');
                //     }
                // });
                var editable = {
                    "cell": cell,
                    "columnIndex": columnIndex,
                    "rowIndex": rowIndex,
                    "currentData": currentData,
                    "newData": newData,
                }
                console.log("editable click: ", editable);
            }
        });
        // console.log("editor: ", editor);

        // const editor = new DataTable.Editor({
        //     ajax: '../php/staff.php',
        //     fields: [
        //         {
        //             label: 'First name:',
        //             name: 'first_name'
        //         },
        //         {
        //             label: 'Last name:',
        //             name: 'last_name'
        //         },
        //         {
        //             label: 'Position:',
        //             name: 'position'
        //         },
        //         {
        //             label: 'Office:',
        //             name: 'office'
        //         },
        //         {
        //             label: 'Extension:',
        //             name: 'extn'
        //         },
        //         {
        //             label: 'Start date:',
        //             name: 'start_date',
        //             type: 'datetime'
        //         },
        //         {
        //             label: 'Salary:',
        //             name: 'salary'
        //         }
        //     ],
        //     table: '#example'
        // });
        
        // const table = new DataTable('#example', {
        //     ajax: '../php/staff.php',
        //     buttons: [
        //         { extend: 'create', editor },
        //         { extend: 'edit', editor },
        //         { extend: 'remove', editor }
        //     ],
        //     columns: [
        //         {
        //             data: null,
        //             defaultContent: '',
        //             className: 'select-checkbox',
        //             orderable: false
        //         },
        //         { data: 'first_name' },
        //         { data: 'last_name' },
        //         { data: 'position' },
        //         { data: 'office' },
        //         { data: 'start_date' },
        //         { data: 'salary', render: DataTable.render.number(null, null, 0, '$') }
        //     ],
        //     dom: 'Bfrtip',
        //     order: [1, 'asc'],
        //     select: {
        //         style: 'os',
        //         selector: 'td:first-child'
        //     }
        // });
        
        // // Activate the bubble editor on click of a table cell
        // table.on('click', 'tbody td:not(:first-child)', function (e) {
        //     editor.bubble(this);
        // });
    }

    function geoAPI(centerCoord){
        // Panggil API Geocoding untuk mendapatkan informasi lokasi
        var apiUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + centerCoord[0] + ',' + centerCoord[1] +
        '.json?access_token='+TOKEN_MAP;

        var geocodeToDataTable = [];

        return fetch(apiUrl)
        .then(response => response.json());
    }

    function geoAPIgoogle(centerCoord){
        // Panggil API Geocoding untuk mendapatkan informasi lokasi
        var lat = centerCoord[1];
        var lon = centerCoord[0];
        var api_key = 'AIzaSyDqRYyf2UD8U7Ow80y7Un-MmfBt4HHGpTM';
        var lang = 'en'; // en atau ja
        var apiUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&language=${lang}&result_type=street_address|political&key=${api_key}`;

        var geocodeToDataTable = [];

        return fetch(apiUrl)
        .then(response => response.json());
    }

    // function geocodingApi(features){
    function geocodingApi(centerCoord){
        // var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        // var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        console.log("centerCoord: ", centerCoord);
        var geocodeToDataTable = [];
        
        // Panggil API Geocoding untuk mendapatkan informasi lokasi
        var apiUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + centerCoord[0] + ',' + centerCoord[1] +
        '.json?access_token='+TOKEN_MAP;

        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            console.log("result geocoding: ", data);
            // Ambil informasi lokasi dari respons API
            var result = data.features;
            if (result.length > 0) {
                var locationInfo = result[0].context;

                // Setel propertis GeoJSON dengan informasi lokasi
                // features.properties = {};
                var properties = {};

                for (var i = 0; i < locationInfo.length; i++) {
                    var type = locationInfo[i].id.split('.')[0];
                    var value = locationInfo[i].text;
                    // features.properties[type] = value;
                    properties[type] = value;
                    geocodeToDataTable.push([type, value]);
                }
                // tambahkan place name & address
                // features.properties["place_name"] = result[0].place_name;
                // features.properties["address"] =  result[0].properties.address;
                properties["place_name"] = result[0].place_name;
                properties["address"] =  result[0].properties.address;

                // Tampilkan informasi propertis di konsol atau lakukan sesuatu yang lain
                // console.log('Properties:', features.properties);
                console.log('Properties:', properties);
                console.log('geocodeToDataTable:', geocodeToDataTable);
            }
            return geocodeToDataTable;
        })
        .catch((error) => {
            console.error('Error:', error)
            return error;
        });
    }
</script>


