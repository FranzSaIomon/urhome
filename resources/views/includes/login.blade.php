<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="vue-login" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModal">
                        <i class="fas fa-key"></i> &nbsp;
                        <span v-if="loginForm">Log In</span>
                        <span v-else>Forgot Password</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    @csrf
                    <div class="modal-body container" v-if="loginForm">
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
                                <input-group type="check" :errors="errors" :values="values" name="remember" id="remember" label="Remember Me"></input-group>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LfOcKIUAAAAAF-EhW6-UjKgi_y3IUdRErtqcT5N"></div>
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="success">
                            <div class="col-md-12">
                                <div class="alert alert-success" v-html="success">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="info">
                            <div class="col-md-12">
                                <div class="alert alert-info" v-html="info">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body container" v-else>
                        <div class="row">
                            <div class="col-md-12">
                                <input-group :errors="errors" :values="values" name="email" type="email" id="email" label="Email Address:" placeholder="Enter your email address here..." required></input-group>
                            </div>
                        </div>

                        <div class="row" v-if="success">
                            <div class="col-md-12">
                                <div class="alert alert-success" v-html="success">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="info">
                            <div class="col-md-12">
                                <div class="alert alert-info" v-html="info">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5 align-self-center px-2">
                                    <a href="#" @click.prevent="changeForm" v-if="loginForm">Forgot Your Password</a>
                                    <a href="#" @click.prevent="changeForm" v-else>Log in to your account</a>
                                </div>
                                <div class="col-md-4 px-2">
                                    <button type="submit" class="btn btn-block btn-primary" @click.prevent="loginForm ? login() : reset()">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                        <span v-if="loginForm">Log In</span>
                                        <span v-else>Reset Password</span>
                                    </button>
                                </div>
                                <div class="col-md-3 px-2">
                                    <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal" @click.prevent="changeForm">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>