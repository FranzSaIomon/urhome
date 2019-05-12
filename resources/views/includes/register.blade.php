<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModal">
                    <i class="fas fa-clipboard"></i> &nbsp;
                    Register
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="vue-register" action="{{ route('register') }}">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values" name="email" type="email" id="regEmail" label="Email Address" placeholder="example@example.com" required></input-group>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values" name="password" type="password" id="regPassword" label="Password" placeholder="Secret" required></input-group>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values" name="password_confirmation" type="password" id="regPasswordC" label="Password Confirmation" placeholder="Secret x2" required></input-group>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <toggle-button label="Account Type" :errors="errors" :values="values" type="joined" :toggles="toggles" name="UserType" id="userType" required></toggle-button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input-group :errors="errors" :values="values" name="FirstName" id="firstName" label="First Name" placeholder="John" required></input-group>
                                    </div>
                                    <div class="col-md-6">
                                        <input-group :errors="errors" :values="values" name="LastName" id="lastName" label="Last Name" placeholder="Doe" required></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values" name="BirthDate" id="birthDate" label="Birth Date" type="date"></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values" name="ContactNo" id="contactNo" label="Mobile Number" placeholder="(+63) 123 456 7890"></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Address</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values" name="LotNo" id="lotNo" placeholder="Lot #"></input-group>
                                            </div>
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values" name="Street" id="street" placeholder="Street"></input-group>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values" name="City" type="city" id="city" placeholder="City" required></input-group>
                                            </div>
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values" name="Country" type="country" id="country" placeholder="-- Country --" required></input-group>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 alert alert-success" hidden>
                                <b>Success!</b> You've successfully registered, please wait to be redirected...
                            </div>
                        </div>
                    </div>    
                </select>
                
                </div>
                <div class="modal-footer container">
                    <div class="row">
                        <div class="col-lg-8 small text-muted">
                            By signing up, you certify that you are of Philippine 
                            <span class="flag-icon flag-icon-ph"></span>
                            legal age (18 years old and above) and agree to our
                            <a href="#">terms and conditions</a>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-block btn-primary" @click.prevent="register">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>