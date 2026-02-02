@extends('layouts.header')
@section('content')

<style type="text/css">
  /*.select2.loc_id {
  border: none !important;
}*/
  /*.loc_id .select2-container{
  border: none !important;
}*/
  #sel2 .loc_id .select2-container {
    border: none !important;

  }

  .select2-container--default .select2-selection--multiple {
    border: none;
  }

  .select2-container--default.select2-container--focus .select2-selection--multiple {
    border: none;
  }

  .select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    background-color: #fff;
    border: 1px solid #375a80;
    border-radius: 5px;
    box-shadow: none;
    color: #000;
    text-align: center;
    max-width: 100%;
    transition: all 300ms linear 0s;
    position: relative;
    vertical-align: middle;
    height: auto;
  }

  .form-control {
    padding: 3px 12px;
  }
</style>
<div class="ajaxLoading"></div>
<?php include('tools_menu.php');
?>
<span class="ui_close_btn"></span>
<?php if ($pageMethod == "myprofile") { ?>
  <h2 class="heads">My Profile
    <span class="ui_close_btn">
      <a class="collapse-close pull-right btn-danger close" onclick='location.href="{{ url('user') }}"'></a>
    </span>
  </h2>
<?php } else { ?>
  <h2 class="heads">Create User
    <span class="ui_close_btn">
      <a class="collapse-close pull-right btn-danger close" onclick='location.href="{{ url('user') }}"'></a>
    </span>
  </h2>
<?php } ?>
<form autocomplete="off" action=" " id="user_form" class="user_form" data-parsley-validate autocomplete="off">
  {{ csrf_field() }}
  <input type="hidden" value="" name="savestatus" id="savestatus" />


  <div class="card">

    <div class="card-body card-block">


      <div class="row">

        <div class="col-md-4">

          <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>User Name</label>
            <div class="col-md-8">

              <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $row->employee_id; ?>" />
              <input class="form-control user_id" id="user_id" name="user_id" size="16" type="hidden" value="{{$row->user_id}}">
              <?php if ($row->user_id != "") { ?>
                <input type="text" id="username" class="form-control username" value="{{$row->username}}" autocomplete="off" required>
              <?php } else { ?>
                <input type="text" id="username" name="username" class="form-control username" value="" autocomplete="off" required>
              <?php } ?>
            </div>

          </div>


          <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>First Name</label>
            <div class="col-md-8">

              <input type="text" id="first_name" name="first_name" class="form-control first_name" value="{{$row->first_name}}" required>
            </div>

          </div>

          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>E-mail</label>
            <div class="col-md-8">

              <input type="text" id="email" name="email" class="form-control E-mail email" value="{{$row->email}}" required>
              <span class="btn btn-danger email_vali" id="" style="display:none;font-size: 9px"> Email format is example123@gmail.com</span>
            </div>

          </div>

          <div class="form-group row company pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4">Company</label>
            <div class="col-md-8 comp read">
              <select name='company_id' rows='5' class='select2' data-show-subtext="true" data-live-search="true">{!! $row->comp_id !!}

              </select>
            </div>

          </div>
          <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">Avatar
              <?php if ($row->user_id != "") {
                $image = $row->avatar == "" ? "profile_none.jpg" : $row->avatar ?>
                <img id="myImg" src="{{asset('images/profile_images/'.$image)}}" alt="your image" height="20px" width="20px"><br>
              <?php  } ?></label>
            <div class="col-md-8">


              <input type="file" name='avatar' rows='5' class='form-control avatar' id="avatar">
            </div>

          </div>
          <?php if ($pageMethod == "myprofile") { ?>
            <div class="form-group row user_mail">
              <label for="inputIsValid" class="form-control-label col-md-4">User Mail</label>
              <div class="col-md-8 comp ">
                <input type="text" id="user_mail" name="user_mail" class="form-control E-mail user_mail" value="{{$row->user_mail}}" required>
                <span class="btn btn-danger email_user_mail" id="" style="display:none;font-size: 9px"> Email format is example123@gmail.com</span>
              </div>

            </div>
            <div class="form-group row user_password">
              <label for="inputIsValid" class="form-control-label col-md-4">User Password</label>
              <div class="col-md-8">
                <input type="password" name='user_password' rows='5' class='form-control user_password' id="user_password" value="" autocomplete="off">

              </div>

            </div>


          <?php } ?>

        </div>
        <div class="col-md-4">
          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Group</label>
            <div class="col-md-8 sel2">
              <select name='group_id' rows='5' class='form-control select2 group_id' required>{!! $row->group_id !!}
              </select>
            </div>

          </div>

          <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">Last Name</label>
            <div class="col-md-8">

              <input type="text" id="last_name" name="last_name" class="form-control last_name" value="{{$row->last_name}}">
            </div>

          </div>

          <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Mobile Number</label>
            <div class="col-md-8">

              <input type="text" id="mobile_no" name="mobile_no" maxlength="12" class="form-control mobile_no" value="{{$row->mobile_no}}" required>
            </div>

          </div>






          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Location</label>
            <div class="col-md-8">
              <select name='loc_id' rows='5' class='form-control select2 loc_id' data-show-subtext="true" data-live-search="true" required>
                {!! $row->loc_id !!}

              </select>

            </div>

          </div>
          <div class="form-group row">
            <?php if ($row->user_id != "") { ?>
              <label for="inputIsValid" class="form-control-label col-md-4">Change Password</label>
            <?php } else { ?>
              <label for="inputIsValid" class="form-control-label col-md-4"> Password</label>
            <?php } ?>
            <div class="col-md-8">
              <input type="password" name='password' rows='5' class='form-control password' id="password" value="" autocomplete="off">
              <span id="result" style="color:green">Password Contain Caps and Special characters</span>
            </div>

          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Designation</label>
            <div class="col-md-8 sel2">
              <select name='designation_id' rows='5' class='form-control select2 designation_id' required>
                {!! $row->designation !!} </select>
            </div>

          </div>
          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Type</label>
            <div class="col-md-8 sel2">
              <select name='department_id' rows='5' class='form-control select2 department_id' required>
                {!! $row->department_id !!} </select>
            </div>

          </div>
          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Machine Department</label>
            <div class="col-md-8 sel2">
              <select name='machine_department_id' rows='5' class='form-control select2 machine_department_id' required>
                {!! $row->machine_department_id !!} </select>
            </div>

          </div>

          <div class="form-group row activecol">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Active</label>
            <div class="col-md-8 sel2">
              <select name='active' rows='5' class='form-control select2 active' required>
                <option {{$row->active == "Yes" ? "selected" : "" }} value="Yes">Yes</option>
                <option {{$row->active == "No" ? "selected" : "" }} value="No">No</option>
                {!!$row->active !!}
              </select>
            </div>

          </div>








        </div>

      </div>



      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="form-group text-center">
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">


            <button name="submit" type="button" class="btn save saveform" value="SAVE">Save</button>
            <!-- <button name="submit" type="button" class="btn save saveform" value="SAVENEW">Save and New</button> -->
            <a class='btn cancel' onclick='location.href="{{ url("user") }}"'>Cancel</a>
          </div>
        </div>
      </div>



    </div>


  </div>



