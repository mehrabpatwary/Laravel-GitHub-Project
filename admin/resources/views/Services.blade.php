@extends('Layout.app')

@section('content')

<div id="mainDiv" class="container d-none">
	<div class="row">
		<div class="col-md-12 p-5">
		<button type="button" id="addNewBtnId" class="btn btn-danger my-3 btn-sm">+ Add New</button>
			<table id="serviceDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
					<th class="th-sm">Image</th>
					<th class="th-sm">Name</th>
					<th class="th-sm">Description</th>
					<th class="th-sm">Edit</th>
					<th class="th-sm">Delete</th>
					</tr>
				</thead>
					<tbody id='service_table'>
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
				<h5 class="mt-2">Do You Want To Delete</h4>
				<h5 class="mt-2 d-none" id="serviceDeleteId"></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
				<button id="serviceDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
			</div>
		</div>
	</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-5">
		<div class="modal-header">
            <h4 class="mt-2">Update Service</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
			<div class="modal-body text-center">

				<h4 class="mt-2 d-none" id="serviceEditId"></h4>
				<div id="serviceEditForm" class="d-none">
					<input type="text" id="s_name" class="form-control mb-4" placeholder="Service Name"/>
					<input type="text" id="s_des" class="form-control mb-4" placeholder="Service Description"/>
					<input type="text" id="s_img" class="form-control mb-4" placeholder="Service Image Link"/>
				</div>
				

				<img id="serviceEditLoder" class="loading-icon" src="{{ asset('images/loader.svg') }}">
				<h5 id="serviceEditWrong" class="d-none">Something Went Wrong!</h5>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
				<button id="serviceEditConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- Add New Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-5">
			<div class="modal-body text-center">
				<h6 class="mb-3">Add New Services</h6>
				<input type="text" id="s_add_name" class="form-control mb-4" placeholder="Service Name"/>
				<input type="text" id="s_add_des" class="form-control mb-4" placeholder="Service Description"/>
				<input type="text" id="s_add_img" class="form-control mb-4" placeholder="Service Image Link"/>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
				<button id="serviceAddConfirmBtn" type="button" class="btn btn-sm btn-success">Add New</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
	<script type="text/javascript">
		getServicesData();
		///Services Portion
		///Get Data
		function getServicesData() {
			axios
				.get("/getServicesData")
				.then(function (response) {
					if (response.status == 200) {
						$("#mainDiv").removeClass("d-none");
						$("#loaderDiv").addClass("d-none");

						$('#serviceDataTable').DataTable().destroy();
						$("#service_table").empty();

						var json_data = response.data;
						$.each(json_data, function (i, item) {
							$("<tr>")
								.html(
									'<td><img class="table-img" src=' +
										json_data[i].service_img +
										"></td>" +
										"<td>" +
										json_data[i].service_name +
										"</td>" +
										"<td>" +
										json_data[i].service_des +
										"</td>" +
										'<td><a class="serviceEditBtn" data-id=' +
										json_data[i].id +
										'><i class="fas fa-edit"></i></a></td>' +
										'<td><a class="serviceDeleteBtn" data-id=' +
										json_data[i].id +
										'><i class="fas fa-trash-alt"></i></a></td>'
								)
								.appendTo("#service_table");
						});

						///Delete
						$(".serviceDeleteBtn").click(function () {
							var id = $(this).data("id");
							$("#serviceDeleteId").html(id);
							$("#deleteModal").modal("show");
						});

						///Edit
						$(".serviceEditBtn").click(function () {
							var id = $(this).data("id");
							$("#serviceEditId").html(id);
							SetDataInInputField(id);
							$("#EditModal").modal("show");
						});

						///Pagenation
						$('#serviceDataTable').DataTable({"order":false});
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
		$("#serviceDeleteConfirmBtn").click(function () {
			var id = $("#serviceDeleteId").html();
			deleteService(id);
		});

		///Delete
		function deleteService(itemId) {
			$("#serviceDeleteConfirmBtn").html(
				"<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
			);
			axios
				.post("/ServiceDelete", {
					id: itemId,
				})
				.then(function (response) {
					$("#serviceDeleteConfirmBtn").html("Yes");
					if (response.status == 200) {
						if (response.data == 1) {
							$("#deleteModal").modal("hide");
							toastr.success("Delete Success");
							getServicesData();
						} else {
							$("#deleteModal").modal("hide");
							toastr.error("Delete Fail");
							getServicesData();
						}
					} else {
						$("#deleteModal").modal("hide");
						toastr.error("Somethings went wrong!");
					}
				})
				.catch(function (error) {
					$("#serviceDeleteConfirmBtn").html("Yes");
					$("#deleteModal").modal("hide");
					toastr.error("Somethings went wrong!");
				});
		}

		///Save Confirm Button
		$("#serviceEditConfirmBtn").click(function () {
			var id = $("#serviceEditId").html();
			var s_name = $("#s_name").val();
			var s_des = $("#s_des").val();
			var s_img = $("#s_img").val();
			updateService(id, s_name, s_des, s_img);
		});

		///Update
		function updateService(id, service_name, service_des, service_img) {
			if (service_name.length == 0) {
				toastr.error("Service name is empty!");
			} else if (service_des.length == 0) {
				toastr.error("Service Description is empty!");
			} else if (service_img.length == 0) {
				toastr.error("Service Image is empty!");
			} else {
				$("#serviceEditConfirmBtn").html(
					"<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
				);
				axios
					.put("/ServiceUpdate", {
						id: id,
						s_name: service_name,
						s_des: service_des,
						s_img: service_img,
					})
					.then(function (response) {
						$("#serviceEditConfirmBtn").html("Save");
						if (response.status == 200) {
							if (response.data == 1) {
								$("#EditModal").modal("hide");
								toastr.success("Update Success");
								getServicesData();
							} else {
								$("#EditModal").modal("hide");
								toastr.info("You Did Not Update Anything");
								getServicesData();
							}
						} else {
							$("#EditModal").modal("hide");
							toastr.error("Somethings went wrong!");
						}
					})
					.catch(function (error) {
						$("#serviceEditConfirmBtn").html("Save");
						$("#EditModal").modal("hide");
						toastr.error("Somethings went wrong!");
					});
			}
		}

		///Set Data In Input Field
		function SetDataInInputField(id) {
			axios
				.post("/getInputFieldData", {
					id: id,
				})
				.then(function (response) {
					if (response.status == 200) {
						$("#serviceEditLoder").addClass("d-none");
						$("#serviceEditForm").removeClass("d-none");
						$("#serviceEditWrong").addClass("d-none");

						var json_data = response.data;
						$("#s_name").val(json_data[0].service_name);
						$("#s_des").val(json_data[0].service_des);
						$("#s_img").val(json_data[0].service_img);
					} else {
						$("#serviceEditLoder").addClass("d-none");
						$("#serviceEditWrong").removeClass("d-none");
					}
				})
				.catch(function (error) {
					$("#serviceEditLoder").addClass("d-none");
					$("#serviceEditWrong").removeClass("d-none");
				});
		}

		///Add New
		$("#addNewBtnId").click(function () {
			$("#s_add_name").val("");
			$("#s_add_des").val("");
			$("#s_add_img").val("");
			$("#addNewModal").modal("show");
		});

		$("#serviceAddConfirmBtn").click(function () {
			var service_name = $("#s_add_name").val();
			var service_des = $("#s_add_des").val();
			var service_img = $("#s_add_img").val();

			if (service_name.length == 0) {
				toastr.error("Service name is empty!");
			} else if (service_des.length == 0) {
				toastr.error("Service Description is empty!");
			} else if (service_img.length == 0) {
				toastr.error("Service Image is empty!");
			} else {
				$("#serviceAddConfirmBtn").html(
					"<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
				);
				axios.post("/serviceAdd", {
					s_add_name: service_name,
					s_add_des: service_des,
					s_add_img: service_img,
				})
				.then(function (response) {
					$("#serviceAddConfirmBtn").html("Add New");
					if (response.status == 200) {
						if (response.data == 1) {
							$("#addNewModal").modal("hide");
							toastr.success("Data Add Success");
							getServicesData();
						} else {
							$("#addNewModal").modal("hide");
							toastr.error("Add Fail");
							getServicesData();
						}
					} else {
						$("#addNewModal").modal("hide");
						toastr.error("Somethings went wrong!");
					}
				})
				.catch(function (error) {
					$("#serviceAddConfirmBtn").html("Add New");
					$("#addNewModal").modal("hide");
					toastr.error("Somethings went wrong!");
				});
			}
		});

	</script>
@endsection