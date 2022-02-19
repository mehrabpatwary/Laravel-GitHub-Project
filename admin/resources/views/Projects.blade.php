@extends('Layout.app')

@section('content')
    {{--    Projects data section--}}
    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <button type="button" id="addNewProjectBtnId" class="btn btn-danger my-3 btn-sm">+ Add New</button>
                <table id="projectDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Link</th>
                        <th class="th-sm">Image</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="projects_table">
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-2">Do You Want To Delete</h4>
                        <h4 class="mt-2 d-none" id="projectDeleteId"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button id="projectDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->

    <!-- Edit Modal -->
    <div class="modal fade" id="EditProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-5">
                <div class="modal-header">
                    <h4 class="mt-2">Update Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">

                        <h4 class="mt-2 d-none" id="projectEditId"></h4>
                        <div class="d-none" id="projectEditForm">
                            <input id="ProjectNameEditId" type="text"  class="form-control mb-3" placeholder="Project Name">
                            <input id="ProjectDesEditId" type="text"  class="form-control mb-3" placeholder="Project Description">
                            <input id="ProjectLinkEditId" type="text"  class="form-control mb-3" placeholder="Project Link">
                            <input id="ProjectImageEditId" type="text" class="form-control mb-3" placeholder="Project Image">
                        </div>
                        <img id="projectEditLoader" class="loading-icon" src="{{ asset('images/loader.svg') }}">
                        <h5 id="projectEditWrong" class="d-none">Something Went Wrong!</h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ProjectEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->

    <!-- Add New Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">
                    <div>
                        <input id="ProjectNameId" type="text"  class="form-control mb-3" placeholder="Project Name">
                        <input id="ProjectDesId" type="text"  class="form-control mb-3" placeholder="Project Description">
                        <input id="ProjectLinkId" type="text"  class="form-control mb-3" placeholder="Project Link">
                        <input id="ProjectImageId" type="text" class="form-control mb-3" placeholder="Project Image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ProjectAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New Modal -->
@endsection

