<div class="main-content">
    <div class="page-content p-0 pt-4">
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Detail View</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau</a></li>
                                <li class="breadcrumb-item active">Detail View</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card-title">Demo Tableau (Embeded API)</div>
                    <div class="card card-effect">
                        <div class="card-body">
                                <div class="row">
                                    <div class="card-title mb-2">Menu</div>
                                    <div class="col mb-3" id="colBtn"></div>
                                </div>
                                <!-- Initialization of the Tableau visualization. -->
                                <div style="width:100%; height:100%;">
                                    <tableau-viz id="viz" hide-tabs></tableau-viz>
                                </div>
                                <!-- Buttons to show the previous or next visualization. -->
                                <div id="controls" style="padding:20px;">
                                    <button class="btn btn-outline-primary w-lg btn-sm waves-effect waves-light me-2" id="previous">Previous</button>
                                    <button class="btn btn-primary w-lg btn-sm waves-effect waves-light me-2" id="next">Next</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<!-- <script src="https://public.tableau.com/javascripts/api/tableau-2.js"></script>
<script type="module" src="https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.js"></script> -->

<!-- 
Referensi API Embeded Tableau v3
- https://embedded.tableau.com/resources/
- https://help.tableau.com/current/api/embedding_api/en-us/tutorial/tutorial.htm (With Demo)
- https://help.tableau.com/samples/en-us/js_api/tutorial.htm (With Demo tableau v2)
- https://github.com/tableau/embedding-api-v3-samples
- https://github.com/tableau/js-api-samples
- https://github.com/wjsutton/tableau_public_api
- https://github.com/tableau/rest-api-samples/tree/master
- https://help.tableau.com/current/api/embedding_api/en-us/docs/embedding_api_web_authoring.html
- https://help.tableau.com/current/api/embedding_api/en-us/docs/embedding_api_configure.html
- https://help.tableau.com/current/api/embedding_api/en-us/index.html?_gl=1*ljhxgx*_ga*NTUzNTE4ODQwLjE3MDU0NTY1MDE.*_ga_8YLN0SNXVS*MTcwNTQ1NjUwMS4xLjEuMTcwNTQ1NjYwNy4wLjAuMA..#1-link-to-the-embedding-api-library
- https://help.tableau.com/current/online/en-us/users_site_roles.htm
- https://help.tableau.com/samples/en-us/js_api/tutorial.js
-->

