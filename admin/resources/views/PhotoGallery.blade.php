@extends('Layout.app')
@section('title', 'Photo Gallery')
@section('content')

    <div>
        <button type="button" id="addNewBtnId" class="btn btn-danger my-3 ml-3 btn-sm">+ Add New</button>
    </div>

    <div class="container-fluid justify-content-center">
        <div class="row photoRow">

        </div>
        <button id="LoadButtonId" class="btn btn-outline-info">Load More</button>
    </div>

    <!-- Add New Modal -->
    <div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-5">
                <div class="modal-body text-center">
                    <h6 class="mb-3">Add New Photo</h6>
                    <input id="imgInput" class="form-control" type="file">
                    <img id="imgPreview" class="photoGalleryImagePreview" src="{{ asset('images/default-image.png') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="photoAddConfirmBtn" type="button" class="btn btn-sm btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New Modal -->

    <!-- Delete Modal -->
    <div class="modal fade" id="photoDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-2">Do You Want To Delete</h4>
                    <h4 class="mt-2 d-none" id="photoDeleteId"></h4>
                    <h4 class="mt-2 d-none" id="photoLocationId"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button id="photoDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->

@endsection

@section('script')
    <script type="text/javascript">
        $("#addNewBtnId").click(function () {
            $("#addPhotoModal").modal("show");
        });

        $('#imgInput').change(function (){
            let reader=new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload=function (event){
                let ImageSource=event.target.result;
                $('#imgPreview').attr('src', ImageSource);
            };
        });

        $("#photoAddConfirmBtn").on('click', function (){

            $("#photoAddConfirmBtn").html(
                "<div class='spinner-grow spinner-grow-sm fast' role='status'></div>"
            );

            let photoFile = $('#imgInput').prop('files')[0];

            let formData = new FormData();
            formData.append('photo', photoFile);

            axios.post('/photoUpload', formData)
            .then(function (response){
                if(response.status==200 && response.data==1){
                    $("#photoAddConfirmBtn").html('Save');
                    $("#addPhotoModal").modal("hide");
                    toastr.success("Photo Upload Success");
                }
                else {
                    $("#photoAddConfirmBtn").html('Save');
                    $("#addPhotoModal").modal("hide");
                    toastr.error("Photo Upload Fail");
                }
            })
            .catch(function (error){
                $("#photoAddConfirmBtn").html('Save');
                $("#addPhotoModal").modal("hide");
                toastr.error("Photo Upload Fail");
            })
        });

        getPhotoJSON();
        function getPhotoJSON(){
            axios.get('/photoJSON')
                .then(function (response) {

                    $.each(response.data, function (i, item){

                        $("<div class='col-md-3 p-1'>").html(
                            "<img data-id="+item['id']+" class='imgOnRow' src="+item['location']+">"+
                            "<a data-id="+item['id']+" data-photo="+item['location']+" class='PhotoDeleteBtn btn btn-outline-danger w-100'>Delete</a>"
                        ).appendTo('.photoRow');

                    });

                    ///Delete Photo
                    $(".PhotoDeleteBtn").click(function() {
                        var id = $(this).data("id");
                        var location = $(this).data("photo");
                        $("#photoDeleteId").html(id);
                        $("#photoLocationId").html(location);
                        $("#photoDeleteModal").modal("show");
                    });
                })
                .catch(function (error) {

            })
        }
        let imageId = 0;
        function photoLoadById(FirstId, loadMoreBtn){
            imageId = imageId+4;
            let photoId = imageId+FirstId;
            let URL = '/photoJSONId/'+photoId;
            loadMoreBtn.html("<div class='spinner-grow spinner-grow-sm fast' role='status'></div>");
            axios.get(URL)
                .then(function (response) {
                    loadMoreBtn.html("Load More");
                    $.each(response.data, function (i, item){

                        $("<div class='col-md-3 p-1'>").html(
                            "<img data-id="+item['id']+" class='imgOnRow' src="+item['location']+">"+
                            "<a data-id="+item['id']+" data-photo="+item['location']+" class='PhotoDeleteBtn btn btn-outline-danger w-100'>Delete</a>"
                        ).appendTo('.photoRow');

                    });

                    ///Delete Photo
                    $(".PhotoDeleteBtn").click(function() {
                        var id = $(this).data("id");
                        var location = $(this).data("photo");
                        $("#photoDeleteId").html(id);
                        $("#photoLocationId").html(location);
                        $("#photoDeleteModal").modal("show");
                    });
                })
                .catch(function (error) {

                })
        }

        $('#LoadButtonId').on('click', function (){
            let loadMoreBtn = $(this);
           let FirstId=$('#LoadButtonId').closest('div').find('img').data('id');
            photoLoadById(FirstId, loadMoreBtn);
        });


        $('#photoDeleteConfirmBtn').click(function (){
            let id = $("#photoDeleteId").html();
            let location = $("#photoLocationId").html();
            $('#photoDeleteConfirmBtn').html("<div class='spinner-grow spinner-grow-sm fast' role='status'></div>");

            axios.post('/photoDelete', {
                id,
                location
            })
                .then(function (response){
                    if(response.status==200 && response.data==1){
                        $('#photoDeleteConfirmBtn').html("Yes");
                        $("#photoDeleteModal").modal("hide");
                        toastr.success('Photo Delete Successfully');
                        imageId = 0;
                        $('.photoRow').empty();
                        getPhotoJSON();
                    }
                    else {
                        $('#photoDeleteConfirmBtn').html("Yes");
                        $("#photoDeleteModal").modal("hide");
                        toastr.error('Photo Delete Fail');
                    }
                })
                .catch(function (error){
                    $('#photoDeleteConfirmBtn').html("Yes");
                    $("#photoDeleteModal").modal("hide");
                    toastr.error('Photo Delete Fail');
                });
        });
    </script>
@endsection