@section('script')
    <script type="text/javascript">
        getProjectsData();

        function getProjectsData() {

            axios.get("/getProjectData")
                .then(function(response) {
                    if (response.status == 200) {
                        $("#mainDiv").removeClass("d-none");
                        $("#loaderDiv").addClass("d-none");

                        $('#projectDataTable').DataTable().destroy();
                        $("#projects_table").empty();

                        var json_data = response.data;
                        $.each(json_data, function(i, item) {
                            $("<tr>")
                                .html(
                                    '<th class="th-sm">' + json_data[i].project_name + '</th>' +
                                    '<th class="th-sm">' + json_data[i].project_des + '</th>' +
                                    '<th class="th-sm">' + json_data[i].project_link + '</th>' +
                                    '<th class="th-sm">' + json_data[i].project_img + '</th>' +
                                    '<th class="th-sm"><a class="projectEditBtn" data-id=' + json_data[i].id + ' ><i class="fas fa-edit"></i></a></th>' +
                                    '<th class="th-sm"><a class="projectDeleteBtn" data-id=' + json_data[i].id + ' ><i class="fas fa-trash-alt"></i></a></th>'
                                ).appendTo("#projects_table");
                        });

                        ///Delete Icon
                        $(".projectDeleteBtn").click(function() {
                            var id = $(this).data("id");
                            $("#projectDeleteId").html(id);
                            $("#deleteModal").modal("show");
                        });

                        ///Edit Icon
                        $(".projectEditBtn").click(function() {
                            var id = $(this).data("id");
                            $("#projectEditId").html(id);
                            SetDataInInputField(id);
                            $("#EditProjectModal").modal("show");
                        });

                        ///Pagination
                        $('#projectDataTable').DataTable({
                            "order": false
                        });
                        $('.dataTables_length').addClass('bs-select');

                    } else {
                        $("#wrongDiv").removeClass("d-none");
                        $("#loaderDiv").addClass("d-none");
                    }
                })
                .catch(function(error) {
                    $("#wrongDiv").removeClass("d-none");
                    $("#loaderDiv").addClass("d-none");
                });
        }

        ///Delete Confirm Button
        $("#projectDeleteConfirmBtn").click(function() {
            var id = $("#projectDeleteId").html();
            deleteProject(id);
        });

        ///Delete Project
        function deleteProject(itemId) {
            $("#projectDeleteConfirmBtn").html(
                "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
            );
            axios
                .post("/projectDelete", {
                    id: itemId,
                })
                .then(function(response) {
                    $("#projectDeleteConfirmBtn").html("Yes");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $("#deleteModal").modal("hide");
                            toastr.success("Delete Success");
                            getProjectsData();
                        } else {
                            $("#deleteModal").modal("hide");
                            toastr.error("Delete Fail");
                            getProjectsData();
                        }
                    } else {
                        $("#deleteModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    }
                })
                .catch(function(error) {
                    $("#projectDeleteConfirmBtn").html("Yes");
                    $("#deleteModal").modal("hide");
                    toastr.error("Somethings went wrong!");
                });
        }

        ///Set Data In Input Field
        function SetDataInInputField(id) {
            axios
                .post("/getProjectFieldData", {
                    id: id,
                })
                .then(function(response) {
                    if (response.status == 200) {
                        $("#projectEditLoader").addClass("d-none");
                        $("#projectEditForm").removeClass("d-none");
                        $("#projectEditWrong").addClass("d-none");

                        var json_data = response.data;
                        $("#ProjectNameEditId").val(json_data[0].project_name);
                        $("#ProjectDesEditId").val(json_data[0].project_des);
                        $("#ProjectLinkEditId").val(json_data[0].project_link);
                        $("#ProjectImageEditId").val(json_data[0].project_img);
                    } else {
                        $("#projectEditLoader").addClass("d-none");
                        $("#projectEditWrong").removeClass("d-none");
                    }
                })
                .catch(function(error) {
                    $("#projectEditLoader").addClass("d-none");
                    $("#projectEditWrong").removeClass("d-none");
                });
        }

        ///Save Confirm Button
        $("#ProjectEditConfirmBtn").click(function() {
            var id = $("#projectEditId").html();
            var ProjectName = $("#ProjectNameEditId").val();
            var ProjectDes = $("#ProjectDesEditId").val();
            var ProjectLink = $("#ProjectLinkEditId").val();
            var ProjectImage = $("#ProjectImageEditId").val();
            updateProject(id, ProjectName, ProjectDes, ProjectLink, ProjectImage);

            ///Update
            function updateProject(id, ProjectName, ProjectDes, ProjectLink, ProjectImage) {
                if (ProjectName.length == 0) {
                    toastr.error("Project name is empty!");
                } else if (ProjectDes.length == 0) {
                    toastr.error("Project Description is empty!");
                } else if (ProjectLink.length == 0) {
                    toastr.error("Project link is empty!");
                } else if (ProjectImage.length == 0) {
                    toastr.error("Project Image is empty!");
                } else {
                    $("#ProjectEditConfirmBtn").html(
                        "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
                    );
                    axios
                        .put("/projectUpdate", {
                            id: id,
                            project_name: ProjectName,
                            project_des: ProjectDes,
                            project_link: ProjectLink,
                            project_image: ProjectImage,
                        })
                        .then(function(response) {
                            $("#ProjectEditConfirmBtn").html("Save");
                            if (response.status == 200) {
                                if (response.data == 1) {
                                    $("#EditProjectModal").modal("hide");
                                    toastr.success("Update Success");
                                    getProjectsData();
                                } else {
                                    $("#EditProjectModal").modal("hide");
                                    toastr.info("You Did Not Update Anything");
                                    getProjectsData();
                                }
                            } else {
                                $("#EditProjectModal").modal("hide");
                                toastr.error("Somethings went wrong!");
                            }
                        })
                        .catch(function(error) {
                            $("#ProjectEditConfirmBtn").html("Save");
                            $("#EditProjectModal").modal("hide");
                            toastr.error("Somethings went wrong!");
                        });
                }
            }
        });

        ///Add New Courses
        $("#addNewProjectBtnId").click(function() {

            $("#ProjectNameId").val('');
            $("#ProjectDesId").val('');
            $("#ProjectLinkId").val('');
            $("#ProjectImageId").val('');

            $("#addProjectModal").modal("show");
        });

        $("#ProjectAddConfirmBtn").click(function() {
            var ProjectName = $("#ProjectNameId").val();
            var ProjectDes = $("#ProjectDesId").val();
            var ProjectLink = $("#ProjectLinkId").val();
            var ProjectImage = $("#ProjectImageId").val();

            if (ProjectName.length == 0) {
                toastr.error("Project name is empty!");
            } else if (ProjectDes.length == 0) {
                toastr.error("Project Description is empty!");
            } else if (ProjectLink.length == 0) {
                toastr.error("Project link is empty!");
            } else if (ProjectImage.length == 0) {
                toastr.error("Project Image is empty!");
            } else {
                $("#ProjectAddConfirmBtn").html(
                    "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
                );
                axios.post("/projectAdd", {
                    project_name: ProjectName,
                    project_des: ProjectDes,
                    project_link: ProjectLink,
                    project_image: ProjectImage
                })
                    .then(function(response) {
                        $("#ProjectAddConfirmBtn").html("Save");
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $("#addProjectModal").modal("hide");
                                toastr.success("Insert Success");
                                getProjectsData();
                            } else {
                                $("#addProjectModal").modal("hide");
                                toastr.error("Somethings went wrong!");
                                getProjectsData();
                            }
                        } else {
                            $("#addProjectModal").modal("hide");
                            toastr.error("Somethings went wrong!");
                        }
                    })
                    .catch(function(error) {
                        $("#ProjectAddConfirmBtn").html("Save");
                        $("#addProjectModal").modal("hide");
                        toastr.error("Somethings went wrong!");
                    });
            }
        });
    </script>
@endsection
