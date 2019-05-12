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
            <form action="" id="vue-filter">
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
                                        <slider :values="values" :errors="errors" label="Bedrooms" name="bedrooms" min=1 step=1 max=10></slider>
                                    </div>

                                    <div class="form-group">
                                        <slider :values="values" :errors="errors" label="Bathrooms" name="bathrooms" min=0 step=1 max=10></slider>
                                    </div>

                                    <div class="form-group">
                                        <slider :values="values" :errors="errors" label="Price Range" inclusive="true" name="price_range" min=0 max=1000000 currency="true"
                                        step=1 maximums="10000, 1000000, 10000000, 10000000, 1000000000" prefix="&#8369;"></slider>
                                    </div>

                                    <div class="form-group">
                                        <slider :values="values" :errors="errors" label="Lot Size" inclusive="true" name="lot_size" min="0" max="10000"
                                        step="1" maximums="100, 1000, 10000, 100000, 1000000, 10000000, 100000000" suffix="sqm."></slider>
                                    </div>
                                    
                                    <div class="form-group">
                                        <slider :values="values" :errors="errors" label="Floor Size" inclusive="true" name="floor_size" min="0" max="10000"
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
                                        <multi-select :values="values" :errors="errors" label="Property Type" name="property_type" :options="options"></multi-select>
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