</form>






<script>
  $(document).ready(function() {
    var profile = '<?php echo $pageMethod; ?>';
    if (profile == "myprofile") {
      $('.pagemethod').attr('readonly', true);
      $('.pagemethod').css('pointer-events', 'none');
      $('.activecol').hide();
    } else {
      $('.pagemethod').attr('readonly', false);
      $('.pagemethod').css('pointer-events', 'auto');
      $('.activecol').show();

    }


    var id = "{{$row->user_id}}";
    if (!id) {
      $('.username').val(" ");
      $('.password').val("");
    }

    $('.read').css('pointer-events', 'none');
    $('.company').css('pointer-events', 'none');

    /**************** email validation start ***********/
    function ValidateEmail(email) {

      var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
      return expr.test(email);
    };


    $(document).on('click', '.saveform', function() {
      if ($("#email").val() != "") {

        if (!ValidateEmail($("#email").val())) {
          $('.email_vali').attr('id', 1);
        } else {
          $('.email_vali').attr('id', 0);
        }
      }
    });
    /**************** email validation end ***********/



    $(function() {

      $('.password').keyup(function() {

        var pass_check = checkStrength($('.password').val());
        if (pass_check == "Too short" || pass_check == "Weak") {
          $('#result').css("color", "red");

          $('.save').prop("disabled", true);
        } else {
          $('#result').css("color", "green");
          $('.save').prop("disabled", false);

        }
        $('#result').html(pass_check);
      });

      function checkStrength(password) {
        /*initial strength*/
        var strength = 0

        /*if the password length is less than 6, return message.*/
        if (password.length < 5) {
          $('#result').removeClass()
          $('#result').addClass('short')
          return 'Too short'
        }

        /*length is ok, lets continue.*/

        /*if length is 8 characters or more, increase strength value*/
        if (password.length > 5) strength += 1

        /*if password contains both lower and uppercase characters, increase strength value*/
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1

        /*if it has numbers and characters, increase strength value*/
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1

        /*if it has one special character, increase strength value*/
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

        /*if it has two special characters, increase strength value*/
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

        /*now we have calculated strength value, we can return messages*/

        /*if value is less than 2*/
        if (strength < 2) {
          $('#result').removeClass()
          $('#result').addClass('weak')
          return 'Weak'
        } else if (strength == 2) {
          $('#result').removeClass()
          $('#result').addClass('good')
          return 'Good'
        } else {
          $('#result').removeClass()
          $('#result').addClass('strong')
          return 'Strong'
        }
      }
    });

    jQuery('.mobile_no').keyup(function() {
      this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    $('.first_name,.last_name').keyup(function() {
      $(this).val($(this).val().toUpperCase());
    });
    $('#savestatus').val('');
    $(document).on('click', '.saveform', function() {

      var btnval = $(this).val();
      $('#savestatus').val(btnval);
      var urls = "{{ URL::to('usersave')}}";

      validationrule('user_form');

      var form = $('#user_form');
      form.parsley().validate();

      /**************** email validation start ***********/
      var mail = $('.email_vali').attr('id');
      if (mail == 1) {
        $('.email_vali').show();
      } else {
        $('.email_vali').hide();
      }
      /**************** email validation end ***********/

      if (form.parsley().isValid() && mail != 1) {
        $('.ajaxLoading').show();
        var form_data = new FormData(document.getElementById('user_form'));
        $.ajax({
          url: "{{ URL::to('usersave') }}",
          type: "POST",
          data: form_data,
          enctype: 'multipart/form-data',
          processData: false,
          /*tell jQuery not to process the data*/
          contentType: false,
          /*tell jQuery not to set contentType*/
          async: true,
          xhr: function() {
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
              xhr.upload.addEventListener('progress', function(event) {
                var percent = 0;
                var position = event.loaded || event.position;
                var total = event.total;
                if (event.lengthComputable) {
                  percent = Math.ceil(position / total * 100);
                }
              }, true);
            }
            return xhr;

          }
        }).done(function(data, status) {
          if (data == 1) {
            notyMsgs('success', 'User Details Saved Successfully');
            setTimeout(function() {
              $('.ajaxLoading').hide();
              if (btnval == "SAVE") {
                window.location.href = "{{URL::to('user')}}";
              } else {
                window.location.href = "{{URL::to('createuser')}}";
              }
            }, 2000);
          } else if (data == 2) {
            var profile = '<?php echo $pageMethod; ?>';
            if (profile == "myprofile") {
              notyMsgs('success', 'User Details  Updated Successfully');
              setTimeout(function() {
                window.location.reload();
              }, 2000);
            } else {
              notyMsgs('success', 'User Details  Updated Successfully');
              setTimeout(function() {
                $('.close').trigger('click');
              }, 2000);
            }
          } else {
            $(".alert-success").hide();
            $(".alert-danger").fadeIn(800);
          }
        }).fail(function(data, status) {
          console.log(data);
          var errors = data.responseJSON.errors;

          var errorsHtml = '';

          $.each(errors, function(key, value) {
            errorsHtml += '<p>' + value[0] + '</p>';
          });
          // errorsHtml += '</ul></div';
          notyMsg("error", errorsHtml);

          $('.ajaxLoading').hide();
          $(".alert-success").hide();
          $(".alert-danger").fadeIn(800);
          //   notyMsgs('error',data);
        });
      }


    });
  });
  $(window).on('load', function() {
    var preLoder = $("#preloader");
    preLoder.fadeOut(500);
    var backtoTop = $('.back-to-top')
    backtoTop.fadeOut(100);
  });
</script>

@include('layouts.php_js_validation')
@endsection