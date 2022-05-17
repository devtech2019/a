<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Banner
 * @mixin Model
 */
class Banner extends Model{


    protected $table = 'banners';


    protected $fillable = [
        'name',  'description', 'button_name', 'action_url', 'image' ,'type'
    ];

     /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'        => 'required|min:3|max:255',
        'description' => 'required|min:3|max:500',
        'button_name' => 'nullable|max:500',
        'action_url'  => 'nullable|max:500|url',
        'type'        => 'required',
        'image'       => 'required|image|max:6000|mimes:jpg,jpeg,png,bmp',
    ];

    
    

      /**
     * Get the url to the photo
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->urlForName($this->image);
    }

     
}
