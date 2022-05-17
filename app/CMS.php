<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @mixin \Eloquent
 */
class CMS extends Model
{
   

    protected $table = 'pages';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     *
     * @var array
     */
    static public $rules = [
        'name'          => 'required|min:3:max:255',
        'description'   => 'required|min:3:max:255',
        'slug'          => 'nullable',  
        //'banners'       => 'nullable',
        //'parent_id'     => 'nullable|exists:pages,id',
        //'url_parent_id' => 'nullable|exists:pages,id',
    ];

    /**
     * Get a the title + url concatenated
     *
     * @return string
     */
    public function getTitleUrlAttribute()
    {
        return $this->attributes['title'] . ' ( ' . $this->attributes['url'] . ' )';
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
        return self::orderBy('name')->get()->pluck('title_url', 'id')->toArray();
    }

    /**
     * Get the sections
     */
    public function sections()
    {
        return $this->hasMany(PageContent::class, 'page_id', 'id')->orderBy('list_order');
    }

    /**
     * Get the components
     */
    public function components()
    {
        return $this->hasMany(PageContent::class, 'page_id', 'id')->orderBy('list_order');
    }

    /**
     * Get the Banner many to many
     */
    public function banners()
    {
        return $this->belongsToMany(Banner::class)->isActiveDates()->orderBy('created_at', 'DESC');
    }

    /**
     * Get the PageContent many to many
     */
    public function pageContent()
    {
        return $this->belongsToMany(PageContent::class);
    }
}
