@extends('Layout.app')

@section('content')

<div id="mainDiv" class="container d-none">
    <div class="row">
        <div class="col-md-12 p-5">
        <button type="button" id="addNewBtnId" class="btn btn-danger my-3 btn-sm">+ Add New</button>
        <table id="courseDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="th-sm">Name</th>
                    <th class="th-sm">Fee</th>
                    <th class="th-sm">Class</th>
                    <th class="th-sm">Enroll</th>
                    <th class="th-sm">Edit</th>
                    <th class="th-sm">Delete</th>
                </tr>
            </thead>
            <tbody id="courses_table">	
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
				<h5 class="mt-2 d-none" id="coursesDeleteId"></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
				<button id="coursesDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
			</div>
		</div>
	</div>
</div>
<!-- Delete Modal -->

<!-- Add New Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add New Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body  text-center">
       <div class="container">
       	<div class="row">
       		<div class="col-md-6">
             	<input id="CourseNameId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
          	 	<input id="CourseDesId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
    		 	<input id="CourseFeeId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
     			<input id="CourseEnrollId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
       		</div>
       		<div class="col-md-6">
     			<input id="CourseClassId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
     			<input id="CourseLinkId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
     			<input id="CourseImgId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
       		</div>
       	</div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
        <button  id="CourseAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add New Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="EditCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="mt-2">Update Course</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body  text-center">
            <h4 class="mt-2 d-none" id="courseEditId"></h4>
            <div class="container">
               <div class="row d-none" id="courseEditForm">
                  <div class="col-md-6">
                     <input id="CourseNameEditId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
                     <input id="CourseDesEditId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
                     <input id="CourseFeeEditId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
                     <input id="CourseEnrollEditId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
                  </div>
                  <div class="col-md-6">
                     <input id="CourseClassEditId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
                     <input id="CourseLinkEditId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
                     <input id="CourseImgEditId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
                  </div>
               </div>
               <img id="courseEditLoder" class="loading-icon" src="{{ asset('images/loader.svg') }}">
               <h5 id="courseEditWrong" class="d-none">Something Went Wrong!</h5>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
            <button  id="CourseEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
         </div>
      </div>
   </div>
</div>
<!-- Edit Modal -->

@endsection

