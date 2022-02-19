@extends('Layout.app2')
@section('title', 'Admin Login')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="login-form bg-dark rounded p-3">
                    <form action="" class="loginForm">
                        <h2 class="text-center text-white">Log in</h2>
                        <div class="form-group">
                            <input value="" name="user" type="text" class="form-control" placeholder="Username" required="required">
                        </div>
                        <div class="form-group">
                            <input value="" name="pass" type="password" class="form-control" placeholder="Password" required="required">
                        </div>
                        <div class="form-group">
                            <button name="submit" type="submit" class="btn btn-danger btn-block">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.loginForm').on('submit', function (event){
            event.preventDefault();
            let formData=$(this).serializeArray();
            let username=formData[0]['value'];
            let password=formData[1]['value'];

            axios.post('/onLogin', {
                user:username,
                pass:password
            })
            .then(function (response){
                if(response.status==200 && response.data==1){
                    window.location.href='/';
                }
                else toastr.error('Login Fail! Try Again')
            })
            .catch(function (error){
                toastr.error('Login Fail! Try Again')
            })
        });
    </script>
@endsection
