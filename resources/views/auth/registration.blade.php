<title>Sign Up</title>
@extends('auth.template')  
@section('content')

<div id="layout" class="theme-cyan">
    <div class="authentication">
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center no-gutters min-vh-100">
                <div class="col-12 col-md-7 col-lg-5 col-xl-4 py-md-11">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            @if (session('status'))
                                <h6 class="alert alert-success font-weight-bold">{{ session('status') }}</h6>
                            @endif
                            <h3 class="text-center">Sign up</h3>
                            <p class="text-center mb-6">Create your free Account</p>    
                            <form class="mb-4 mt-5" action="{{ route('register.post') }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter your Name">
                                    @if ($errors->has('name'))
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="input-group mb-2">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your Email">
                                    @if ($errors->has('email'))
                                      <span class="text-danger" >{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="input-group mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your Password">
                                    @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-lg btn-primary" title="">Sign up</button>
                                </div>
                            </form>
                            <p class="text-center mb-0">Already have an account? <a class="link" href="/">Sign in</a>.</p>
                            <div class="mt-4 d-grid gap-1">
                                <button type="button" class="btn btn-block btn-outline-google">Signup with Google</button>
                                <button type="button" class="btn btn-block btn-outline-facebook">Signup with Facebook</button>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="signin-img d-none d-lg-block text-center">
            <img src="assets/img/auth-img.svg" alt="Sign In Image" />
        </div>
    </div> 
</div>
</div>
</div>

@endsection