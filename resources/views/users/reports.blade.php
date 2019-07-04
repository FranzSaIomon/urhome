@extends('layouts.app')

@section('header')
@endsection
@section('content')
<div class="container w-50 mx-auto pt-5">
  <div class="row mb-5">
    <div class="col-md-12">
      <a href="javascript:window.print()" class="no-print btn btn-block btn-success">Print Report</a>
    </div>
  </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">Property Listings Posted</th>
                            <td scope="col">
                                {{count(Auth::user()->property)}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Properties w/ Panoramas</th>
                            @php
                                $sum = 0;

                                foreach (Auth::user()->property as $property) {
                                  $pd = App\PropertyDocument::where('PropertyID', $property->id)->first();

                                  if ($pd != null)
                                    $sum += count($pd->Images['3d']) > 0 ? 1 : 0;
                                }
                            @endphp
                            <td scope="col">{{$sum}}</td>
                        </tr>
                        <tr>
                            <th scope="col">Feedbacks Given</th>
                            <td scope="col">{{count(Auth::user()->feedback)}}</td>
                        </tr>
                    </tbody>
                </table>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Property Type</th>
                        <th scope="col">Listing Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col">Town House</th>
                        <td scope="col">
                            {{count(App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 1)->get())}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">House</th>
                        <td scope="col">
                            {{count(App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 2)->get())}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Condominium</th>
                        <td scope="col">
                            {{count(App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 3)->get())}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Condotel</th>
                        <td scope="col">
                            {{count(App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 4)->get())}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Service Apartment</th>
                        <td scope="col">
                            {{count(App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 5)->get())}}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Property Type</th>
                        <th scope="col">Average Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col">Town House</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 1)->get() as $property) {
                                $sumAvg += $property->feedback_value();
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">House</th>
                        <td scope="col">
                            @php
                                $sumAvg = 0;
                                $count = 0;
                                foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 2)->get() as $property) {
                                  $sumAvg += $property->feedback_value();
                                  $count++;
                                }
  
                                if ($count > 0)
                                  echo $sumAvg / $count;
                                else
                                  echo 0;
                            @endphp
                          </td>
                    </tr>
                    <tr>
                        <th scope="col">Condominium</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 3)->get() as $property) {
                                $sumAvg += $property->feedback_value();
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Condotel</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 4)->get() as $property) {
                                $sumAvg += $property->feedback_value();
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Service Apartment</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 5)->get() as $property) {
                                $sumAvg += $property->feedback_value();
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Property Type</th>
                        <th scope="col">Average Engagements</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col">Town House</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 1)->get() as $property) {
                                $sumAvg += intval($property->Views);
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">House</th>
                        <td scope="col">
                            @php
                                $sumAvg = 0;
                                $count = 0;
                                foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 2)->get() as $property) {
                                  $sumAvg += intval($property->Views);
                                  $count++;
                                }
  
                                if ($count > 0)
                                  echo $sumAvg / $count;
                                else
                                  echo 0;
                            @endphp
                          </td>
                    </tr>
                    <tr>
                        <th scope="col">Condominium</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 3)->get() as $property) {
                                $sumAvg += intval($property->Views);
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Condotel</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              $count = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 4)->get() as $property) {
                                $sumAvg += intval($property->Views);
                                $count++;
                              }

                              if ($count > 0)
                                echo $sumAvg / $count;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Service Apartment</th>
                        <td scope="col">
                          @php
                              $sumAvg = 0;
                              foreach (App\Property::where('UserID', Auth::id())->where('PropertyTypeID', 5)->get() as $property) {
                                $sumAvg += intval($property->Views);
                              }

                              if ($count > 0)
                                echo $sumAvg;
                              else
                                echo 0;
                          @endphp
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
