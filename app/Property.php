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
    public function listing_type() {return $this->hasOne("App\ListingType", 'id', 'ListingTypeID');}
    public function property_type() {return $this->hasOne("App\PropertyType", 'id', 'PropertyTypeID');}
    public function status() {return $this->hasOne("App\Status", 'id', 'StatusID');}
    public function property_amenity() {return $this->hasMany('App\PropertyAmenity', 'id', 'PropertyTypeID');}
    public function property_document(){return $this->hasOne('App\PropertyDocument', 'PropertyID', 'id');}

    public function user() {return $this->belongsTo('App\User', 'UserID', 'id');}
}
