<?php

namespace App\Models;

use App\Mail\NotificationTemplateMail;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'order_product';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'sku',
        'price',
        'price_with_tax',
        'quantity'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    public $timestamps = false;
   
    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS VARIABLES
    |--------------------------------------------------------------------------
    */
  
    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */
   
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
 
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function products()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    public function orders()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
   
}
