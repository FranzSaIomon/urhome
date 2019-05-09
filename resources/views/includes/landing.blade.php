<div class="landing">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Find Your Next Home</h1>
            </div>
        </div>  
        <div class="row">
            <div class="col">
                <div class="btn-group md-auto" role="group" id="purpose" aria-label="Purpose">
                    <button type="button" class="btn btn-md" data-value="ren(t">For Rent</button>
                    <button type="button" class="btn btn-md" data-value="sale">For Sale</button>
                    <input type="hidden" name="purpose" value="all">
                </div>


                <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-sliders-h"></i>
                </button>

                <script>
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
                </script>
            </div>
        </div>
        <div class="row">
            <form action="" class="container">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <select class="custom-select custom-select-sm">
                            <option value="1">Townhouse</option>
                            <option value="2">Commercial</option>
                            <option value="3">Building</option>
                            <option value="4">Condominium</option>
                            <option value="5">Warehosue</option>
                            <option value="6">House</option>
                            <option value="7">Lot</option>
                            <option value="8">Beachfront</option>
                            <option value="9">Storage</option>
                            <option value="10">Office</option>
                            <option value="11">Island</option>
                            <option value="12">Memorial Lot</option>
                            <option value="13">Service Apartment</option>
                            <option value="14">Condotel</option>
                            <option value="15">Retail</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group iconed">
                            <i class="fas fa-search"></i>
                            <input type="text" name="q" id="q" placeholder="Search Here..." class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-block btn-sm btn-primary">
                    </div>
                </div>
            </form>
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
            <form action="">
                <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>