<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginModalLabel">Welcome back!</h4>
      </div> -->
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: 0px 0px -22px 0px; padding: 8px 16px;">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body row">
        <div class="col-sm-6">
            <div class="left-login">
                <h3>Fast Login / SignUp</h3>
                <hr>
                <p>
                    Why not use your Social credentials to login quickly? Saves yourself some typing!
                </p>
                <a href="redirect/google">
                    <img src="img/google-sign-in-btn.png" style="max-width: 100%; overflow: hidden; max-height: 44px; margin: 0px 0px 0px -5px">
                </a>
            </div>
        </div><!-- end of col-md-8 -->
        <div class="col-sm-6">
            <div class="right-login">
                <h3>Slow Login</h3>
                <hr>
                <p>
                    If you have an account, provide the details below
                </p>
                <form class="" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <!-- <label for="email" class="control-label">E-Mail Address</label> -->
                        <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-envelope-o fa-fw"></i>&nbsp;
                          </div>
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Your email ID" required autofocus>
                        </div>
                        
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <!-- <label for="password" class="control-label">Password</label> -->
                        <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-key fa-fw"></i>&nbsp;
                          </div>
                          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div> -->

                    <div class="form-group">    
                        <button type="submit" class="btn btn-primary form-control">
                            Login
                        </button>
                        <!-- <p>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>    
                        </p> -->
                    </div>

                </form>
            </div>
        </div>
      </div><!-- end of modal-body -->

      <div class="modal-footer footer-login">
        <a class="btn btn-link pull-left" href="{{ route('password.request') }}">
            Forgot Password?
        </a>  
        <a class="btn btn-link pull-right" href="{{ route('register') }}">
            New User?
        </a>
      </div>
    </div>
  </div>
</div>