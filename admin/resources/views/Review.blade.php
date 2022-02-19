@extends('Layout.app')

@section('content')

    {{--Review data section--}}
    <div id="mainDiv" class="container ">
        <div class="row">
            <div class="col-md-12 p-5">
                <button type="button" id="addNewBtnId" class="btn btn-danger my-3 btn-sm">+ Add New</button>
                <table id="reviewDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Image</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="review_table">
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
    {{--    Review data section--}}


    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-2">Do You Want To Delete</h4>
                    <h4 class="mt-2 d-none" id="reviewDeleteId"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button id="reviewDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->

    <!-- Add New Modal -->
    <div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">
                    <input id="reviewNameId" type="text" class="form-control mb-3" placeholder="Review Name">
                    <input id="reviewDesId" type="text" class="form-control mb-3" placeholder="Review Description">
                    <input id="reviewImageId" type="text" class="form-control mb-3" placeholder="Review Image">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="reviewAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Add New Modal -->

    <!-- Edit Modal -->
    <div class="modal fade" id="EditReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-5">
                <div class="modal-header">
                    <h4 class="mt-2">Update Review</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">

                    <h4 class="mt-2 d-none" id="reviewEditId"></h4>
                    <div class="d-none" id="reviewEditForm">
                        <input id="reviewNameEditId" type="text"  class="form-control mb-3" placeholder="Name">
                        <input id="reviewDesEditId" type="text"  class="form-control mb-3" placeholder="Description">
                        <input id="reviewImageEditId" type="text"  class="form-control mb-3" placeholder="Image Link">
                    </div>
                    <img id="reviewEditLoader" class="loading-icon" src="{{ asset('images/loader.svg') }}">
                    <h5 id="reviewEditWrong" class="d-none">Something Went Wrong!</h5>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                <button  id="reviewEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
            </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Edit Modal -->

@endsection

