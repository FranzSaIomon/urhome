<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal">
                    <i class="fas fa-key"></i> &nbsp;
                    Log In
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="vue-login" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-body container">
                    <div class="row">
                        <div class="col-md-12">
                            <input-group :errors="errors" :values="values" name="email" type="email" id="email" label="Email Address:" placeholder="Enter your email address here..." required></input-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input-group :errors="errors" :values="values" name="password" type="password" id="password" label="Password" placeholder="Enter your password here..." required></input-group>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! htmlFormSnippet() !!}
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 alert alert-success" hidden>
                            <b>Success!</b> You've successfully logged in, please wait to be redirected...
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" @click.prevent="login">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>