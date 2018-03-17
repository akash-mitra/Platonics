@extends('layouts.app')

@section('head')

<div class="container-fluid bg-light p-5 border box-shadow">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center">Hello</h3>
            <p class="text-muted text-center border-bottom pb-3">
                Click on one of the below services to Sign Up or Login
            </p>    
        </div>
    </div>

    <div class="row my-3">
        <div class="col-6 text-center">
            <a class="p-2 w-100 btn btn-lg text-center btn-google" href="/redirect/google">
                Google
            </a>    
        </div>
        <div class="col-6 text-center border-left">
            <a class="p-2 w-100 btn btn-lg text-center btn-facebook" href="/redirect/facebook">
                Facebook
            </a>    
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p class="mb-3 text-muted text-center small">
                We will never post anything in your social media
            </p>    
        </div>
    </div>

    <div class="row pt-3 border-top">
        <p class="small text-secondary text-center">
            By signing up you indicate that you have read and agree to the <a href="terms">Terms of Service</a> and <a href="privacy">Privacy Policy</a>.
        </p>
    </div>
</div>

@endsection