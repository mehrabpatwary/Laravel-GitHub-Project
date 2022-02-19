// Owl Carousel Start..................

$(document).ready(function() {
    var one = $("#one");
    var two = $("#two");

    $('#customNextBtn').click(function() {
        one.trigger('next.owl.carousel');
    })
    $('#customPrevBtn').click(function() {
        one.trigger('prev.owl.carousel');
    })
    one.owlCarousel({
        autoplay:true,
        loop:true,
        dot:true,
        autoplayHoverPause:true,
        autoplaySpeed:100,
        margin:10,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });

    two.owlCarousel({
        autoplay:true,
        loop:true,
        dot:true,
        autoplayHoverPause:true,
        autoplaySpeed:100,
        margin:10,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

});

// Owl Carousel End..................

// contact Section

$('#contact_submit_id').click(function (){
    let contact_name = $('#contact_name_id').val();
    let contact_mobile = $('#contact_mobile_id').val();
    let contact_email = $('#contact_email_id').val();
    let contact_msg = $('#contact_msg_id').val();
    postContact(contact_name, contact_mobile, contact_email, contact_msg);
});

function postContact(contact_name, contact_mobile, contact_email, contact_msg){
    if(contact_name.length==0){
        $('#contact_submit_id').html("আপনার নাম লিখুন");
        setTimeout(function (){
            $('#contact_submit_id').html("পাঠিয়ে দিন");
        }, 2000);
    }
    else if(contact_mobile.length==0){
        $('#contact_submit_id').html("আপনার মোবাইল নাম্বার লিখুন");
        setTimeout(function (){
            $('#contact_submit_id').html("পাঠিয়ে দিন");
        }, 2000);
    }
    else if(contact_email.length==0){
        $('#contact_submit_id').html("আপনার ইমেইল লিখুন");
        setTimeout(function (){
            $('#contact_submit_id').html("পাঠিয়ে দিন");
        }, 2000);
    }
    else if(contact_msg.length==0){
        $('#contact_submit_id').html("আপনার মেসেজ লিখুন");
        setTimeout(function (){
            $('#contact_submit_id').html("পাঠিয়ে দিন");
        }, 2000);
    }
    else{
        $('#contact_submit_id').html("পাঠানো হচ্ছে");
        axios.post('/contact', {
            contact_name:contact_name,
            contact_mobile:contact_mobile,
            contact_email:contact_email,
            contact_msg:contact_msg

        })
            .then(function (response){
                if(response.status==200){
                    $('#contact_submit_id').html("তথ্য সংরক্ষিত হয়েছে");
                    setTimeout(function (){
                        $('#contact_submit_id').html("পাঠিয়ে দিন");
                    }, 3000);
                }
                else {
                    $('#contact_submit_id').html("আবার চেষ্টা করুন");
                    setTimeout(function () {
                        $('#contact_submit_id').html("পাঠিয়ে দিন");
                    }, 3000);
                }
            })
            .catch(function (error){
                $('#contact_submit_id').html("আবার চেষ্টা করুন");
                setTimeout(function () {
                    $('#contact_submit_id').html("পাঠিয়ে দিন");
                }, 3000);
            })
    }
}

// contact Section
