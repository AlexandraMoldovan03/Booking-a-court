<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tenis Club Sun</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" >

<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
    .h-font{
        font-family: 'Roboto', sans-serif;
    }
    
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type=number] {
        -moz-appearance: textfield;
    }

    .custom-bg{
        background-color: #2ec1ac;
    }
    .custom-bg:hover{
        background-color: #279e8c;
       
    }
     .availability-form[
        margin-top: -50px;
        z-index: 2;
        position: relative;
     ]
     @media screen and (max-width: 575px){
         .availability-form{
             margin-top: 25px;
             padding: 0 35px;
         }
     }
</style>
 <body class="bg-light">
<?php 
      include "navbar.php";
    ?>

     <!-- Caroussel -->
     <div class="container-fluid px-lg-4 mt-4">
            <div class="swiper swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="images/IMG-20231202-WA0018.jpg" class="w-100 d-block">
                    </div>
                    <div class="swiper-slide">
                        <img src="images/IMG-20231202-WA0016.jpg" class="w-100 d-block">
                    </div>
                    <div class="swiper-slide">
                        <img src="images/balon1.jpg" class="w-100 d-block">
                    </div>
                </div>
                
            </div>
        </div>


        <!-- check availability form -->
    <div class="container availability-form">
        <div class="row">
        </div>
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form>
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-wheight: 500;"> Check-in</label>
                            <input type="date" class="form-control shadow-none">
                            <input type="time" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-wheight: 500;"> Check-out</label>
                            <input type="date" class="form-control shadow-none">
                            <input type="time" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-1 mb-lg-3 mt-2">
                        <button class="submit" style="btn text-white shadow-none custom-bg">Submit</button>

                        </div>
                    </div>
                </form>
            </div>
    </div>

    <!-- Reach us -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
    <div class container>
    <div class="row">
            
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                    <iframe class="w-100 rounded" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2768.4153344507813!2d23.55212310000001!3d46.06275900000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474ea7c587cf7ec5%3A0x9be9605d138ab278!2sStrada%20F%C3%A2nt%C3%A2nele%2084%2C%20Alba%20Iulia!5e0!3m2!1sro!2sro!4v1701540745119!5m2!1sro!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
           
    <div class="col-lg-4 col-md-4">
         <div class="bg-white p-4 rounded mb-4 "
            <h5> Call us</h5><br>
            <a href="tel: +40 753345099" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i>  +40 753345099
           
            </a>
        </div>
       
        </div>
    </div>
<br><br><br>
<br><br><br>
   
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
  var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay:{
          delay: 3500,
          disableOnInteraction: false,
      }
  });

  var swiper = new Swiper(".swiper-recenzii", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay:{
          delay: 3500,
          disableOnInteraction: false,
      }
  });

</script>

  
  </body>
</html>