@extends('layouts.app', [
    'namePage' => 'Welcome',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'welcome',
    'backgroundImage' => asset('assets') . "/img/bg14.jpg",
])

@section('content')
  <div class="content">
    <div class="container">
      <div class="col-md-12 ml-auto mr-auto">
          <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
              <div class="container">
                  <div class="header-body text-center mb-7">
                      <div class="row justify-content-center">
                          <div class="col-lg-12 col-md-9">
                              <h3 class="text-white">{{ __('Welcome to ShadowNotes.') }}</h3>
                              <p class="text-lead text-light mt-3 mb-0">Secure, private notes with zkLogin
                                  @include('alerts.migrations_check')
                              </p>
                              <div id="zkLoginContainer" class="mt-4">
                                    <!-- zkLogin will render here -->
                                    <button id="googleLoginBtn" class="btn btn-round btn-google">
                                        <i class="fab fa-google"></i> Continue with Google (zkLogin)
                                    </button>
                                </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-4 ml-auto mr-auto">
      </div>
    </div>
  </div>
@endsection

@push('js')
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="{{ asset('js/zklogin.js') }}"></script>
  <script>
    $(document).ready(function() {
      demo.checkFullPageBackgroundImage();
    });
  </script>
  <script>
    document.getElementById('googleLoginBtn').addEventListener('click', function() {
      initializeZkLogin();
    });
  </script>
@endpush
