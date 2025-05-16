@extends('layouts.theme')
@section('content')

<div class = "row" style="width:98%; margin:auto;">
    <div class="col s12">
        <h3 class="page-title">Settings | <small style="color: green">Account Settings</small></h3>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="user-profile-card panel panel-default profile-card-bootstrap">
                        <div class="profile-header">
                            @if(!empty($user->settings->header))
                                <img src="{{ asset('images/' . $user->settings->header) }}" alt="Header Image" class="img-responsive profile-header-img">
                            @else
                                <div class="profile-header-placeholder">No Header Image</div>
                            @endif
                            <div class="profile-logo">
                                @if(!empty($user->settings->logo))
                                    <img src="{{ asset('images/' . $user->settings->logo) }}" alt="Logo" class="img-circle profile-logo-img">
                                @else
                                    <div class="profile-logo-placeholder">Logo</div>
                                @endif
                            </div>
                        </div>
                        <div class="profile-body text-center">
                            <h2 class="profile-company">{{ $user->settings->company_name ?? 'Company Name' }}</h2>
                            <ul class="list-group profile-list-group">
                                <li class="list-group-item"><i class="glyphicon glyphicon-map-marker"></i> <b>Address:</b> {{ $user->settings->address ?? 'No address set' }}</li>
                                <li class="list-group-item"><i class="glyphicon glyphicon-envelope"></i> <b>Email:</b> {{ $user->settings->company_email ?? 'No Company email' }}</li>
                                <li class="list-group-item"><i class="glyphicon glyphicon-earphone"></i> <b>Phone:</b> {{ $user->settings->phone_number ?? 'No phone number' }}</li>
                            </ul>
                            <div class="profile-brand-colors">
                                <span class="brand-label">Brand Colors:</span>
                                <span class="brand-color brand-primary" style="background: {{ $user->settings->primary_color ?? '#007bff' }};"></span>
                                <span class="brand-caption">Primary</span>
                                <span class="brand-color brand-secondary" style="background: {{ $user->settings->secondary_color ?? '#6c757d' }};"></span>
                                <span class="brand-caption">Secondary</span>
                            </div>
                            

                            
                            <!-- <div class="clearfix"></div> -->




                        </div>
                    </div>
                    <div class="panel panel-default" style="width: 100%; margin: 0 auto; margin-bottom: 30px;">
                        <div class="panel-heading"><h3>Account Settings</h3></div>
                        <div class="panel-body">
                            <!-- Edit Account Section -->
                            <div class="settings-section">
                                <h4>Edit Account</h4>
                                <p class="desc-left">Update your company information, upload your logo, header image, and set your brand colors. Click the button to open the form.</p>
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#editAccountModal">Edit Account</button>
                                <div class="clearfix"></div>
                            </div>
                            <hr>
                            <!-- Change Password Section -->
                            <div class="settings-section">
                                <h4>Change Password</h4>
                                <p class="desc-left">Change your account password regularly to keep your account secure. Click the button to open the password change form.</p>
                                <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                                <div class="clearfix"></div>
                            </div>
                            <hr>
                            <!-- Notification Settings Section -->
                            <div class="settings-section">
                                <h4>Account Notification Settings</h4>
                                <p class="desc-left">Configure your SMS notification settings. Enter your SMS API key and secret key. Click the button to open the SMS configuration form.</p>
                                <button class="btn btn-info pull-right" data-toggle="modal" data-target="#smsConfigModal">SMS Configuration</button>
                                <div class="clearfix"></div>
                                @if(!empty($user->settings->sms_api_key) || !empty($user->settings->sms_api_secret))
                                    <div class="alert alert-info" style="margin-top: 10px;">
                                        <strong>Current SMS Config:</strong><br>
                                        <span><b>API Key:</b> {{ $user->settings->sms_api_key ?? 'Not set' }}</span><br>
                                        <span><b>Secret key:</b> {{ $user->settings->sms_api_secret ?? 'Not set' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('settings.updateAccount') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="editAccountModalLabel">Edit Account Details</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $user->settings->company_name ?? '') }}">
          </div>
          <div class="form-group">
            <label for="company_email">Company Email</label>
            <input type="email" class="form-control" id="company_email" name="company_email" value="{{ old('company_email', $user->settings->company_email ?? '') }}">
          </div>
          <div class="form-group">
            <label for="address">Company Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->settings->address ?? '') }}">
          </div>
          <div class="form-group">
            <label for="phone_number">Company Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->settings->phone_number ?? '') }}">
          </div>
          <div class="row form-row">
            <div class="form-group col-md-6">
                <label for="header">Header Image</label>
                <input type="file" class="form-control" id="header" name="header">
                <small class="text-muted">JPG/PNG, max 2MB, width 2550px, height 450px</small>
            </div>
            <div class="form-group  col-md-6">
                @if(!empty($user->settings->header))
                <label for="header">Current Header Image</label>
                <div style="margin-top:8px;"><img src="{{ asset('images/' . $user->settings->header) }}" alt="Header Image" style="max-width: 100px; max-height: 60px;"></div>
                @endif
            </div>
          </div>
          <div class="row form-row">
            <div class="form-group col-md-6">
                <label for="logo">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
                <small class="text-muted">JPG/PNG, max 2MB, width 250px - 500px.</small>
            </div>
            <div class="form-group col-md-6"> 
                @if(!empty($user->settings->logo))
                <label for="logo">Current Logo</label>
                <div style="margin-top:8px;"><img src="{{ asset('images/' . $user->settings->logo) }}" alt="Logo" style="max-width: 100px; max-height: 60px;"></div>
                @endif
            </div>
          </div>
          <div class="row form-row">
            <div class="form-group col-md-6">
                <label for="primary_color">Pick Primary Brand Color</label>
                <input type="color" class="form-control" id="primary_color" name="primary_color" value="{{ old('primary_color', $user->settings->primary_color ?? '#000000') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="secondary_color">Pick Secondary Brand Color</label>
                <input type="color" class="form-control" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $user->settings->secondary_color ?? '#ffffff') }}">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('settings.updatePassword') }}" method="POST">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="changePasswordModalLabel">Change Password</h4>
          @if($errors->changePassword && $errors->changePassword->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach ($errors->changePassword->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
          </div>
          <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning">Change Password</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SMS Config Modal -->
<div class="modal fade" id="smsConfigModal" tabindex="-1" role="dialog" aria-labelledby="smsConfigModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('settings.updateSmsConfig') }}" method="POST">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="smsConfigModalLabel">SMS Configuration</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="sms_api_key">SMS API Key</label>
            <input type="text" class="form-control" id="sms_api_key" name="sms_api_key" value="{{ old('sms_api_key', $user->settings->sms_api_key ?? '') }}">
          </div>
          <div class="form-group">
            <label for="sms_api_secret">SMS Secret Key</label>
            <input type="text" class="form-control" id="sms_api_secret" name="sms_api_secret" value="{{ old('sms_api_secret', $user->settings->sms_api_secret ?? '') }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save SMS Settings</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.settings-section { margin-bottom: 30px; }
.panel-heading h3 { margin: 0; }
.pull-right { float: right; }
.desc-left { float: left; max-width: 75%; }
.clearfix { clear: both; }
.profile-card-bootstrap { border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); width: 100%; max-width: 100%; margin: 0 auto 30px auto; }
.profile-header { position: relative; background: #f5f5f5; }
.profile-header-img { width: 100%; height: 180px; object-fit: cover; }
.profile-header-placeholder { width: 100%; height: 180px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #888; font-size: 20px; }
.profile-logo { position: absolute; left: 50%; top: 140px; transform: translateX(-50%); background: #fff; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.10); padding: 8px; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; }
.profile-logo-img { height: 80px; width: 80px; object-fit: contain; border-radius: 50%; }
.profile-logo-placeholder { height: 80px; width: 80px; background: #eee; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 28px; border-radius: 50%; }
.profile-body { padding: 70px 24px 24px 24px; }
.profile-company { margin-top: 0; margin-bottom: 8px; font-weight: 700; color: #222; }
/* .profile-list-group { margin: 0 auto 16px auto; max-width: 350px; text-align: left; display: inline-block; } */
.profile-brand-colors { margin-bottom: 12px; }
.brand-label { font-weight: 600; color: #444; margin-right: 10px; }
.brand-color { display: inline-block; width: 60px; height: 30px; border-radius: 10px; border: 4px solid beige; box-shadow: 0 2px 8px rgba(0,0,0,0.15); vertical-align: middle; margin-right: 6px; }
.brand-caption { font-size: 13px; color: #555; margin-right: 12px; vertical-align: middle; }

input[type="color"].form-control { width: 60px; height: 34px;padding: 0; border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.10); cursor: pointer; background: #f8f9fa; transition: box-shadow 0.2s; display: inline-block; vertical-align: middle;}
input[type="color"].form-control:focus {outline: none; box-shadow: 0 0 0 2px #007bff44, 0 2px 8px rgba(0,0,0,0.15);}
</style>
@endsection


@if($errors->changePassword && $errors->changePassword->any())
    @section('modalScript')
        <script>
            $(function() {
                $('#changePasswordModal').modal('show');
            });
        </script>
    @endsection
@endif
