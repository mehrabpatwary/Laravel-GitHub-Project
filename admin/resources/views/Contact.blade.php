@extends('Layout.app')
@section('title', 'Contact')
@section('content')
    {{--Contact data section--}}
    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <table id="contactDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Mobile</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Message</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="contact_table">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="loaderDiv" class="container">
        <div class="row">
            <div class="col-md-12 p-5 text-center mt-5">
                <img class="loading-icon" src="{{ asset('images/loader.svg') }}">
            </div>
        </div>
    </div>

    <div id="wrongDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5 text-center">
                <h3>Something Went Wrong!</h3>
            </div>
        </div>
    </div>
    {{--Contact data section--}}

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-2">Do You Want To Delete</h4>
                    <h4 class="mt-2 d-none" id="contactDeleteId"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button id="contactDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
@endsection

@section('script')
    <script type="text/javascript">
        getContactData();

        function getContactData() {

            axios.get("/getContactData")
                .then(function (response) {
                    if (response.status == 200) {
                        $("#mainDiv").removeClass("d-none");
                        $("#loaderDiv").addClass("d-none");

                        $('#contactDataTable').DataTable().destroy();
                        $("#contact_table").empty();

                        var json_data = response.data;
                        $.each(json_data, function (i, item) {
                            $("<tr>")
                                .html(
                                    '<th class="th-sm">'+json_data[i].contact_name+'</th>'+
                                    '<th class="th-sm">'+json_data[i].contact_mobile+'</th>'+
                                    '<th class="th-sm">'+json_data[i].contact_email+'</th>'+
                                    '<th class="th-sm">'+json_data[i].contact_msg+'</th>'+
                                    '<th class="th-sm"><a class="contactDeleteBtn" data-id='+ json_data[i].id +' ><i class="fas fa-trash-alt"></i></a></th>'
                                ).appendTo("#contact_table");
                        });

                        ///Delete Icon
                        $(".contactDeleteBtn").click(function () {
                            var id = $(this).data("id");
                            $("#contactDeleteId").html(id);
                            $("#deleteModal").modal("show");
                        });

                        ///Pagenation
                        $('#contactDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    } else {
                        $("#wrongDiv").removeClass("d-none");
                        $("#loaderDiv").addClass("d-none");
                    }
                })
                .catch(function (error) {
                    $("#wrongDiv").removeClass("d-none");
                    $("#loaderDiv").addClass("d-none");
                });

        }

        ///Delete Confirm Button
        $("#contactDeleteConfirmBtn").click(function () {
            var id = $("#contactDeleteId").html();
            deleteContact(id);
        });

        ///Delete Contact
        function deleteContact(itemId) {
            $("#contactDeleteConfirmBtn").html(
                "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
            );
            axios
                .post("/ContactDelete", {
                    id: itemId,
                })
                .then(function (response) {
                    $("#contactDeleteConfirmBtn").html("Yes");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $("#deleteModal").modal("hide");
                            toastr.success("Delete Success");
                            getContactData();
                        } else {
                            $("#deleteModal").modal("hide");
                            toastr.error("Delete Fail");
                            getContactData();
                        }
                    } else {
                        $("#deleteModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    }
                })
                .catch(function (error) {
                    $("#contactDeleteConfirmBtn").html("Yes");
                    $("#deleteModal").modal("hide");
                    toastr.error("Somethings went wrong!");
                });
        }


    </script>
@endsection
