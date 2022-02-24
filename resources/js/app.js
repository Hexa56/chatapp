const { default: axios } = require('axios');
const { fromPairs } = require('lodash');

require('./bootstrap');


const div = document.getElementById("msg_dis");
const susername = document.getElementById("sname");

    const username = document.getElementById("name");
    
//     $("#form").on('submit', function(e)
//     {
    
//      e.preventDefault();
//      axios.post('/chat', {
//         name: username.value,
//         msg: message.value,
//         reciver: reciver.value
//       });
//       message.value = "";
// });



  $("#form").on('submit',(function(e) {
   e.preventDefault();
   $.ajax({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
     url: "/chat",
    type: "POST",
    data:  new FormData(this),
    contentType: false,
          cache: false,
    processData:false,      
     });
     document.getElementById('msg').value = '';
  }));

  var channel3 = Echo.channel('Tick');

  channel3.listen('.tick', function(data) {
    
      $("."+data.myid+data.oid+" span i").removeClass('fa-check');
      $("."+data.myid+data.oid+" span i").addClass('fa-check-double');
      
  });

  var channel2 = Echo.channel('status');

  channel2.listen('.check', function(data) {
    if(data.status == 'online')
    {
      $("li#"+data.id).removeClass('away');
      $("li#"+data.id).addClass('online');
      $("#ch"+data.id).text("online");
    }
    else if(data.status == 'away')
    {
      $("li#"+data.id).removeClass('online');
      $("li#"+data.id).addClass('away');
      $("#ch"+data.id).text("offline");
    }
    else if(data.status == "typing")
    {
      $("#ch"+data.id).text("typing...");
    }
    else
    {
      $("#ch"+data.id).text("online");
    }

  });

  var channell = Echo.channel('delmsg');

  channell.listen('.delete', function(data) {
    $("#"+data.id).addClass('d-none');
  });


var channel = Echo.channel('chat');

channel.listen('.msg', function(data) {
    
    if(data.group_name == localStorage.getItem('selected'))
    {
        
        if(data.sender == susername.value)
        {
          div.innerHTML += '<li id="'+ data.id +'" class="d-flex message right">'+
          '<div class="message-body">'+
            '<div class="message-row d-flex align-items-center justify-content-end">'+
      
              '<div class="dropdown">'+
               ' <a class="text-muted me-1 p-2 text-muted" href="#" data-toggle="dropdown" aria-haspopup="true"'+
                  'aria-expanded="false">'+
                  '<i class="fas fa-ellipsis-v"></i>'+
                '</a>'+
                '<div class="dropdown-menu">'+
                  '<a class="dropdown-item" href="#">Share <i class="fas fa-share"></i></a>'+
                  '<a class="dropdown-item" onclick="delmsg('+data.id+')">Delete <i class="fas fa-trash"></i></a>'+
                '</div>'+
              '</div>'+
              '<div class="message-content border p-3">'+data.message +
              '</div>'+
            '</div>'+
            '<span class="date-time text-muted">'+ data.time +'<i class="fas fa-check text-primary"></i></span>'+
         '</div>'+
        '</li>';
        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;        }
        else
        {
          div.innerHTML += '<li id="'+ data.id +'" class="d-flex message">'+
          '<div class="message-body">'+
            '<span class="date-time text-muted">'+data.sender+'|'+ data.time+'</span>'+
            '<div class="message-row d-flex align-items-center">'+
              '<div class="message-content p-3">'+data.message +
             '</div>'+
              '<div class="dropdown">'+
                '<a class="text-muted ms-1 p-2 text-muted" href="#" data-toggle="dropdown" aria-haspopup="true"'+
                  'aria-expanded="false">'+
                  '<i class="fas fa-ellipsis-v"></i>'+
                '<div class="dropdown-menu dropdown-menu-right">'+
                  '<a class="dropdown-item" href="#">Share <i class="fas fa-share"></i></a>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'+
        '</li>';
        var myDiv = document.getElementById("chat");
          myDiv.scrollTop = myDiv.scrollHeight; 
        }
    }
    else
    {
  
    // if(data.reciver == username.value)
    // {
    //     count ++;
    //     document.getElementById(data.sender).innerHTML = "<span class='bg-warning p-1'>"+count+"</span>";
    // }
    if(data.reciver == localStorage.getItem('selected') && data.sender == username.value)
    {
    div.innerHTML += '<li id="'+ data.id +'" class="d-flex message right">'+
    '<div class="message-body">'+
      '<div class="message-row d-flex align-items-center justify-content-end">'+

        '<div class="dropdown">'+
         ' <a class="text-muted me-1 p-2 text-muted" href="#" data-toggle="dropdown" aria-haspopup="true"'+
            'aria-expanded="false">'+
            '<i class="fas fa-ellipsis-v"></i>'+
          '</a>'+
          '<div class="dropdown-menu">'+
            '<a class="dropdown-item" href="#">Share <i class="fas fa-share"></i></a>'+
            '<a class="dropdown-item" onclick="delmsg('+data.id+')">Delete <i class="fas fa-trash"></i></a>'+
          '</div>'+
        '</div>'+
        '<div class="message-content border p-3">'+data.msg +
        '</div>'+
      '</div>'+
      '<span class="date-time text-muted">'+ data.time +'<i class="fas fa-check text-primary"></i></span>'+
   '</div>'+
  '</li>';
  var myDiv = document.getElementById("chat");
  myDiv.scrollTop = myDiv.scrollHeight;
    }
    else if(data.reciver == username.value && data.sender == localStorage.getItem('selected'))
    {
    div.innerHTML += '<li id="'+ data.id +'" class="d-flex message">'+
    '<div class="message-body">'+
      '<span class="date-time text-muted">'+data.sender+'|'+ data.time+'</span>'+
      '<div class="message-row d-flex align-items-center">'+
        '<div class="message-content p-3">'+data.msg +
       '</div>'+
        '<div class="dropdown">'+
          '<a class="text-muted ms-1 p-2 text-muted" href="#" data-toggle="dropdown" aria-haspopup="true"'+
            'aria-expanded="false">'+
            '<i class="fas fa-ellipsis-v"></i>'+
          '<div class="dropdown-menu dropdown-menu-right">'+
            '<a class="dropdown-item" href="#">Share <i class="fas fa-share"></i></a>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
  '</li>';
  var myDiv = document.getElementById("chat");
    myDiv.scrollTop = myDiv.scrollHeight;
    }
}

});


