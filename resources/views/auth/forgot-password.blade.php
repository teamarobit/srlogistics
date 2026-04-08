@extends('layouts.guest')

@section('css')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<style>
.form-control{
    min-height: 45px;
    border: 1px solid #dfdfdf;
    font-size: 13px;
}
.btn-primary{
    padding: 15px 30px;
}
body{
    background: #fff;
}
        
/*login_wrapper*/

.login_wrapper {
    margin: 0; 
    padding: 20px; 
    background: #032671;

}
            
.login_wrapper .loginbd {margin:0;padding: 20px;background: #fff;
box-shadow: 0px 0px 6px -1px rgba(0,0,0, 0.5);border-radius: 13px;}

.login_wrapper .loginbd .item_row {
    align-items: center;
    justify-content: center;
}
            
.login_wrapper .login_ltbd {
    margin: 0 26px 0 0;
    padding: 0;
    position: relative;
}

.login_wrapper .login_ltbd img {
    width: 100%;
    height: 100vh;
    object-fit: cover;
}
            
.login_wrapper .login_ltbd .textbd {
    margin: 0;
    padding: 20px;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: end;
    flex-direction: column;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.008) -12.95%, rgb(0 21 78 / 0%) 17.98%, rgb(0 17 48 / 7%) 44.87%, rgb(0 13 46 / 80%) 74.52%);
}
.login_wrapper .login_ltbd .textbd p {
    margin: 0;
    padding: 0;
    font-size: 12px;
    line-height: 18px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 400;
}
            
.login_wrapper .login_ltbd .textbd h2 {
    margin: 0;
    padding: 10px 0;
    font-size: 26px;
    line-height: 32px;
    color: #fff;
    font-weight: 500;
    text-align: center;
}
            
.login_wrapper .login_ltbd .textbd .button_sec {
    margin: 20px 0 0 0;
    padding: 12px 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff75;
    border-radius: 4px;
}
            
.login_wrapper .login_ltbd .textbd .button_sec p {
    margin: 0;
    padding: 0 10px 0 0;
    font-size: 12px;
    line-height: 18px;
    color: #fff;
    text-transform: initial;
    font-weight: 400;
}
            
.login_wrapper .login_ltbd .textbd .button_sec a {
    margin: 0;
    padding: 0;
    display: inline-block;
    font-size: 12px;
    line-height: 15px;
    color: #001150;
}
            
.login_wrapper .itemcard_body {
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
}
            
.login_wrapper .itemcard_body .title_top {
    margin: 0;
    padding: 0 0 20px 0;
}
            
.login_wrapper .itemcard_body .title_top p {
    margin: 0;
    padding: 0;
    font-size: 22px;
    color: #032671;
    font-weight: bold;
    text-transform: uppercase;
}
            
.login_wrapper .itemcard_body .title_top span {
    margin: 0;
    padding: 0;
    display: block;
    font-size: 28px;
    line-height: 36px;
    font-weight: 300;
    color: #032671;
}
            
.login_wrapper .itemcard_body .itemform {   }
.login_wrapper .itemcard_body .itemform .form-control {
    padding: 10px 34px 10px 10px;
    font-size: 14px;
    line-height: 20px;
}
            
.login_wrapper .itemcard_body .itemform .forgotpas_sec { margin:0; padding:0;  }
.login_wrapper .itemcard_body .itemform .forgotpas_sec .item_row {  }
.login_wrapper .itemcard_body .itemform .forgotpas_sec { margin:0; padding:0;  }

.login_wrapper .itemcard_body .itemform .forgot_pas {margin:0;padding:0;font-size: 12px;line-height: 18px;color: #032671;}

.login_wrapper .itemcard_body .itemform .forgot_pas:hover {  color: #5088ff; }
.login_wrapper .itemcard_body .itemform .login_btn { 
    text-align: right;
    display: inline-block;
    float: right;
    margin: 0;
    padding: 8px 17px;
    font-size: 13px;
    line-height: 19px;
    color: #ffffff;
    background: #032671;
    border-radius: 4px;
    text-transform: uppercase;
}
            
.login_wrapper .itemcard_body .copyright_sec {
    margin: 0;
    padding: 0 0 15px 0;
    font-size: 11px;
    line-height: 16px;
    color: #444;
    position: absolute;
    bottom: 0;
    display: block;
    text-align: center;
    width: 100%;
}
            
/*login_wrapper*/
</style>
@endsection

@section('content')
<div class="layout-wrapper">
    
    <div class="login_wrapper">
            <div class="container-fluid">
                <div class="loginbd">
                    <div class="row item_row">
                    
                    <div class="col-12 col-md-8">
                        <div class="login_ltbd">
                            
                            <!--slider_sec-->
                            <div class="loginslider_wrapper">
                                
                                <div class="loginslider">
                                    <div class="item">
                                       <img src="{{ asset('public/images/login-img012.png') }}" width="100%">
                                    </div>
                                </div>
                                
                            </div>
                            <!--slider_sec-->
                            
                            <div class="textbd">
                                <p>ONE PLATFORM FOR ALL ROAD FREIGHT</p>
                                <h2>Visibility, Efficiency,<br>Sustainainability</h2>
                                <div class="button_sec">
                                    <p>Join the SR Logistics</p>
                                    <!--<a href="#">Sign Up <i class="uil uil-arrow-right"></i></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                       <div class="itemcard_body">
                           
                                {{--@if ($errors->any())
                                    <div class="alert alert-warning">
                                        <strong>Error:</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                        
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif--}}
                           
                               <div class="title_top">
                                   <p>SR Logistics</p>
                                   <span>Reset Password</span>
                               </div>
                                
                                <form method="POST" action="{{ route('password.change') }}" class="itemform">
                                    @csrf
                                    
                                    <div class="form-group position-relative">
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                                        <i class="uil uil-envelope psw-tgl"></i>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group position-relative">
                                        <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                                        <i class="uil uil-eye-slash psw-tgl"></i>
                                        @error('old_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group position-relative">
                                        <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                        <i class="uil uil-eye-slash psw-tgl"></i>
                                        @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    
                                    <div class="forgotpas_sec">
                                        <div class="row item_row">
                                            
                                            <div class="col-12 col-md-6">
                                                <a href="{{ route('login') }}" class="forgot_pas">Back to Login</a>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 ">
                                                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                            </div>
                                            <!--<div class="mt-2">-->
                                            <!--    <p class="text-secondary mb-0" style="font-size: 12px;">After resetting your password a linking will be sent to your email with instructions</p>-->
                                            <!--</div>-->
                                            
                                        </div>
                                    </div>
                                    
                                </form>

                                <p class="copyright_sec">&copy; Copyright {{ date('Y') }} <b>SR Logistics</b> - All rights reserved</p>
                                
                            </div>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    
</div>

@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function(){
    $('.uil-eye-slash').click(function(){
      $(this).toggleClass('uil-eye');
      $(this).toggleClass('uil-eye-slash');
      const type = $('#psw').attr("type") === "password" ? "text" : "password";
      $('#psw').attr("type", type);
    })
});

// banner-slider
$('.loginslider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: false,
  infinite: true,
  touchThreshold: 20,
  swipeToSlide: true,
  speed: 500,
  autoplay: true,
  autoplaySpeed: 2000,
  swipeToSlide: true,
  
});
// banner-slider

</script>

@endsection
