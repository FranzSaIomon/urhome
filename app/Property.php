<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        "Name","Description","Developer","LotNo","Street","City",
        "Country","YearBuilt","FloorArea","LotArea","Price",
        "NumberOfBedrooms","NumberOfBathrooms","CapacityOfGarage",
        "Verified","UserID","ListingTypeID","StatusID","PropertyTypeID"
    ];

    // Relationships
    public function listing_type() {return $this->hasOne("App\ListingType");}
    public function property_type() {return $this->hasOne("App\PropertyType");}
    public function status_type() {return $this->hasOne("App\Status");}
    public function property_amenities() {return $this->hasMany('App\PropertyAmenity');}
    public function user() {return $this->belongsTo('App\User');}
}
