<div class="main-content">
    <div class="page-content p-0 pt-4">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tableau</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Tableau</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row row-cols-4">
                <?php $thumbnail = $link_embed["thumbnail"] ?>
                <?php $no = 0; foreach ($link_embed['link'] as $key => $value) : ?>
                    <div class="col">
                        <div class="card card-effect">
                            <div class="card-body">
                                <div class="card-title">Title <?= $no+=1 ?>
                                    <?php if ($key == 3) : ?>
                                        <div class="float-end"><a target="_blank" href="<?= base_url('tableau/v3')?>" class="btn btn-dark btn-sm waves-effect waves-light view_embed">View</a></div>
                                    <?php else : ?>
                                        <div class="float-end"><button type="button" data-link="<?=$value?>" class="btn btn-dark btn-sm waves-effect waves-light view_embed">View</button></div>
                                    <?php endif; ?>
                                </div>
                                <div class="<?=$key?>">
                                    <img src="<?= $thumbnail[$key] ?>" alt="thumbnail" width="100%" height="200">
                                </div>
                                <!-- <div style="width:100%; height:200px;">
                                    <tableau-viz src="<?=$value?>"></tableau-viz>
                                </div> -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-title">Demo Tableau (Embeded API)</div>
                    <div class="card card-effect">
                        <div class="card-body">
                                <!-- Initialization of the Tableau visualization. -->
                                <div style="width:auto; height:100%;">
                                    <tableau-viz id="tableauViz" hide-tabs></tableau-viz>
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

<script src="https://public.tableau.com/javascripts/api/tableau-2.js"></script>

<script type="module">
    // TableauEventType represents the type of Tableau embedding event that can be listened for.
    import { TableauViz, TableauEventType } from "https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.js";

    // List of visualizations to cycle through.
    // const vizList = ["https://public.tableau.com/views/RegionalSampleWorkbook/Flights",
    //     "https://public.tableau.com/views/RegionalSampleWorkbook/Obesity",
    //     "https://public.tableau.com/views/RegionalSampleWorkbook/College",
    //     "https://public.tableau.com/views/RegionalSampleWorkbook/Stocks",
    //     "https://public.tableau.com/views/RegionalSampleWorkbook/Storms"];
    const vizList = <?= json_encode($link_embed['link']) ?>;

    let vizLen = vizList.length, vizCount = 0, workbook, activeSheet;
    let vizDiv = document.getElementById("tableauViz");
    const viz = new TableauViz();

    function handleFirstInteractive(e) {
        // workbook = viz.getWorkbook();
        // activeSheet = workbook.getActiveSheet();
        
        workbook = viz.workbook;
        activeSheet = workbook.activeSheet;

        console.log(workbook);
        console.log(activeSheet);

        // console.log(`Viz loaded: ${viz.src}`);
        // console.log(`Viz activeSheet: ${viz.getAttributeEvents()}`);
        // console.dir(viz);
        // console.dir(TableauViz);
        // console.dir(viz.workbook)
        // console.dir(TableauEventType)
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
</script>