<script type="module">
    import {
        FilterUpdateType,
        TableauDialogType,
        TableauEventType,
        SelectionUpdateType,
        SheetSizeBehavior,
    } from "https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.js";

    ////////////////////////////////////////////////////////////////////////////////
    // Global Variables

    let viz, workbook, activeSheet;

    ////////////////////////////////////////////////////////////////////////////////
    // 1 - Create a View

    export function initializeViz() {
        viz = document.getElementById("viz");
        // viz.width = 1200;
        // viz.width = 800;
        viz.hideTabs = true;
        viz.hideToolbar = true;

        const onFirstInteractive = () => {
            workbook = viz.workbook;
            activeSheet = workbook.activeSheet;
            console.log(workbook);
            console.log(activeSheet);
            console.log("name: ", activeSheet.name);
            console.log("info: ", activeSheet._sheetImpl._sheetInfoImpl);
            console.log("_visualId: ", activeSheet._sheetImpl._visualId);
            querySheets();
            // switchToMapTab("House Price");
        };

        viz.addEventListener(TableauEventType.FirstInteractive, onFirstInteractive);
        // viz.src = "https://public.tableau.com/views/WorldIndicators/GDPpercapita";
        viz.src = "https://public.tableau.com/views/SCBusinessInsightsSample/ProductInformation";
    }
    $(initializeViz);

    ////////////////////////////////////////////////////////////////////////////////
    // 2 - Filter

    export async function filterSingleValue() {
        await activeSheet.applyFilterAsync("Region", ["The Americas"], FilterUpdateType.Replace);
    }

    export async function addValuesToFilter() {
        await activeSheet.applyFilterAsync("Region", ["Europe", "Middle East"], FilterUpdateType.Add);
    }

    export async function removeValuesFromFilter() {
        await activeSheet.applyFilterAsync("Region", ["Europe"], FilterUpdateType.Remove);
    }

    export async function filterRangeOfValues() {
        await activeSheet.applyRangeFilterAsync(
            "F: GDP per capita (curr $)",
            {
            min: 40000,
            max: 60000,
            },
            FilterUpdateType.Replace
        );
    }

    export async function clearFilters() {
        await activeSheet.clearFilterAsync("Region");
        await activeSheet.clearFilterAsync("F: GDP per capita (curr $)");
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 3 - Switch Tabs

    async function switchToMapTab(name) {
        await workbook.activateSheetAsync(name);
        // await workbook.activateSheetAsync("GDP per capita map");
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 4 - Select

    export async function selectSingleValue() {
        const selections = [
            {
            fieldName: "Region",
            value: "Asia",
            },
        ];

        await workbook.activeSheet.selectMarksByValueAsync(selections, SelectionUpdateType.Replace);
    }

    export async function addValuesToSelection() {
        const selections = [
            {
            fieldName: "Region",
            value: ["Africa", "Oceania"],
            },
        ];

        await workbook.activeSheet.selectMarksByValueAsync(selections, SelectionUpdateType.Add);
    }

    export async function removeFromSelection() {
        // Remove all of the areas where the GDP is < 5000.
        const selections = [
            {
            fieldName: "AVG(F: GDP per capita (curr $))",
            value: {
                min: 0,
                max: 5000,
            },
            },
        ];

        await workbook.activeSheet.selectMarksByValueAsync(selections, SelectionUpdateType.Remove);
    }

    export async function clearSelection() {
        await workbook.activeSheet.clearSelectedMarksAsync();
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 5 - Chain Calls

    export async function switchTabsThenFilterThenSelectMarks() {
        const newSheet = await workbook.activateSheetAsync("GDP per capita by region");
        activeSheet = newSheet;

        // It's important to await the promise so the next step
        // won't be called until the filter completes.
        await activeSheet.applyRangeFilterAsync(
            "Date (year)",
            {
            min: new Date(Date.UTC(2002, 1, 1)),
            max: new Date(Date.UTC(2008, 12, 31)),
            },
            FilterUpdateType.Replace
        );

        const selections = [
            {
            fieldName: "AGG(GDP per capita (weighted))",
            value: {
                min: 20000,
                max: Infinity,
            },
            },
        ];

        return await activeSheet.selectMarksByValueAsync(selections, SelectionUpdateType.Replace);
    }

    export async function triggerError() {
        await workbook.activateSheetAsync("GDP per capita by region");

        // Do something that will cause an error.
        try {
            await activeSheet.applyFilterAsync("Date (year)", [2008], "invalid");
        } catch (err) {
            alert(`We purposely triggered this error to show how error handling happens.\n\n${err}`);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 6 - Sheets
    function loaded(e){
        var el = e.target;
        console.log("loaded: ", el.textContent);
        
        $(".btn-menu-tableau").removeClass('btn-primary').addClass('btn-outline-primary'); // hapus semua 
        $(el).removeClass('btn-outline-primary').addClass('btn-primary'); // baru tambahkan tombol active
        switchToMapTab(el.textContent);
    }

    var inter = setInterval(() => {
        var jx = $(".btn-menu-tableau");
        var x = document.getElementsByClassName("btn-menu-tableau");
        if (x.length > 0) {
            clearInterval(inter);
            jx.on('click', loaded);

            // for (let i = 0; i < x.length; i++) {
            //     const el = x[i];
            //     el.addEventListener('click', function (e){
            //         jx.removeClass('btn-primary').addClass('btn-outline-primary');
            //         $(el).removeClass('btn-outline-primary').addClass('btn-primary');
            //         switchToMapTab(el.textContent);
            //         console.log("click: ", el.textContent);
            //     });
            // }
            // console.log("load: ", x);
        }
    }, 1000);

    export async function getSheetsAlertText(sheets) {
        const alertText = [];
        var btnHtml = "";

        for (let i = 0, len = sheets.length; i < len; i++) {
            const sheet = sheets[i];
            alertText.push(`  Sheet ${i}`);
            alertText.push(` (${sheet.sheetType})`);
            alertText.push(` - ${sheet.name}`);
            alertText.push("\n");
            // alertText.push(`,${sheet.name}`);
            if (sheet.name == 'Genaral Information') {
                btnHtml = `<button type="button" class="btn btn-primary btn-menu-tableau btn-sm waves-effect waves-light me-2 mb-2">${sheet.name}</button>`;
            } else {
                btnHtml = `<button type="button" class="btn btn-outline-primary btn-menu-tableau btn-sm waves-effect waves-light me-2 mb-2">${sheet.name}</button>`;
            }
            $("#colBtn").append(btnHtml);
        }


        return alertText.join("");
    }

    export function querySheets() {
        const sheets = workbook.publishedSheetsInfo;
        let text = getSheetsAlertText(sheets);
        // text = `Sheets in the workbook:\n${text}`;
        // alert(text);
        console.log(text);
        console.log(sheets);
        return {"txt": text }
    }

    export async function queryDashboard() {
        // Notice that the filter is still applied on the "GDP per capita by region"
        // worksheet in the dashboard, but the marks are not selected.
        const dashboard = await workbook.activateSheetAsync("GDP per Capita Dashboard");
        const worksheets = dashboard.worksheets;
        let text = getSheetsAlertText(worksheets);
        text = "Worksheets in the dashboard:\n" + text;
        alert(text);
    }

    export async function changeDashboardSize() {
        const dashboard = await workbook.activateSheetAsync("GDP per Capita Dashboard");
        await dashboard.changeSizeAsync({
            behavior: SheetSizeBehavior.Automatic,
        });
    }

    export async function changeDashboard() {
        var alertText = [
            "After you click OK, the following things will happen: ",
            "  1) Region will be set to Middle East.",
            "  2) On the map, the year will be set to 2010.",
            "  3) On the bottom worksheet, the filter will be cleared.",
            "  4) On the bottom worksheet, Region will be set to Middle East.",
        ];
        alert(alertText.join("\n"));

        const dashboard = await workbook.activateSheetAsync("GDP per Capita Dashboard");
        const mapSheet = dashboard.worksheets.find((w) => w.name === "Map of GDP per capita");
        const graphSheet = dashboard.worksheets.find((w) => w.name === "GDP per capita by region");

        await mapSheet.applyFilterAsync("Region", ["Middle East"], FilterUpdateType.Replace);

        // Do these two steps in parallel since they work on different sheets.
        await Promise.all([
            mapSheet.applyFilterAsync("YEAR(Date (year))", [2010], FilterUpdateType.Replace),
            graphSheet.clearFilterAsync("Date (year)"),
        ]);

        const selections = [
            {
            fieldName: "Region",
            value: "Middle East",
            },
        ];

        return await graphSheet.selectMarksByValueAsync(selections, SelectionUpdateType.Replace);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 7 - Control the Toolbar

    export async function exportPDF() {
        await viz.displayDialogAsync(TableauDialogType.ExportPDF);
    }

    export async function exportImage() {
        await viz.exportImageAsync();
    }

    export async function exportCrossTab() {
        await viz.displayDialogAsync(TableauDialogType.ExportCrossTab);
    }

    export async function exportData() {
        await viz.displayDialogAsync(TableauDialogType.ExportData);
    }

    export async function revertAll() {
        await workbook.revertAllAsync();
    }

    ////////////////////////////////////////////////////////////////////////////////
    // 8 - Events

    export function listenToMarksSelection() {
        viz.addEventListener(TableauEventType.MarkSelectionChanged, onMarksSelection);
    }

    export async function onMarksSelection(marksEvent) {
        const marks = await marksEvent.detail.getMarksAsync();
        reportSelectedMarks(marks);
    }

    export function reportSelectedMarks(marks) {
        let html = [];
        marks.data.forEach((markDatum) => {
            const marks = markDatum.data.map((mark, index) => {
            return {
                index,
                pairs: mark.map((dataValue, dataValueIndex) => {
                return {
                    fieldName: markDatum.columns[dataValueIndex].fieldName,
                    formattedValue: dataValue.formattedValue,
                };
                }),
            };
            });

            marks.forEach((mark) => {
            html.push(`<b>Mark ${mark.index}:</b><ul>`);

            mark.pairs.forEach((pair) => {
                html.push(`<li><b>fieldName:</b> ${pair.fieldName}`);
                html.push(`<br/><b>formattedValue:</b> ${pair.formattedValue}</li>`);
            });

            html.push("</ul>");
            });
        });

        const dialog = $("#dialog");
        dialog.html(html.join(""));
        dialog.dialog("open");
    }

    export function removeMarksSelectionEventListener() {
        viz.removeEventListener(TableauEventType.MarkSelectionChanged, onMarksSelection);
    }
</script>

<!-- <script type="module">
    // TableauEventType represents the type of Tableau embedding event that can be listened for.
    import { TableauViz, TableauEventType } from "https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.js";

    // List of visualizations to cycle through.
    const vizList = ["https://public.tableau.com/views/RegionalSampleWorkbook/Flights",
        "https://public.tableau.com/views/RegionalSampleWorkbook/Obesity",
        "https://public.tableau.com/views/RegionalSampleWorkbook/College",
        "https://public.tableau.com/views/RegionalSampleWorkbook/Stocks",
        "https://public.tableau.com/views/RegionalSampleWorkbook/Storms"];

    let vizLen = vizList.length, vizCount = 0;
    let vizDiv = document.getElementById("tableauViz");
    const viz = new TableauViz();

    function handleFirstInteractive(e) {
        // workbook = viz.getWorkbook();
        // activeSheet = workbook.getActiveSheet();
        console.log(`Viz loaded: ${viz.src}`);
        console.log(`Viz activeSheet: ${viz.getAttributeEvents()}`);
        console.dir(viz);
        console.dir(TableauViz);
        console.dir(TableauEventType.WorkbookPublished)
        console.dir(TableauEventType)
    }

    // Determine the correct visualization to display.
    function loadViz(vizPlusMinus) {
        vizCount = vizCount + vizPlusMinus;

        if (vizCount >= vizLen) {
            // Keep the vizCount in the bounds of the array index.
            vizCount = 0;
        } else if (vizCount < 0) {
            vizCount = vizLen - 1;
        }

        vizDiv.src = vizList[vizCount];
    }

    // Event fired when a viz first becomes interactive.
    vizDiv.addEventListener(TableauEventType.FirstInteractive, handleFirstInteractive);
    vizDiv.src = vizList[0];

    // Attach event handlers to the "previous" and "next" button clicks.
    document.getElementById("previous").onclick = () => loadViz(-1);
    document.getElementById("next").onclick = () => loadViz(1);

    function viewEmbed(link){
        vizDiv.src = link;
        window.scrollTo(0, document.body.scrollHeight);
    }

    $(".view_embed").each((i, e) => {
        var link = $(e).attr("data-link");
        e.onclick = () => viewEmbed(link);
    });
</script> -->