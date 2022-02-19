@extends('Layout.app')
@section('title', 'Contact')
@section('content')
    <div class="container-fluid jumbotron mt-5 ">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6  text-center">
                <h1 class="page-top-title mt-3">- যোগাযোগ করুন -</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14611.390630585527!2d90.39429536854745!3d23.717133699212862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8fd46c31205%3A0xf7b6fb1e0624cd61!2sBangshal%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1645209014203!5m2!1sen!2sbd"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <div class="col-md-6">
                    <h3 class="service-card-title">ঠিকানা</h3>
                    <hr>
                    <p class="footer-text"><i class="fas fa-map-marker-alt"></i> বংশাল, পুরান ঢাকা
                        <i class="fas ml-2 fa-phone"></i> ০১৯৩৮৪১৫৬২৫
                        <i class="fas ml-2 fa-envelope"></i> Mehrab@Yahoo.com</p>
                    <div class="form-group ">
                        <input type="text" id="contact_name_id" class="form-control w-100" placeholder="আপনার নাম">
                    </div>
                    <div class="form-group">
                        <input type="text" id="contact_mobile_id" class="form-control  w-100" placeholder="মোবাইল নং ">
                    </div>
                    <div class="form-group">
                        <input type="text" id="contact_email_id" class="form-control  w-100" placeholder="ইমেইল ">
                    </div>
                    <div class="form-group">
                        <input type="text" id="contact_msg_id" class="form-control  w-100" placeholder="মেসেজ ">
                    </div>
                    <button type="submit" id="contact_submit_id" class="btn btn-block normal-btn w-100">পাঠিয়ে দিন </button>
                </div>

            </div>
        </div>
    </div>
@endsection
