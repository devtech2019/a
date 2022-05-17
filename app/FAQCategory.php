<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Client
 * @mixin Builder
 */
class FAQCategory extends Model
{
  

    protected $table = 'faq_categories';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    public function rules(Request $request)
    {  
    $data   =   $request->all(); 
      $rules = [
        // 'name' => 'required|min:3:max:255|unique:faq_categories',
    ];
    if(isset($data) && !empty($data)){
        $rules['name']    = 'required';
      
    }else{
        $rules['name']  = 'required|min:3:max:255|unique:faq_categories';
    }
    return $rules;
}

    /**
     * Get the faqs
     */
    public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FAQ::class, 'category_id')->orderBy('list_order');
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     * @return array
     */
    public static function getAllList(): array
    {
        return (new self)->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
