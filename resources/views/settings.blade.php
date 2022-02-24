
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="ChatApp">
<title>ChatApp | Settings</title>
<link rel="icon" type="image/x-icon" href="/assets/img/chat.png">
<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font.min.css">
<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="/assets/css/style.min.css">
<body class="admin">
@include('sweetalert::alert')
@if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Opps Something went wrong</strong></p>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif
    <div id="layout" class="theme-cyan">
        <div class="navigation navbar justify-content-center py-xl-4 py-md-3 py-0 px-3">
            <div class="nav flex-md-column nav-pills flex-grow-1" role="tablist" aria-orientation="vertical">
                <a class="mb-xl-3 mb-md-2 nav-link active" data-bs-toggle="pill" role="tab">
                    <img src="/storage/images/{{ $user->image }}" class="avatar sm rounded-circle" alt="user avatar" />
                </a>
                <a class="mt-xl-3 mt-md-2 nav-link" data-bs-toggle="pill" href="/home"><i class="fas fa-home"></i></a>
                <a class="mt-xl-3 mt-md-2 nav-link d-none d-sm-block" href="/settings" role="tab"><i class="fas fa-cog"></i></i></a>
                <a class="mt-xl-3 mt-md-2 nav-link" href="{{ route('logout') }}" role="tab"><i class="fas fa-sign-out-alt"></i></a>
                <a class="mt-xl-3 mt-md-2 nav-link light-dark-toggle" href="javascript:void(0);">
                    <i class="zmdi zmdi-brightness-2"></i>
                    <input class="light-dark-btn" type="checkbox">
                </a>
            </div>
            <button type="submit" class="btn sidebar-toggle-btn shadow-sm"><i class="zmdi zmdi-menu"></i></button>
        </div>

        <div class="sidebar border-end py-xl-4 py-3 px-xl-4 px-3">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-tab-user" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 text-primary text-uppercase">Profile</h4>
                    <div>
                <a href="{{ route('logout') }}" title="" class="btn btn-dark">Sign Out</a>
            </div>
        </div>
        <div class="card border-0 text-center pt-3 mb-4">
            <div class="card-body">
                <div class="card-user-avatar">
                    <img src="/storage/images/{{ $user->image }}" alt="avatar" style="width:120px;" />
                    <form class="image-upload" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="file-input" class="btn btn-secondary btn-sm"><i class="zmdi zmdi-edit"></i></label>
                        <input id="file-input" type="file" name="image" />
                        <button  value="upload" class="page__btn btn-warning mt-2" 
                        style="border:none;padding: 5px 10px;display: inline-block;border-radius: 8px;">Update</button>
                    </form>
                </div>
                <div class="card-user-detail mt-4 mb-4">
                <h5>{{ $user->name }}</h5>
                <span class="text-muted"><a href="" class="__cf_email__">{{ $user->email }}</a></span>
                <p>{{ $user->phone }}</p>
                <!-- <div class="social">
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Youtube"><i class="fab fa-youtube"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div> -->
            </div>
        </div>
    </div>

    <div class="card border-0">
        <ul class="list-group custom list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-bold">Color Scheme</span>
                    <ul class="choose-skin list-unstyled mb-0">
                        <li data-theme="indigo" data-bs-toggle="tooltip" title="Theme-Indigo"><div class="indigo"></div></li>
                        <li class="active" data-theme="cyan" data-bs-toggle="tooltip" title="Theme-Darkred"><div class="cyan"></div></li>
                        <li data-theme="green" data-bs-toggle="tooltip" title="Theme-Green"><div class="green"></div></li>
                        <li data-theme="blush" data-bs-toggle="tooltip" title="Theme-Blush"><div class="blush"></div></li>
                        <li data-theme="dark" data-bs-toggle="tooltip" title="Theme-Dark"><div class="dark"></div></li>
                    </ul>
                    </li>
            <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Facebook notifications</span>
                <label class="c_checkbox">
                    <input type="checkbox" checked="">
                    <span class="checkmark"></span>
                </label>
            </li> -->
        </div>
    </div>
</div>
</div>


@include('sidebar')

<div class="main px-xl-5 px-lg-4 px-3">
    <div class="main-body">
        <div class="body-header border-bottom py-xl-3 py-2">
            <div class="container px-0">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="media">
                            <div class="avatar sm">
                                <a href="/home" title="" class="link"><i class="fas fa-arrow-left"></i></a>
                            </div>
                            <div class="media-body overflow-hidden">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fw-bold text-truncate mb-0 me-auto">Settings</h6>
                                </div>
                                <div class="text-truncate">Last Update your profile :<span class="fw-bold"> {{ \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y | h:i:s A')}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="body-page d-flex py-xl-3 py-2">
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-overflow page-header-tabs mb-4 mt-md-5 mt-3">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#setting-general" role="tab">General</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting-security" role="tab">Security</a></li>
                        </ul>
                    </div>
                </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="setting-general" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Account Settings</h6>
                                    <span class="text-muted small">Update your account details</span>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3" method="post" action="{{ route('update') }}">
                                        @csrf
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="email" name="email" class="form-control form-control-lg" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-warning">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="setting-security" role="tabpanel">
                    <div class="row justify-content-between mb-4">
                        <div class="col-12 col-md-6">
                            <h5>Change your password</h5>
                        </div>
                    <div class="col-auto">
                        <button class="btn btn-warning">Forgot your password?</button>
                    </div>
                </div> 
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form class="row" method="POST" action="{{ route('change.password') }}">
                                    @csrf
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Current password</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" required>
                                                @error('current_password')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>New password</label>
                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" autocomplete="password" required>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Confirm password</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"  name="password_confirmation" autocomplete="password_confirmation" required>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                        <button type="button" class="btn btn-warning">Cancel</button>
                                    </div>
                                    <div class="col-lg-8 col-md-12">
                                        <div class="card bg-light border">
                                            <div class="card-body">
                                                <p class="mb-2">Password requirements</p>
                                                <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                                                <ul class="small text-muted ps-4 mb-0">
                                                    <li>Minimum 8 character</li>
                                                    <li>At least one special character</li>
                                                    <li>At least one number</li>
                                                    <li>Can’t be the same as a previous password</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<script src="/assets/vendor/jquery/jquery-3.5.1.min.js"></script>
<script src="/assets/vendor/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/template.js"></script>

</body>
</html>
