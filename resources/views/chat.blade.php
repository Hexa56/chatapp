@php
use App\Models\message;
use App\Models\grouppeople;
$msg = message::all();
$grp =
grouppeople::join('groupss','groupss.id','=','grouppeoples.group_id')->where('grouppeoples.user_id','=',request()->session()->get('user_id'))->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<title>Private Chat</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font.min.css">
<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
  integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="/assets/css/style.min.css">
<style>
  .custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
.doc
{
  display: none;
}
.text-truncate img, .text-truncate video, .text-truncate audio
{
  width: 20px;
  height: 20px;
}

</style>
<body>
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
      <a href="index.html" class="brand">
        <img src="assets/img/chat.png" alt="" style="width: 40px;">
      </a>
      <div class="nav flex-md-column nav-pills flex-grow-1" role="tablist" aria-orientation="vertical">
        <a class="mt-xl-3 mt-md-2 nav-link active" data-toggle="pill" href="#nav-tab-chat" role="tab"><i
            class="fas fa-comments"></i></a>
        <a class="mt-xl-3 mt-md-2 nav-link" data-toggle="pill" href="#nav-tab-contact" role="tab"><i
            class="fas fa-address-book"></i></a>
        <a class="mt-xl-3 mt-md-2 nav-link" href="/settings" role="tab"><i class="fas fa-cog"></i></a>
        <a class="mt-xl-3 mt-md-2 nav-link" href="{{ route('logout') }}" role="tab"><i
            class="fas fa-sign-out-alt"></i></a>
        <a class="mt-xl-3 mt-md-2 nav-link light-dark-toggle" href="javascript:void(0);">
          <i class="zmdi zmdi-brightness-2"></i>
          <input class="light-dark-btn" type="checkbox">
        </a>

      </div>
      <button type="submit" class="btn sidebar-toggle-btn shadow-sm"><i class="zmdi zmdi-menu"></i></button>
    </div>


    <div class="sidebar border-end py-xl-4 py-3 px-xl-4 px-3">
      <div class="tab-content">
        <div class="tab-pane fade" id="nav-tab-user" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary text-uppercase">Profile</h4>
            <div>
              <a href="pages/login.html" title="" class="btn btn-dark">Sign Out</a>
            </div>
          </div>


          <div class="card border-0">
            <ul class="list-group custom list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-bold">Color scheme</span>
                <ul class="choose-skin list-unstyled mb-0">
                  <li data-theme="indigo" data-toggle="tooltip" title="Theme-Indigo">
                    <div class="indigo"></div>
                  </li>
                  <li class="active" data-theme="cyan" data-toggle="tooltip" title="Theme-Darkred">
                    <div class="cyan"></div>
                  </li>
                  <li data-theme="green" data-toggle="tooltip" title="Theme-Green">
                    <div class="green"></div>
                  </li>
                  <li data-theme="blush" data-toggle="tooltip" title="Theme-Blush">
                    <div class="blush"></div>
                  </li>
                  <li data-theme="dark" data-toggle="tooltip" title="Theme-Dark">
                    <div class="dark"></div>
                  </li>
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

        <div class="tab-pane fade show active" id="nav-tab-chat" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary text-uppercase">Chat</h4>
            <div>
              <a class="btn btn-dark" data-toggle="pill" href="#nav-tab-contact" role="tab">New Chat</a>
            </div>
          </div>

          <div class="form-group input-group-lg search mb-3">
            <i class="zmdi zmdi-search"></i>
            <input type="text" class="form-control" placeholder="Search...">
          </div>

          <ul class="chat-list">
            <li class="header d-flex justify-content-between ps-3 pe-3 mb-1">
              <span>RECENT CHATS</span>
              <div class="dropdown">
                <a class="btn btn-link px-1 py-0 border-0 text-muted dropdown-toggle"  role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                    class="zmdi zmdi-filter-list"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" >Action</a>
                  <a class="dropdown-item" >Another action</a>
                  <a class="dropdown-item" >Something else here</a>
                </div>
              </div>
            </li>
            @foreach ($data as $da)
            @php
            $recent =
            message::where('sender','=',Session::get('user'))->where('recevier','=',$da->name)->orwhere('sender','=',$da->name)->where('recevier','=',Session::get('user'))->latest('id')->get()->first();
            @endphp
            @if($da->id != Session::get('user_id') && $recent)
            <li id={{$da->id}} @if($da->status == 1) class="online card" @else class="away card" @endif>
              <div class="hover_action">
                <button type="button" class="btn btn-link text-info"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn btn-link text-warning"><i class="fas fa-star"></i></button>
                <button type="button" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
              </div>
              <a onclick="select('{{$da->name}}','{{$da->id}}')" class="card border-0">
                <div class="card-body">
                  <div class="media">
                    <div class="avatar me-3">
                      <span class="status rounded-circle"></span>
                      @if ($da->image)
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $da->image }}" alt="avatar">
                      @else
                      @php
                      $d = explode(" ", $da->name);
                      @endphp
                      <div class="avatar me-3">
                        <span class="status rounded-circle"></span>
                        <div class="avatar rounded-circle no-image cyan">
                          <span class="text-uppercase">
                            @foreach ($d as $icon)
                            {{$icon[0]." "}}
                            @endforeach
                          </span>
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="media-body overflow-hidden">
                      <div class="d-flex align-items-center mb-1">
                        <h6 class="text-truncate mb-0 me-auto fw-bold">{{$da->name}}</h6>
                        @if($recent)
                        <p class="small text-muted text-nowrap ms-4 mb-0">{{
                          \Carbon\Carbon::parse($recent->created_at)->format('d-m-Y | h:i:s A')}}</p>
                        @endif
                      </div>
                      
                      @if(preg_match("/<img/i", $recent->message))
                      <div class="text-truncate"><img src="/icons/img.png" alt="image" srcset=""></div>
                      @endif
                      @if(preg_match("/<video/i", $recent->message))
                      <div class="text-truncate"><img src="/icons/video.png" alt="video" srcset=""></div>
                      @endif
                      @if(preg_match("/<audio/i", $recent->message))
                      <div class="text-truncate"><img src="/icons/audio.png" alt="audio" srcset=""></div>
                      @endif
                      @if(preg_match("(</audio>|</video>|<img)", $recent->message) == 0)
                      <div class="text-truncate">{!! $recent->message !!}</div>
                      @endif
                    
                    </div>
                  </div>
                </div>
              </a>
            </li>
            @endif
            @endforeach

            @foreach ($grp as $g)


            <li>
              <div class="hover_action">
                <button type="button" class="btn btn-link text-info"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn btn-link text-warning"><i class="fas fa-star"></i></button>
                <button type="button" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
              </div>
              <a onclick="gselect('{{$g->name}}','{{$g->id}}')" class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="avatar me-3">
                      <span class="status rounded-circle"></span>
                      @if ($g->image)
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $g->image }}" alt="avatar">
                      @else
                      @php
                      $d = explode(" ", $g->name);
                      @endphp
                      <div class="avatar me-3">
                        <span class="status rounded-circle"></span>
                        <div class="avatar rounded-circle no-image cyan">
                          <span class="text-uppercase">
                            @foreach ($d as $icon)
                            {{$icon[0]." "}}
                            @endforeach
                          </span>
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="media-body overflow-hidden">
                      <div class="d-flex align-items-center mb-1">
                        <h6 class="text-truncate mb-0 me-auto fw-bold">{{$g->name}}</h6>
                        <p class="small text-muted text-nowrap ms-4 mb-0">07:00 am</p>
                      </div>
                      <div class="text-truncate">
                        <i class="zmdi zmdi-file-text me-1"></i> Lorem ipsum dolor sit amet consectetur, adipisicing....
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    @include("sidebar")
    <div class="main px-lg-4 px-3">
      @isset($user)
      <div class="chat-body">
        <div class="chat-header border-bottom py-xl-4 py-md-3 py-2">
          <div class="container-xxl">
            <div class="row align-items-center">
              <div class="col-6 col-xl-4">
                <div class="media">
                  <div class="me-3 show-user-detail">
                    <span class="status rounded-circle"></span>
                    @if($user->image)
                    <img class="avatar rounded-circle" src="/storage/images/{{ $user->image }}" alt="avatar">
                    @else
                    <div class="avatar me-3">
                      <span class="status rounded-circle"></span>
                      <div class="avatar rounded-circle no-image cyan">
                        @php
                        $dd = explode(" ",$user->name);
                        @endphp
                        <span class="text-uppercase">
                          @foreach ($dd as $gicon)
                          {{$gicon[0]." "}}
                          @endforeach
                        </span>
                      </div>
                    </div>
                    @endif
                  </div>
                  <div class="media-body overflow-hidden">
                    <div class="d-flex align-items-center mb-1">
                      <h6 class="text-truncate mb-0 me-auto fw-bold">{{$user->name}}</h6>
                    </div>
                    <div id="ch{{$user->id}}" class="text-truncate">@if($user->status == 1) online @else offline @endif</div>
                  </div>
                </div>
              </div>

              {{-- <div class="col-6 col-xl-8 text-end">
                <ul class="nav justify-content-end">
                  <li class="nav-item list-inline-item d-none d-md-block me-3">
                    <a  class="nav-link text-muted px-3" data-toggle="collapse" data-target="#chat-search-div"
                      aria-expanded="true" title="Search this chat">
                      <i class="fas fa-search fa-lg"></i>
                    </a>
                  </li>
                  <li class="nav-item list-inline-item d-none d-sm-block me-3">
                    <a  class="nav-link text-muted px-3" title="Video Call">
                      <i class="fas fa-video fa-lg"></i>
                    </a>
                  </li>
                  <li class="nav-item list-inline-item d-none d-sm-block me-3">
                    <a  class="nav-link text-muted px-3" title="Voice Call">
                      <i class="fas fa-phone-alt fa-lg"></i>
                    </a>
                  </li>
                </ul>
              </div> --}}
            </div>
          </div>
        </div>

        <div class="collapse" id="chat-search-div">
          <div class="container-xxl py-2">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Find messages in current conversation">
              <div class="input-group-append">
                <button type="button" class="btn btn-secondary">Search</button>
              </div>
            </div>
          </div>
        </div>


        <div id="chat" class="chat-content">
          <div class="container-xxl">
            <ul id="msg_dis" class="{{$user->id}}{{Session::GET('user_id')}} list-unstyled py-4">
              @foreach ($msg as $d)
              @if($d->sender == Session::get('user') && $d->recevier == $user->name)
              <li id="{{$d->id}}" class="d-flex message right">
                <div class="message-body">
                  <div class="message-row d-flex align-items-center justify-content-end">
                    <div class="dropdown">
                      <a class="text-muted me-1 p-2 text-muted"  data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right text-center">
                        <a class="dropdown-item" >Share <i class="fas fa-share"></i></a>
                        <a class="dropdown-item" onclick="delmsg({{$d->id}})">Delete <i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                    <div class="message-content border p-3">{!! $d->message !!}
                    </div>
                  </div>
                  <span class="date-time text-muted">{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i:s
                    A')}} <i class="fas @if($d->seen == 1) fa-check-double @else fa-check @endif  text-primary"></i></span>
                </div>
              </li>
              @endif
              @if($d->sender == $user->name && $d->recevier == Session::get('user'))
              <li id="{{$d->id}}" class="d-flex message">
                <div class="message-body">
                  <span class="date-time text-muted">{{$d->sender}} | {{
                    \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i:s A')}}</span>
                  <div class="message-row d-flex align-items-center">
                    <div class="message-content p-3">
                      {!! $d->message !!}
                    </div>
                    <div class="dropdown">
                      <a class="text-muted ms-1 p-2 text-muted"  data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right text-center">
                        <a class="dropdown-item" >Share <i class="fas fa-share"></i></a>
                        {{-- <a class="dropdown-item" onclick="delmsg({{$d->id}})">Delete <i class="fas fa-trash"></i></a> --}}
                      </div>
                    </div>

                  </div>
                </div>
              </li>
              @endif
              @endforeach
            </ul>
          </div>
        </div>

        <div class="chat-footer border-top py-xl-4 py-lg-2 py-2">
          <div class="container-xxl">
            <div class="row">
              <div class="col-12">
                <div class="input-group align-items-center">
                  @if(!isset($group))
                  <form class="d-flex w-100" id="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="{{Session::get('user_id')}}">
                    <input type="hidden" id="rev" name="rev" value="{{$user->id}}">
                    <input type="hidden" id="name" name="name" value="{{Session::get('user')}}">
                    <input type="hidden" id="reciver" name="reciver" value="{{$user->name}}"> 
                    <input type="hidden" id="dd" class="{{Session::get('user_id')}}{{$user->name}}" name="dd" value="{{$double}}"> 
                    <input autocomplete="off" type="text" onblur="online({{Session::get('user_id')}})" onclick="typing({{Session::get('user_id')}})" id="msg" name="msg" class="form-control border-0 pl-0 text-muted"
                      style="font-size:18px;" placeholder="Type your message...">
                    <div class="input-group-append">
                      <span class="input-group-text border-0">
                        <button class="btn btn-sm btn-link text-muted" data-toggle="tooltip" title="Emoji"
                          type="button"><i class="far fa-smile font-22"></i></button>
                      </span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text border-0">
                        <label class="custom-file-upload text-muted">
                          <input type="file" name="file" class="doc"/>
                          <i class="fas fa-paperclip font-22"></i>
                      </label>
                        
                     
                      </span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text border-0 pr-0">
                        <button type="submit" class="btn btn-primary">
                          <span class="d-none d-md-inline-block me-2">Send</span>
                          <i class="fas fa-paper-plane"></i>
                        </button>
                      </span>
                    </div>
                  </form>
                  @else
                  <form class="d-flex w-100" id="gform" method="POST">
                    @csrf
                    <input type="hidden" id="sname" name="sname" value="{{Session::get('user')}}">
                    <input type="hidden" id="gname" name="gname" value="{{$user->name}}">
                    <input type="hidden" id="gid" name="gid" value="{{$user->id}}">
                    <input type="text" id="gmsg" name="gmsg" class="form-control border-0 pl-0 text-muted"
                      style="font-size:18px;" placeholder="Type your message...">
                    <div class="input-group-append">
                      <span class="input-group-text border-0">
                        <button class="btn btn-sm btn-link text-muted" data-toggle="tooltip" title="Emoji"
                          type="button"><i class="far fa-smile font-22"></i></button>
                      </span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text border-0">
                        <label class="custom-file-upload  text-muted">
                          <input type="file" name="doc" class="doc"/>
                          <i class="fas fa-paperclip font-22"></i>
                      </label>
                        
                     
                      </span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text border-0 pr-0">
                        <button type="submit" class="btn btn-primary">
                          <span class="d-none d-md-inline-block me-2">Send</span>
                          <i class="fas fa-paper-plane"></i>
                        </button>
                      </span>
                    </div>

                  </form>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endisset

      @isset($user)
      <div class="user-detail-sidebar py-xl-4 py-3 px-xl-4 px-3">
        <div class="d-flex flex-column">
          <div class="header border-bottom pb-4 d-flex justify-content-between">
            <div>
              <h6 class="mb-0 font-weight-bold">User Details</h6>
            </div>
            <div>
              <button class="btn btn-link text-muted close-chat-sidebar" type="button"><i
                  class="fas fa-times fa-lg"></i></button>
            </div>
          </div>
          <div class="body mt-4">
            <div class="d-flex justify-content-center">
              <div class="avatar xxl">
                <img class="avatar xxl rounded-circle" src="/storage/images/{{ $user->image }}" alt="avatar">
              </div>
            </div>
            <div class="text-center mt-3 mb-5">
              <h4>{{ $user->name }}</h4>
              <span class="text-muted"><a >{{ $user->email }}</a></span>
              <p>{{ $user->phone }}</p>
            </div>


          </div>
        </div>
      </div>
      @endisset



      <div class="modal fade" id="InviteFriends" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Invite New Friends</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label>Email address</label>
                  <input type="email" class="form-control">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
                </div>
              </form>
              <div class="mt-5">
                <button type="button" class="btn btn-primary">Send Invite</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
    <script src="/./js/app.js"></script>
    <script>
      function select(name, id) {
        localStorage.setItem('selected', name);
        location.href = "/select/" + id;
      }
      function gselect(name, id) {
        localStorage.setItem('selected', name);
        location.href = "/group/" + id;
      }

      $('document').ready(function () {
        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;
        $('#g').click(function () {
          $("*#chat").hide();
          $("*#gchat").show();
        });
        $('#c').click(function () {
          $("*#gchat").hide();
          $("*#chat").show();
        })
      });

      $('#gform').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: '/chat',
          data: $(this).serialize(),
          success: function (msg) {
            document.getElementById("gmsg").value = ""
          }
        });
      });
      function delmsg(id)
      {
        $("#"+id).addClass('d-none');
        $.ajax({
          type: "GET",
          url: '/msgdel/'+id,
          success: function (msg) {
            
          }
        });
      }
      function typing(id)
      {
        
        $.ajax({
            type: "GET",
            url: '/typing/'+id,
          });
      
      }
      function online(id)
      {
        $.ajax({
          type: "GET",
          url: '/notyping/'+id,
        });
      }
    </script>
 
    <script src="/assets/vendor/jquery/jquery-3.5.1.min.js"></script>
    <script src="/assets/vendor/bootstrap.bundle.min.js"></script>

    <script src="/assets/vendor/bootstrap-datepicker.min.js"></script>

    <script src="/assets/js/template.js"></script>
</body>

</html>