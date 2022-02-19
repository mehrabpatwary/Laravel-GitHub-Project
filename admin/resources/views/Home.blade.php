@extends('Layout.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalVisitor }}</h5>
                        <p class="card-text">Total Visitor</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalServices }}</h5>
                        <p class="card-text">Total Services</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalCourses }}</h5>
                        <p class="card-text">Total Courses</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalProjects }}</h5>
                        <p class="card-text">Total Projects</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalContact }}</h5>
                        <p class="card-text">Total Contacts</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalReview }}</h5>
                        <p class="card-text">Total Review</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
