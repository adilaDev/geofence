<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Editable Table</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Editable Table</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Table Edit</h4>
                        <p class="card-title-desc">Table Edits is a lightweight jQuery plugin for making table rows
                            editable.</p>

                        <div class="table-responsive">
                            <table class="table table-editable table-nowrap align-middle table-edits">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_edit">
                                    <tr data-id="1">
                                        <td data-field="id" style="width: 80px">1</td>
                                        <td data-field="name">David McHenry</td>
                                        <td data-field="age">24</td>
                                        <td data-field="gender">Male</td>
                                        <td style="width: 100px">
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr data-id="2">
                                        <td data-field="id">2</td>
                                        <td data-field="name">Frank Kirk</td>
                                        <td data-field="age">22</td>
                                        <td data-field="gender">Male</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr data-id="3">
                                        <td data-field="id">3</td>
                                        <td data-field="name">Rafael Morales</td>
                                        <td data-field="age">26</td>
                                        <td data-field="gender">Male</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr data-id="4">
                                        <td data-field="id">4</td>
                                        <td data-field="name">Mark Ellison</td>
                                        <td data-field="age">32</td>
                                        <td data-field="gender">Male</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr data-id="5">
                                        <td data-field="id">5</td>
                                        <td data-field="name">Minnie Walter</td>
                                        <td data-field="age">27</td>
                                        <td data-field="gender">Female</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="row_clone">
                                        <td colspan="5">
                                            <button type="button" id="btn_clone" class="btn btn-primary btn-sm waves-effect waves-light">Add Row</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Example</h4>
                        <form class="repeater" enctype="multipart/form-data">
                            <div >
                                <div class="row">
                                    <!-- <div  class="mb-3 col-lg-2">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="untyped-input" class="form-control" placeholder="Enter Your Name"/>
                                    </div>

                                    <div  class="mb-3 col-lg-2">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control" placeholder="Enter Your Email ID"/>
                                    </div> -->
                                    <table class="table table-editable table-nowrap align-middle table-edits-dynamic">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_edit" data-repeater-list="group-a">
                                            <tr data-id="1" data-repeater-item>
                                                <td data-field="key">Country</td>
                                                <td data-field="value">Indonesia</td>
                                                <td style="width: 100px">
                                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a data-repeater-delete class="btn btn-outline-danger btn-sm delete" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <!-- <div class="col-lg-2 align-self-center">
                                        <div class="d-grid">
                                            <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
                                        </div>
                                    </div> -->
                                </div>
                                
                            </div>
                            <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Table Editable plugin -->
<script src="<?=base_url()?>assets/libs/table-edits/build/table-edits.min.js"></script>

<!-- form repeater js -->
<script src="<?=base_url()?>assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script>
    $(document).ready(function() {
        var pickers = {};
        var edit_table = $('.table-edits tr').editable({
            dropdowns: {
                gender: ['Male', 'Female']
            },
            edit: function (values) {
                $(".edit i", this)
                    .removeClass('fa-pencil-alt')
                    .addClass('fa-save')
                    .attr('title', 'Save');
                console.log("edit: ", values, "\nthis: ", this);
            },
            save: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
                console.log("save: ", values, "\nthis: ", this);
            },
            cancel: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
                console.log("cancel: ", values, "\nthis: ", this);
            }
        });

        console.log("edit_table: ", edit_table);
        var reedit_table = edit_table[edit_table.length-2];
        var get_last_data_id = $(reedit_table).attr("data-id");
        console.log("reedit_table: ", reedit_table, " data-id: ", get_last_data_id);
        
        $("#btn_clone").on("click", () => {
            get_last_data_id ++;
            var dummy_head = ["id", "name", "age", "gender", "edit"];
            var dummy_content = ["id", "name", "age", "gender", "edit"];
            console.log("prev data-id: ", $(reedit_table).attr("data-id"), "\nnext data-id: ", get_last_data_id);
            cloneRowTable(get_last_data_id, $(reedit_table).children(), edit_table);
        });
        repeater();
    });

    function repeater(){
        var rep = $('.repeater').repeater({
            show: function () {
                $(this).slideDown();
                initDtEdit();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                    initDtEdit();
                }
            },
            ready: function (setIndexes) {
                initDtEdit();
            }
        });
        console.log("repeater: ", rep);
    }

    function initDtEdit(){
        var pickers = {};
        var edit_table = $('.table-edits-dynamic tr').editable({
            dropdowns: {
                gender: ['Male', 'Female']
            },
            edit: function (values) {
                $(".edit i", this)
                    .removeClass('fa-pencil-alt')
                    .addClass('fa-save')
                    .attr('title', 'Save');
                pickers[values.key] = this;
                console.log("edit: ", values, " pickers: ", pickers, "\nthis: ", this);
            },
            save: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                console.log("save: ", values, " pickers: ", pickers, "\nthis: ", this);
                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
            },
            cancel: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                console.log("cancel: ", values, " pickers: ", pickers, "\nthis: ", this);
                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
            }
        });
    }

    function cloneRowTable(data_id, data_field = [], edit_table){
        var tr = `<tr data-id="${data_id}">`;
        var tr_end = `</tr>`;
        var result = tr;

        console.log("data_filed: ", data_field);
        for (let i = 0; i < data_field.length; i++) {
            const el = data_field[i];
            var field = $(el).attr('data-field');
            var value = $(el).html();
            
            value = (field == 'id') ? data_id : value;
            if (field == "edit") {
                // console.log("field: ", field);
                // console.log("value: ", value);
                result += `<td>${value}</td>`;
            } else {
                result += `<td data-field="${field}">${value}</td>`;
            }

        }
        result += tr_end;
        $("#tbody_edit > tr.row_clone").before(result);
        // edit_table.push($(result)[0]);
        edit_table = $('.table-edits tr').editable({
            dropdowns: {
                gender: ['Male', 'Female']
            },
            edit: function (values) {
                $(".edit i", this)
                    .removeClass('fa-pencil-alt')
                    .addClass('fa-save')
                    .attr('title', 'Save');
                console.log("edit: ", values, "\nthis: ", this);
            },
            save: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
                console.log("save: ", values, "\nthis: ", this);
            },
            cancel: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
                console.log("cancel: ", values, "\nthis: ", this);
            }
        });
        console.log("result: ", $(result), "\nedit_table: ", edit_table);
        return result;
    }
</script>