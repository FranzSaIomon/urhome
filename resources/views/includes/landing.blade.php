<div class="landing">
    <form action="properties/search" class="container">
        <input type="hidden" name="ignoreAdvanced" value="ignoreAdvanced">
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
                    @foreach (App\ListingType::all() as $item)
                        <button type="button" class="btn btn-md" data-value="{{ $item->id}}">For {{$item->ListingType}}</button>
                    @endforeach

                    <input type="hidden" name="purpose" value="all">
                </div>

            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <select name="type" class="custom-select custom-select-sm">
                            <option selected disabled>Select Property Type</option>
                            <option>All Property Types</option>
                            @foreach (App\PropertyType::all() as $item)
                                <option value="{{ $item->id }}">{{$item->PropertyType}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group iconed">
                            <i class="fas fa-search"></i>
                            <input type="text" name="query" id="q" placeholder="Search for property, developer, or location..." class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-block btn-sm btn-primary">
                    </div>
                </div>
            </div>
            <br/>
        </div>
    </form>
</div>

@include('includes.filter')

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
                $('[name=purpose]').val('0')

        })
        
        /* Modal Search */
        $("#advanced_purpose button").click((e) => {
            e.preventDefault()
            
            let prev = $("#advanced_purpose button.active").attr('data-value');
            
            $("#advanced_purpose button").removeClass("active")

            if (prev != $(e.target).attr('data-value')){
                $('#advanced_purpose [name=purpose]').val($(e.target).attr('data-value'))
                $(e.target).addClass('active')
            } else
                $('#advanced_purpose [name=purpose]').val('all')

        })
    })
</script>