@section('script')
    <script type="text/javascript">
        getReviewData();

        function getReviewData(){

            axios.get("/getReviewData")
                .then(function (response) {
                    if (response.status == 200) {
                        $("#mainDiv").removeClass("d-none");
                        $("#loaderDiv").addClass("d-none");

                        $('#reviewDataTable').DataTable().destroy();
                        $("#review_table").empty();

                        var json_data = response.data;
                        $.each(json_data, function (i, item) {
                            $("<tr>")
                                .html(
                                    '<th class="th-sm">'+json_data[i].name+'</th>'+
                                    '<th class="th-sm">'+json_data[i].desc+'</th>'+
                                    '<th class="th-sm">'+json_data[i].img+'</th>'+
                                    '<th class="th-sm"><a class="reviewEditBtn" data-id='+ json_data[i].id +' ><i class="fas fa-edit"></i></a></th>'+
                                    '<th class="th-sm"><a class="reviewDeleteBtn" data-id='+ json_data[i].id +' ><i class="fas fa-trash-alt"></i></a></th>'
                                ).appendTo("#review_table");
                        });

                        ///Delete Icon
                        $(".reviewDeleteBtn").click(function () {
                            var id = $(this).data("id");
                            $("#reviewDeleteId").html(id);
                            $("#deleteModal").modal("show");
                        });

                        ///Edit Icon
                        $(".reviewEditBtn").click(function () {
                            var id = $(this).data("id");
                            $("#reviewEditId").html(id);
                            SetDataInInputField(id);
                            $("#EditReviewModal").modal("show");
                        });

                        ///Pagenation
                        $('#reviewDataTable').DataTable({"order":false});
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
        $("#reviewDeleteConfirmBtn").click(function () {
            var id = $("#reviewDeleteId").html();
            deleteReview(id);
        });

        ///Delete Review
        function deleteReview(itemId) {
            $("#reviewDeleteConfirmBtn").html(
                "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
            );
            axios
                .post("/reviewDelete", {
                    id: itemId,
                })
                .then(function (response) {
                    $("#reviewDeleteConfirmBtn").html("Yes");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $("#deleteModal").modal("hide");
                            toastr.success("Delete Success");
                            getReviewData();
                        } else {
                            $("#deleteModal").modal("hide");
                            toastr.error("Delete Fail---");
                            getReviewData();
                        }
                    } else {
                        $("#deleteModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    }
                })
                .catch(function (error) {
                    $("#reviewDeleteConfirmBtn").html("Yes");
                    $("#deleteModal").modal("hide");
                    toastr.error("Somethings went wrong!");
                });
        }

        ///Add New Review
        $("#addNewBtnId").click(function () {

            $("#reviewNameId").val('');
            $("#reviewDesId").val('');
            $("#reviewImageId").val('');

            $("#addReviewModal").modal("show");
        });

        $("#reviewAddConfirmBtn").click(function () {
            var reviewName = $("#reviewNameId").val();
            var reviewDes = $("#reviewDesId").val();
            var reviewImage = $("#reviewImageId").val();

            if (reviewName.length == 0) {
                toastr.error("Review name is empty!");
            } else if (reviewDes.length == 0) {
                toastr.error("Review Description is empty!");
            } else if (reviewImage.length == 0) {
                toastr.error("Review Image is empty!");
            } else {
                $("#reviewAddConfirmBtn").html(
                    "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
                );
                axios.post("/reviewAdd", {
                    name: reviewName,
                    desc: reviewDes,
                    img: reviewImage
                })
                    .then(function (response) {
                        $("#reviewAddConfirmBtn").html("Save");
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $("#addReviewModal").modal("hide");
                                toastr.success("Data Add Success");
                                getReviewData();
                            } else {
                                $("#addReviewModal").modal("hide");
                                toastr.error("Add Fail");
                                getReviewData();
                            }
                        } else {
                            $("#addReviewModal").modal("hide");
                            toastr.error("Somethings went wrong!");
                        }
                    })
                    .catch(function (error) {
                        $("#reviewAddConfirmBtn").html("Save");
                        $("#addReviewModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    });
            }
        });

        ///Set Data In Input Field
        function SetDataInInputField(id) {
            axios
                .post("/getReviewFieldData", {
                    id: id,
                })
                .then(function (response) {
                    if (response.status == 200) {
                        $("#reviewEditLoader").addClass("d-none");
                        $("#reviewEditForm").removeClass("d-none");
                        $("#reviewEditWrong").addClass("d-none");

                        var json_data = response.data;
                        $("#reviewNameEditId").val(json_data[0].name);
                        $("#reviewDesEditId").val(json_data[0].desc);
                        $("#reviewImageEditId").val(json_data[0].img);
                    } else {
                        $("#reviewEditLoader").addClass("d-none");
                        $("#reviewEditWrong").removeClass("d-none");
                    }
                })
                .catch(function (error) {
                    $("#reviewEditLoader").addClass("d-none");
                    $("#reviewEditWrong").removeClass("d-none");
                });
        }

        ///Save Confirm Button
        $("#reviewEditConfirmBtn").click(function () {
            var id = $("#reviewEditId").html();
            var reviewName = $("#reviewNameEditId").val();
            var reviewDes = $("#reviewDesEditId").val();
            var reviewImage = $("#reviewImageEditId").val();
            updateReview(id, reviewName, reviewDes, reviewImage);
        });

        ///Update
        function updateReview(id, reviewName, reviewDes, reviewImage) {
            if (reviewName.length == 0) {
                toastr.error("Review name is empty!");
            } else if (reviewDes.length == 0) {
                toastr.error("Review Description is empty!");
            } else if (reviewImage.length == 0) {
                toastr.error("Review Image is empty!");
            } else {
                $("#reviewEditConfirmBtn").html(
                    "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
                );
                axios
                    .put("/reviewUpdate", {
                        id: id,
                        name: reviewName,
                        desc: reviewDes,
                        image: reviewImage
                    })
                    .then(function (response) {
                        $("#reviewEditConfirmBtn").html("Save");
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $("#EditReviewModal").modal("hide");
                                toastr.success("Update Success");
                                getReviewData();
                            } else {
                                $("#EditReviewModal").modal("hide");
                                toastr.info("You Did Not Update Anything");
                                getReviewData();
                            }
                        } else {
                            $("#EditReviewModal").modal("hide");
                            toastr.error("Somethings went wrong!");
                        }
                    })
                    .catch(function (error) {
                        $("#reviewEditConfirmBtn").html("Save");
                        $("#EditReviewModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    });
            }
        }

    </script>
@endsection
