<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Bpocallaghan\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Client
 * @mixin Builder
 */
class FAQ extends Model
{
    
    protected $table = 'faqs';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'question'    => 'required|min:3:max:255',
        'answer'      => 'required|min:5:max:1500',
        'category_id' => 'required|exists:faq_categories,id',
    ];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugFrom('question');
    }

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getAnswerSummaryAttribute()
    {
        return substr(strip_tags($this->attributes['answer']), 0, 80) . '...';
    }

    /**
     * Get the category
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FAQCategory::class, 'category_id', 'id');
    }
}