@section('script')
<script type="text/javascript">

  getCoursesData();

  function getCoursesData(){

      axios.get("/getCoursesData")
      .then(function (response) {
          if (response.status == 200) {
              $("#mainDiv").removeClass("d-none");
              $("#loaderDiv").addClass("d-none");

              $('#courseDataTable').DataTable().destroy();
              $("#courses_table").empty();

              var json_data = response.data;
              $.each(json_data, function (i, item) {
                  $("<tr>")
                      .html(
                          '<th class="th-sm">'+json_data[i].course_name+'</th>'+
                          '<th class="th-sm">'+json_data[i].course_fee+'</th>'+
                          '<th class="th-sm">'+json_data[i].course_total_class+'</th>'+
                          '<th class="th-sm">'+json_data[i].course_total_enroll+'</th>'+
                          '<th class="th-sm"><a class="courseEditBtn" data-id='+ json_data[i].id +' ><i class="fas fa-edit"></i></a></th>'+
                          '<th class="th-sm"><a class="coursesDeleteBtn" data-id='+ json_data[i].id +' ><i class="fas fa-trash-alt"></i></a></th>'
                      ).appendTo("#courses_table");
              });

              ///Delete Icon
              $(".coursesDeleteBtn").click(function () {
                  var id = $(this).data("id");
                  $("#coursesDeleteId").html(id);
                  $("#deleteModal").modal("show");
              });

              ///Edit Icon
              $(".courseEditBtn").click(function () {
                  var id = $(this).data("id");
                  $("#courseEditId").html(id);
                  SetDataInInputField(id);
                  $("#EditCourseModal").modal("show");
              });

              ///Pagenation
              $('#courseDataTable').DataTable({"order":false});
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
  $("#coursesDeleteConfirmBtn").click(function () {
      var id = $("#coursesDeleteId").html();
      deleteService(id);
  });

  ///Delete Courses
  function deleteService(itemId) {
      $("#coursesDeleteConfirmBtn").html(
          "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
      );
      axios
          .post("/CoursesDelete", {
              id: itemId,
          })
          .then(function (response) {
              $("#coursesDeleteConfirmBtn").html("Yes");
              if (response.status == 200) {
                  if (response.data == 1) {
                      $("#deleteModal").modal("hide");
                      toastr.success("Delete Success");
                      getCoursesData();
                  } else {
                      $("#deleteModal").modal("hide");
                      toastr.error("Delete Fail");
                      getCoursesData();
                  }
              } else {
                  $("#deleteModal").modal("hide");
                  toastr.error("Somethings went wrong!");
              }
          })
          .catch(function (error) {
              $("#coursesDeleteConfirmBtn").html("Yes");
              $("#deleteModal").modal("hide");
              toastr.error("Somethings went wrong!");
          });
  }

  ///Add New Courses
  $("#addNewBtnId").click(function () {

      $("#CourseNameId").val('');
      $("#CourseDesId").val('');
      $("#CourseFeeId").val('');
      $("#CourseEnrollId").val('');
      $("#CourseClassId").val('');
      $("#CourseLinkId").val('');
      $("#CourseImgId").val('');

      $("#addCourseModal").modal("show");
  });

  $("#CourseAddConfirmBtn").click(function () {
      var CourseNameId = $("#CourseNameId").val();
      var CourseDesId = $("#CourseDesId").val();
      var CourseFeeId = $("#CourseFeeId").val();
      var CourseEnrollId = $("#CourseEnrollId").val();
      var CourseClassId = $("#CourseClassId").val();
      var CourseLinkId = $("#CourseLinkId").val();
      var CourseImgId = $("#CourseImgId").val();

      if (CourseNameId.length == 0) {
          toastr.error("Course name is empty!");
      } else if (CourseDesId.length == 0) {
          toastr.error("Course Description is empty!");
      } else if (CourseFeeId.length == 0) {
          toastr.error("Course Fee is empty!");
      } else if (CourseEnrollId.length == 0) {
          toastr.error("Course Enroll is empty!");
      } else if (CourseClassId.length == 0) {
          toastr.error("Course Class is empty!");
      } else if (CourseLinkId.length == 0) {
          toastr.error("Course Link is empty!");
      } else if (CourseImgId.length == 0) {
          toastr.error("Course Image is empty!");
      } else {
          $("#CourseAddConfirmBtn").html(
              "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
          );
          axios.post("/courseAdd", {
              course_name: CourseNameId,
              course_des: CourseDesId,
              course_fee: CourseFeeId,
              course_total_enroll: CourseEnrollId,
              course_total_class: CourseClassId,
              course_link: CourseLinkId,
              course_img: CourseImgId,
          })
          .then(function (response) {
              $("#CourseAddConfirmBtn").html("Save");
              if (response.status == 200) {
                  if (response.data == 1) {
                      $("#addCourseModal").modal("hide");
                      toastr.success("Data Add Success");
                      getCoursesData();
                  } else {
                      $("#addCourseModal").modal("hide");
                      toastr.error("Add Fail");
                      getCoursesData();
                  }
              } else {
                  $("#addCourseModal").modal("hide");
                  toastr.error("Somethings went wrong!");
              }
          })
          .catch(function (error) {
              $("#CourseAddConfirmBtn").html("Save");
              $("#addCourseModal").modal("hide");
              toastr.error("Somethings went wrong!");
          });
      }
  });

  ///Set Data In Input Field
  function SetDataInInputField(id) {
      axios
          .post("/getCourseFieldData", {
              id: id,
          })
          .then(function (response) {
              if (response.status == 200) {
                  $("#courseEditLoder").addClass("d-none");
                  $("#courseEditForm").removeClass("d-none");
                  $("#courseEditWrong").addClass("d-none");

                  var json_data = response.data;
                  $("#CourseNameEditId").val(json_data[0].course_name);
                  $("#CourseDesEditId").val(json_data[0].course_des);
                  $("#CourseFeeEditId").val(json_data[0].course_fee);
                  $("#CourseEnrollEditId").val(json_data[0].course_total_enroll);
                  $("#CourseClassEditId").val(json_data[0].course_total_class);
                  $("#CourseLinkEditId").val(json_data[0].course_link);
                  $("#CourseImgEditId").val(json_data[0].course_img);
              } else {
                  $("#courseEditLoder").addClass("d-none");
                  $("#courseEditWrong").removeClass("d-none");
              }
          })
          .catch(function (error) {
              $("#courseEditLoder").addClass("d-none");
              $("#courseEditWrong").removeClass("d-none");
          });
  }

  ///Save Confirm Button
  $("#CourseEditConfirmBtn").click(function () {
      var id = $("#courseEditId").html();
      var CourseNameId = $("#CourseNameEditId").val();
      var CourseDesId = $("#CourseDesEditId").val();
      var CourseFeeId = $("#CourseFeeEditId").val();
      var CourseEnrollId = $("#CourseEnrollEditId").val();
      var CourseClassId = $("#CourseClassEditId").val();
      var CourseLinkId = $("#CourseLinkEditId").val();
      var CourseImgId = $("#CourseImgEditId").val();
      updateCourse(id, CourseNameId, CourseDesId, 
          CourseFeeId, CourseEnrollId, CourseClassId, CourseLinkId, CourseImgId);
  });

  ///Update
  function updateCourse(id, CourseNameId, CourseDesId, 
      CourseFeeId, CourseEnrollId, CourseClassId, CourseLinkId, CourseImgId) {
          if (CourseNameId.length == 0) {
              toastr.error("Course name is empty!");
          } else if (CourseDesId.length == 0) {
              toastr.error("Course Description is empty!");
          } else if (CourseFeeId.length == 0) {
              toastr.error("Course Fee is empty!");
          } else if (CourseEnrollId.length == 0) {
              toastr.error("Course Enroll is empty!");
          } else if (CourseClassId.length == 0) {
              toastr.error("Course Class is empty!");
          } else if (CourseLinkId.length == 0) {
              toastr.error("Course Link is empty!");
          } else if (CourseImgId.length == 0) {
              toastr.error("Course Image is empty!");
          }  else {
          $("#CourseEditConfirmBtn").html(
              "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
          );
          axios
              .put("/CoursesUpdate", {
                  id: id,
                  course_name: CourseNameId,
                  course_des: CourseDesId,
                  course_fee: CourseFeeId,
                  course_total_enroll: CourseEnrollId,
                  course_total_class: CourseClassId,
                  course_link: CourseLinkId,
                  course_img: CourseImgId
              })
              .then(function (response) {
                  $("#CourseEditConfirmBtn").html("Save");
                  if (response.status == 200) {
                      if (response.data == 1) {
                          $("#EditCourseModal").modal("hide");
                          toastr.success("Update Success");
                          getCoursesData();
                      } else {
                          $("#EditCourseModal").modal("hide");
                          toastr.info("You Did Not Update Anything");
                          getCoursesData();
                      }
                  } else {
                      $("#EditCourseModal").modal("hide");
                      toastr.error("Somethings went wrong!");
                  }
              })
              .catch(function (error) {
                  $("#CourseEditConfirmBtn").html("Save");
                  $("#EditCourseModal").modal("hide");
                  toastr.error("Somethings went wrong!");
              });
      }
  }

</script>
@endsection