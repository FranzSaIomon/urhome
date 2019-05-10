<div class="landing">
    <div class="container">
        <div class="row">
            <div class="col">
                <br/>
                <h1>Find Your Next Home</h1>
            </div>
        </div>  
        <div class="row">
            <div class="col">

                <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-sliders-h"></i>
                </button>
        
                <div class="btn-group md-auto" role="group" id="purpose" aria-label="Purpose">
                    <button type="button" class="btn btn-md" data-value="ren(t">For Rent</button>
                    <button type="button" class="btn btn-md" data-value="sale">For Sale</button>
                    <input type="hidden" name="purpose" value="all">
                </div>

            </div>
        </div>
        <div class="row">
            <form action="" class="container">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <select name="type" class="custom-select custom-select-sm">
                            <option value="1">Townhouse</option>
                            <option value="4">Condominium</option>
                            <option value="6">House</option>
                            <option value="13">Service Apartment</option>
                            <option value="14">Condotel</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group iconed">
                            <i class="fas fa-search"></i>
                            <input type="text" name="q" id="q" placeholder="Search for property, developer, or location..." class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-block btn-sm btn-primary">
                    </div>
                </div>
            </form>
            <br/>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="Property Filter" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Advanced Property Search</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="filter">
                    <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="search">Search</label>
                                            <input type="text" class="form-control form-control-sm" name="q" id="search" placeholder="Search for property, developer, or location...">
                                        </div>

                                        <div class="form-group">
                                            <label for="location">Location</label>
                                            <input type="text" name="location" id="location" class="form-control form-control-sm" placeholder="Location...">
                                        </div>

                                        <div class="form-group">
                                            <div class="slider">
                                                <slider label="Bedrooms" name="bedrooms" min=1 step=1 max=10></slider>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <slider label="Bathrooms" name="bathrooms" min=0 step=1 max=10></slider>
                                        </div>

                                        <div class="form-group">
                                            <slider label="Price Range" inclusive="true" name="price_range" min=0 max=1000000 currency="true"
                                            step=1 maximums="10000, 1000000, 10000000, 10000000, 1000000000" prefix="&#8369;"></slider>
                                        </div>

                                        <div class="form-group">
                                            <slider label="Lot Size" inclusive="true" name="lot_size" min="0" max="10000"
                                            step="1" maximums="100, 1000, 10000, 100000, 1000000, 10000000, 100000000" suffix="sqm."></slider>
                                        </div>
                                        
                                        <div class="form-group">
                                            <slider label="Floor Size" inclusive="true" name="floor_size" min="0" max="10000"
                                            step="1" maximums="100, 1000, 10000, 100000, 1000000, 10000000, 100000000" suffix="sqm."></slider>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="advanced_purpose">Purpose</label>
                                            <div id="advanced_purpose">
                                                <button type="button" class="btn btn-md btn-outline-primary" data-value="rent">For Rent</button>
                                                <button type="button" class="btn btn-md btn-outline-primary" data-value="sale">For Sale</button>
                                                <input type="hidden" name="advanced_purpose" value="all">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <multi-select label="Property Type" name="property_type" v-bind:options="[
                                                {name: 'Townhouse', value: 1},
                                                {name: 'Condominium', value: 4},
                                                {name: 'House', value: 6},
                                                {name: 'Lot', value: 7},
                                                {name: 'Service Apartment', value: 13},
                                                {name: 'Condotel', value: 14},
                                                {name: 'Retail', value: 15},
                                            ]"></multi-select>
                                        </div>

                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" class="btn btn-block btn-primary" value="Submit"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        /* Landing Search */
        $("#purpose button").click((e) => {
            e.preventDefault()

            let prev = $("#purpose button.selected").attr('data-value');
            
            $("#purpose button").removeClass("selected")

            if (prev != $(e.target).attr('data-value')){
                $('[name=purpose]').val($(e.target).attr('data-value'))
                $(e.target).addClass('selected')
            } else
                $('[name=purpose]').val('all')

        })
        
        /* Modal Search */
        $("#advanced_purpose button").click((e) => {
            e.preventDefault()
            
            let prev = $("#advanced_purpose button.active").attr('data-value');
            
            $("#advanced_purpose button").removeClass("active")

            if (prev != $(e.target).attr('data-value')){
                $('[name=advanced_purpose]').val($(e.target).attr('data-value'))
                $(e.target).addClass('active')
            } else
                $('[name=advanced_purpose]').val('all')

        })
    })
</script>