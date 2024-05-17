<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="card-title mb-2">MS Teams JS</div>
                            <div class="mb-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<!-- Microsoft Teams JavaScript API (via CDN) -->
<script
  src="https://res.cdn.office.net/teams-js/2.18.0/js/MicrosoftTeams.min.js"
  integrity="sha384-g8DoRkiR0ECQ9rwKIgY8GjQ5h0d2jp1347CmU/IRlyUHPjJZiFWEOYc+hFtT9MGL"
  crossorigin="anonymous"
></script>
<script src="https://appsforoffice.microsoft.com/lib/1/hosted/office.js"></script>
<!-- Microsoft Teams JavaScript API (via npm) -->
<!-- <script type="module" src="node_modules/@microsoft/teams-js@2.18.0/dist/MicrosoftTeams.min.js"></script> -->

<script type="text/javascript">
    const msTeams = microsoftTeams;
    const app = msTeams.app;
    let isInit = app.isInitialized();

    console.log("msTeams: ", msTeams);
    console.log("app: ", app);
    console.log("isInit: ", isInit, app.initialize());

    async function example() {
        const context = await app.getContext();
        console.log("context: ", context);
    }
    // example();
    // microsoftTeams.app.getContext().then((context) => {
    //     console.log("teams: ", context);
    // });
</script>
